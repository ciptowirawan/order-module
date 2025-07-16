<?php

namespace App\Http\Controllers\Dashboard;

use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Uuid;
use App\Models\Event;
use App\Models\Pendaftaran;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use libphonenumber\PhoneNumberUtil;
use App\Http\Controllers\Controller;
use libphonenumber\PhoneNumberFormat;
use Illuminate\Support\Facades\Redirect;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Validation\ValidationException;

class ParticipantController extends Controller
{
    public function index_unpaid(Request $request)
    {
        $search = $request->search;
        $today = Carbon::now();

        $pendaftaran = User::select(
            'users.*',
            // Use an aggregate function for orders.amount
            DB::raw('MAX(orders.amount) as amount'),
            'users.email_verified_at'
        )
            ->leftJoin('orders', 'orders.user_id', 'users.id')
            ->where(function ($query) use ($today) {
                // Condition 1: Regular PENDING users
                $query->where('users.status', 'PENDING')
                      ->where('users.registrant_tag', 'REGULAR');
            })
            ->orWhere(function ($query) use ($today) {
                // Condition 2: Inactive Members
                $query->where('users.registrant_tag', 'MEMBER')
                      ->whereNotNull('users.member_activate_in')
                      ->whereNotNull('users.member_over_in')
                      ->whereDate('users.member_over_in', '<', $today);
            })
            ->where(function ($query) use ($search) {
                $query->orWhere('users.full_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('users.title', 'LIKE', '%'.$search.'%')
                    ->orWhere('users.club_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('users.district', 'LIKE', '%'.$search.'%');
            })
            ->groupBy('users.id') // Group by the user's ID to get unique users
            ->orderBy('users.id')
            ->paginate(20);

        return view('manage.participant.index-unpaid', compact('pendaftaran'));
    }

    public function index_event_participant() {
        $events = Event::whereNotNull('registration_start_at')->get();
        $purpose = "1";

        return view('manage.participant.index-event', compact('events', 'purpose'));
    }
    public function index_event_hadir() {
        $events = Event::whereNotNull('registration_start_at')->get();
        $purpose = "3";

        return view('manage.participant.index-event', compact('events', 'purpose'));
    }
    public function index_event_tidak_hadir() {
        $events = Event::whereNotNull('registration_start_at')->get();
        $purpose = "2";

        return view('manage.participant.index-event', compact('events', 'purpose'));
    }

    public function index_paid(Request $request)
    {
        $search = $request->search;
        $today = Carbon::today(); // Get today's date

        $pendaftaran = User::where('users.status', 'SUCCESS')
            ->where('users.registrant_tag', 'MEMBER') // Ensure registrant_tag is 'MEMBER'
            ->where('users.member_over_in', '>=', $today) // Check member_over_in is not in the past
            ->where(function ($query) use ($search) {
                $query->orWhere('users.full_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('users.title', 'LIKE', '%' . $search . '%')
                    ->orWhere('users.club_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('users.district', 'LIKE', '%' . $search . '%');
            })
            ->orderBy('users.id')
            ->paginate(20);

        return view('manage.participant.index-paid', compact('pendaftaran'));
    }

    public function sortPaidParticipantsByDistrict(Request $request, string $district) {
        $search = $request->search;
        
        $today = Carbon::now();
        $pendaftaran = User::where('users.status', 'SUCCESS')
            ->where('users.registrant_tag', 'MEMBER') // Ensure registrant_tag is 'MEMBER'
            ->where('users.member_over_in', '>=', $today) // Check member_over_in is not in the past
            ->where('users.district', $district)
            ->where(function ($query) use ($search) {
                $query->orWhere('users.full_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('users.title', 'LIKE', '%' . $search . '%')
                    ->orWhere('users.club_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('users.district', 'LIKE', '%' . $search . '%');
            })
            ->orderBy('users.id')
            ->paginate(20);

        return view('manage.participant.index-paid', compact('pendaftaran'));
    }
    
    public function exportUnpaidParticipantsAsPdf() {
        $today = Carbon::now();
        $participants = User::select(
            'users.*',
            // Use an aggregate function for orders.amount
            DB::raw('MAX(orders.amount) as amount'),
            'users.email_verified_at'
        )
            ->leftJoin('orders', 'orders.user_id', 'users.id')
            ->where(function ($query) use ($today) {
                // Condition 1: Regular PENDING users
                $query->where('users.status', 'PENDING')
                      ->where('users.registrant_tag', 'REGULAR');
            })
            ->orWhere(function ($query) use ($today) {
                // Condition 2: Inactive Members
                $query->where('users.registrant_tag', 'MEMBER')
                      ->whereNotNull('users.member_activate_in')
                      ->whereNotNull('users.member_over_in')
                      ->whereDate('users.member_over_in', '<', $today);
            })
            ->groupBy('users.id') // Group by the user's ID to get unique users
            ->orderBy('users.id')->get();

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $inactiveCounts = $participants->groupBy('district')->map(function ($districtParticipants) {
            return $districtParticipants->count();
        });
    
        // Find the district with the most inactive members
        $mostInactiveDistrictCount = $inactiveCounts->sortDesc()->first();
        $districtWithMostInactive = $inactiveCounts->search($mostInactiveDistrictCount);

        $leastInactiveDistrictCount = $inactiveCounts->sort()->first(); // Sort in ascending order
        $districtWithLeastInactive = $inactiveCounts->search($leastInactiveDistrictCount);

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-unpaid', compact('participants', 'mostInactiveDistrictCount', 'districtWithMostInactive', 'leastInactiveDistrictCount', 'districtWithLeastInactive'));

        return $pdf->download('Unpaid_members.pdf');
    }

    public function exportPaidAsPdfParticipantsByDistrict(string $district) {
        
        $today = Carbon::now();
        $participants = User::where('users.status', 'SUCCESS')
            ->where('users.registrant_tag', 'MEMBER') // Ensure registrant_tag is 'MEMBER'
            ->where('users.member_over_in', '>=', $today) // Check member_over_in is not in the past
            ->where('users.district', $district)
            ->orderBy('users.id')
            ->get();

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-paid', compact('participants', 'district'));

        return $pdf->download('Active_members_' .$district. '.pdf');
    }

    public function exportPaidParticipantsAsPdf() {
        $today = Carbon::now();
        $participants = User::where('users.status', 'SUCCESS')
            ->where('users.registrant_tag', 'MEMBER') // Ensure registrant_tag is 'MEMBER'
            ->where('users.member_over_in', '>=', $today) // Check member_over_in is not in the past
            ->orderBy('users.id')
            ->get();

        $district = "All";

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-paid', compact('participants', 'district'));

        return $pdf->download('Active_members.pdf');
    }
    
    public function show(User $member) {

        $uuid = Uuid::where('user_id', $member->id)->first();

        return View('details.user-detail', compact('member', 'uuid'));
    }

    public function showRegistrant(Registration $member) {

        return View('details.registrant-detail', compact('member'));
    }


}
