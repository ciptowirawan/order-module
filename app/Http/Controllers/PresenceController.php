<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Uuid;
use App\Models\Registration;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PresenceController extends Controller
{
    public function index(Request $request) {
        $search = $request->search;

        $pendaftaran = Registration::WhereNull('registrations.status_kehadiran'
        )->Where(function ($query) use ($search) {
            $query->orWhere('registrations.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.title', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.club_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.district', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.status_kehadiran', 'LIKE', '%'.$search.'%');
        })->paginate(20);

        return view('manage.participant.index-presence', compact('pendaftaran'));
    }

    public function index_participants(Request $request) {
        $search = $request->search;

        $pendaftaran = Registration::Where(function ($query) use ($search) {
            $query->orWhere('registrations.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.title', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.club_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.district', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.status_kehadiran', 'LIKE', '%'.$search.'%');
        })->with('user')->paginate(20);

        return view('manage.participant.index-participants', compact('pendaftaran'));
    }

    public function index_attended(Request $request) {
        $search = $request->search;

        $pendaftaran = Registration::Where('registrations.status_kehadiran', 'HADIR'
        )->Where(function ($query) use ($search) {
            $query->orWhere('registrations.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.title', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.club_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.district', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.status_kehadiran', 'LIKE', '%'.$search.'%');
        })->paginate(20);

        return view('manage.participant.index-attended', compact('pendaftaran'));
    }

    public function sortAttendedByDistrict(Request $request, string $district) {
        $search = $request->search;

        $pendaftaran = Registration::Where('registrations.status_kehadiran', 'HADIR'
        )->Where('district', $district)
        ->Where(function ($query) use ($search) {
            $query->orWhere('registrations.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.title', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.club_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.district', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.status_kehadiran', 'LIKE', '%'.$search.'%');
        })->paginate(20);

        return view('manage.participant.index-attended', compact('pendaftaran'));
    }

    public function sortParticipantsByDistrict(Request $request, string $district) {
        $search = $request->search;

        $pendaftaran = Registration::Where('district', $district)
        ->Where(function ($query) use ($search) {
            $query->orWhere('registrations.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.title', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.club_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.district', 'LIKE', '%'.$search.'%');
        })->with('user')->paginate(20);

        return view('manage.participant.index-participants', compact('pendaftaran'));
    }

    public function exportParticipantsByDistrict(string $district) {
        
        $participants = Registration::where('district', $district)->get();

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-participants', compact('participants', 'district'));

        return $pdf->download('Event_participants_' .$district. '.pdf');
    }

    public function exportUnattendedParticipantsByDistrict(string $district) {
        
        $participants = Registration::WhereNull('registrations.status_kehadiran'
        )->where('district', $district)->get();

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $unattendedCount = $participants->count();

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-unattended', compact('participants', 'district', 'unattendedCount'));

        return $pdf->download('Unattended_participants_' .$district. '.pdf');
    }

    public function exportAttendedParticipantsByDistrict(string $district) {
        
        $participants = Registration::Where('registrations.status_kehadiran', 'HADIR'
        )->where('district', $district)->get();

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-attended', compact('participants', 'district'));

        return $pdf->download('Attended_participants_' .$district. '.pdf');
    }

    public function checkPresence(Request $request)
    {
        if (auth()->user()->hasRole(['admin'])) {
            $uuidData = Uuid::where('uuid', $request->input('uuid'))->first();        
            // Get the current date and time
            $now = Carbon::now();

            $registrant = Registration::where('user_id', $uuidData->user_id)->first();
            if ($registrant === null) {
                return response()->json(['error' => 'This member has not registered on this event yet.'], 400);
            }
        
            // Check if the current date and time is the same or after the valid_on date
            if ($now->greaterThanOrEqualTo(Carbon::parse($uuidData->valid_on))) {
                // Update the presence status
                    $registrant->update([
                        "status_kehadiran" => "HADIR"
                    ]);
        
                return response()->json(['success' => 'UUID is valid, presence confirmed.'], 200);
            } else {
                return response()->json(['error' => 'UUID is not yet valid.'], 400);
            }
        } else {
            return response()->json(['redirect' => 'Redirect to User Detail'], 404);
        }
    }

    public function showCheckStatus(Request $request) {
    
        $response = $this->checkPresence($request);

        $responseData = json_decode($response->getContent(), true);        

        if (isset($responseData['error'])) {
            Alert::error('Error', $responseData['error']);
            return redirect('/dashboard')->with('error', $responseData['error']);
        }

        if (isset($responseData['redirect'])) {
            return redirect('/dashboard');
        }

        Alert::success('Success', $responseData['success']);
        return redirect('/dashboard')->with('success', $responseData['success']);
    }
}
