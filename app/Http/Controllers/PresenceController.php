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

        $pendaftaran = Registration::select(
            'registrations.*',
            'payments.amount',
            'payments.status',
            'users.email_verified_at',
        )->leftJoin('users', 'users.id', 'registrations.user_id'
        )->leftJoin('payments', 'payments.pendaftaran_id', 'pendaftaran.id'        
        )->where('payments.status', 'paid'
        )->WhereNull('registrations.status_kehadiran'
        )->Where(function ($query) use ($search) {
            $query->orWhere('registrations.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.status_kehadiran', 'LIKE', '%'.$search.'%');
        })->paginate(20);

        return view('manage.participant.index-presence', compact('pendaftaran'));
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
