<?php

namespace App\Http\Controllers\Dashboard;

use Validator;
use App\Models\User;
use App\Models\Uuid;
use App\Models\Order;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function index() {

        if (auth()->user()->hasRole('admin|admin-administrator')) {

            $registrations = User::all();

            $totalRegistrants = $registrations->count();
            $paidRegistrants = $registrations->filter(function($registration) {
                return $registration->status == 'SUCCESS';
            });
            $totalPaidRegistrants = $paidRegistrants->count();
            $totalUnpaidRegistrants = $registrations->filter(function($registration) {
                return $registration->status == 'PENDING';
            })->count();
            $totalNotIdentifiedRegistrants = $registrations->filter(function($registration) {
                return $registration->member_activate_in == null;
            })->count();

            $registrationsByMonth = $registrations->groupBy(function($registration) {
                return $registration->created_at->format('m'); // Extract month part from the created_at date
            })->map(function($registrations) {
                return $registrations->count();
            });

            'Council Chairperson, District Governor, Past Council Chairperson, Past District Governor, Region Chairperson, Zone Chairperson, Club President, Club Secretary';

            $CC = $registrations->where('title', 'Council Chairperson')->count();
            $DG = $registrations->where('title', 'District Governor')->count();
            $PCC = $registrations->where('title', 'Past Council Chairperson')->count();
            $PDG = $registrations->where('title', 'Past District Governor')->count();
            $RC = $registrations->where('title', 'Region Chairperson')->count();
            $ZC = $registrations->where('title', 'Zone Chairperson')->count();
            $CP = $registrations->where('title', 'Club President')->count();
            $CS = $registrations->where('title', 'Club Secretary')->count();
            $unknownTitle = $registrations->where('title', null)->count();
            // $Lion = $registrations->where('registration_type', 'Lion')->count();
            // $Leo = $registrations->where('registration_type', 'Leo')->count();
            // $Adult = $registrations->where('registration_type', 'Adult Guest')->count();

            $A1 = $paidRegistrants->where('district', 'MD307-A1')->count();
            $A2 = $paidRegistrants->where('district', 'MD307-A2')->count();
            $B1 = $paidRegistrants->where('district', 'MD307-B1')->count();
            $B2 = $paidRegistrants->where('district', 'MD307-B2')->count();
            $Others = $paidRegistrants->where('district', 'Others')->count();

            $A1_percent = $totalPaidRegistrants == 0 ? 0 : ($A1 / $totalPaidRegistrants) * 100;
            $A2_percent = $totalPaidRegistrants == 0 ? 0 : ($A2 / $totalPaidRegistrants) * 100;
            $B1_percent = $totalPaidRegistrants == 0 ? 0 : ($B1 / $totalPaidRegistrants) * 100;
            $B2_percent = $totalPaidRegistrants == 0 ? 0 : ($B2 / $totalPaidRegistrants) * 100;
            $Others_percent = $totalPaidRegistrants == 0 ? 0 : ($Others / $totalPaidRegistrants) * 100;

            $CC_percent = $totalRegistrants == 0 ? 0 : ($CC / $totalRegistrants) * 100;
            $DG_percent = $totalRegistrants == 0 ? 0 : ($DG / $totalRegistrants) * 100;
            $PCC_percent = $totalRegistrants == 0 ? 0 : ($PCC / $totalRegistrants) * 100;
            $PDG_percent = $totalRegistrants == 0 ? 0 : ($PDG / $totalRegistrants) * 100;
            $RC_percent = $totalRegistrants == 0 ? 0 : ($RC / $totalRegistrants) * 100;
            $ZC_percent = $totalRegistrants == 0 ? 0 : ($ZC / $totalRegistrants) * 100;
            $CP_percent = $totalRegistrants == 0 ? 0 : ($CP / $totalRegistrants) * 100;
            $CS_percent = $totalRegistrants == 0 ? 0 : ($CC / $totalRegistrants) * 100;
            $Unknown_percent = $totalRegistrants == 0 ? 0 : ($unknownTitle / $totalRegistrants) * 100;
            // $Lion_percent = $totalRegistrants == 0 ? 0 : ($Lion / $totalRegistrants) * 100;
            // $Leo_percent = $totalRegistrants == 0 ? 0 : ($Leo / $totalRegistrants) * 100;
            // $Adult_percent = $totalRegistrants == 0 ? 0 : ($Adult / $totalRegistrants) * 100;

            return View('dashboard.index-admin', compact('totalRegistrants', 'totalPaidRegistrants', 'totalUnpaidRegistrants', 'totalNotIdentifiedRegistrants', 'registrationsByMonth', 'CC_percent', 'DG_percent', 'PCC_percent', 'PDG_percent', 'RC_percent', 'ZC_percent', 'CP_percent', 'CS_percent', 'Unknown_percent', 'A1', 'A2', 'B1', 'B2', 'Others', 'A1_percent', 'A2_percent', 'B1_percent', 'B2_percent', 'Others_percent', 'CC', 'DG', 'PCC', 'PDG', 'RC', 'ZC', 'CP', 'CS', 'unknownTitle'
            // 'Lion_percent', 'Leo_percent', 'Adult_percent'
            ));
        }
        if (auth()->user()->hasRole('user')) {

            $member = User::where('id',auth()->user()->id)->first();

            $uuid = Uuid::where('user_id', auth()->user()->id)->first();

            $amount = Order::where('user_id', auth()->user()->id)->where('status', 'PENDING')->value('amount');
    
            // $historicalData = json_decode($pendaftaran->historical_data, true);

            // $history = 0;
            
            // if ($historicalData !== null) {
            //     foreach ($historicalData as $index => $subArray) {
            //         $history = count($subArray);
            //     } 
            // }

            return View('dashboard.index-group', compact('member', 'uuid','amount'));
        //     $pendaftar = Pendaftaran::where('user_id',auth()->user()->id)->with('payment')->first();
        //     if ($pendaftar->payment->status == 'unpaid') {
        //         return View('dashboard.payment', compact('pendaftar'));
        //     } else {
        //         return View('dashboard.index', compact('pendaftar'));
        //         $pendaftaran = Pendaftaran::where('user_id', $id)->with('user')->with('payment')->first();
        
        //         $historicalData = json_decode($pendaftaran->historical_data, true);
                
        //         foreach ($historicalData as $index => $subArray) {
        //             $history = count($subArray);
        // } 
        //     }
        }
    }

    public function form_password() {
        return view('dashboard.password.edit');
    }

    public function change_password(Request $request) {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'old_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]); 
        
        // if there's error
        if (count($validator->errors()->toArray()) > 0) {
            $error_message = $validator->errors()->all();
            $error = ValidationException::withMessages($error_message);

            // Concatenate error messages into a single string with bullet points
            $errorList = '<ul>';
            foreach ($error_message as $message) {
                $errorList .= '<li>' . $message . '</li><br>';
            }
            $errorList .= '</ul>';

            // Create a SweetAlert toast with the error messages
            Alert::html('Validation Errors', $errorList, 'error')->autoClose(false);
            return Redirect::back()->with('toast_error')->withInput($request->input())->withErrors($validator);
        }

        if (!Hash::check($request->old_password, $user->password)) {

            Alert::error('Current password is incorrect')->autoClose(false);
            
            return Redirect::back()
                ->with('toast_error', 'Current password is incorrect')
                ->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Alert::success('Success!', 'Changes has been updated!');

        return redirect('/dashboard')->with('success', 'Password has been changed successfully!');
    }
}
