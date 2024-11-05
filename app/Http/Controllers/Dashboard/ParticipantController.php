<?php

namespace App\Http\Controllers\Dashboard;

use Validator;
use App\Models\User;
use App\Models\Uuid;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use libphonenumber\PhoneNumberUtil;
use App\Http\Controllers\Controller;
use libphonenumber\PhoneNumberFormat;
use Illuminate\Support\Facades\Redirect;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Validation\ValidationException;

class ParticipantController extends Controller
{
    public function index_unpaid(Request $request) {
        $search = $request->search;

        $pendaftaran = User::select(
            'users.*',
            'orders.amount',            
            'users.email_verified_at',
        )->leftJoin('orders', 'orders.user_id', 'users.id'
        )->where('users.status', 'PENDING'
        )->where('users.registrant_tag', 'REGULAR'
        )->Where(function ($query) use ($search) {
            $query->orWhere('users.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('users.title', 'LIKE', '%'.$search.'%'
            )->orWhere('users.club_name', 'LIKE', '%'.$search.'%'
            )->orWhere('users.district', 'LIKE', '%'.$search.'%');
        })
        ->orderBy('users.id')
        ->paginate(20);

        return view('manage.participant.index-unpaid', compact('pendaftaran'));
    }

    public function index_paid(Request $request) {
        $search = $request->search;

        $pendaftaran = User::where('users.status', 'SUCCESS'
        )->where('users.registrant_tag', 'MEMBER'
        )->Where(function ($query) use ($search) {
            $query->orWhere('users.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('users.title', 'LIKE', '%'.$search.'%'
            )->orWhere('users.club_name', 'LIKE', '%'.$search.'%'
            )->orWhere('users.district', 'LIKE', '%'.$search.'%');
        })
        ->orderBy('users.id')
        ->paginate(20);

        return view('manage.participant.index-paid', compact('pendaftaran'));
    }

    public function sortPaidParticipantsByDistrict(Request $request, string $district) {
        $search = $request->search;
        
        $pendaftaran = User::where('users.status', 'SUCCESS'
        )->where('users.registrant_tag', 'MEMBER'
        )->where('users.district', $district
        )->Where(function ($query) use ($search) {
            $query->orWhere('users.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('users.title', 'LIKE', '%'.$search.'%'
            )->orWhere('users.club_name', 'LIKE', '%'.$search.'%');
        })
        ->orderBy('users.id')
        ->paginate(20);

        return view('manage.participant.index-paid', compact('pendaftaran'));
    }
    
    public function exportUnpaidParticipantsAsPdf() {
        $participants = User::select(
            'users.*',
            'orders.amount',            
            'users.email_verified_at',
        )->leftJoin('orders', 'orders.user_id', 'users.id'
        )->where('users.status', 'PENDING'
        )->where('users.registrant_tag', 'REGULAR'
        )->orderBy('users.id')->get();

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
        
        $participants = User::where('users.status', 'SUCCESS'
        )->where('users.registrant_tag', 'MEMBER'
        )->where('users.district', $district
        )->orderBy('users.id')->get();

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-paid', compact('participants', 'district'));

        return $pdf->download('Active_members_' .$district. '.pdf');
    }

    public function exportPaidParticipantsAsPdf() {
        $participants = User::where('users.status', 'SUCCESS'
        )->where('users.registrant_tag', 'MEMBER'
        )->orderBy('users.id')->get();

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

}
