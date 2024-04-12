<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
    public function index() {

        if (auth()->user()->hasRole('admin')) {

            $registrations = Pendaftaran::with('payment')->with('user')->get();

            $totalRegistrants = $registrations->count();
            $totalPaidRegistrants = $registrations->filter(function($registration) {
                return $registration->payment->status == 'paid';
            })->count();
            $totalUnpaidRegistrants = $registrations->filter(function($registration) {
                return $registration->user->email_verified_at != null && $registration->payment->status == 'unpaid';
            })->count();
            $totalNotIdentifiedRegistrants = $registrations->filter(function($registration) {
                return $registration->user->email_verified_at == null;
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
            $Lion = $registrations->where('registration_type', 'Lion')->count();
            $Leo = $registrations->where('registration_type', 'Leo')->count();
            $Adult = $registrations->where('registration_type', 'Adult Guest')->count();

            $CC_percent = $totalRegistrants == 0 ? 0 : ($CC / $totalRegistrants) * 100;
            $DG_percent = $totalRegistrants == 0 ? 0 : ($DG / $totalRegistrants) * 100;
            $PCC_percent = $totalRegistrants == 0 ? 0 : ($PCC / $totalRegistrants) * 100;
            $PDG_percent = $totalRegistrants == 0 ? 0 : ($PDG / $totalRegistrants) * 100;
            $RC_percent = $totalRegistrants == 0 ? 0 : ($RC / $totalRegistrants) * 100;
            $ZC_percent = $totalRegistrants == 0 ? 0 : ($ZC / $totalRegistrants) * 100;
            $CP_percent = $totalRegistrants == 0 ? 0 : ($CP / $totalRegistrants) * 100;
            $CS_percent = $totalRegistrants == 0 ? 0 : ($CC / $totalRegistrants) * 100;
            $Unknown_percent = $totalRegistrants == 0 ? 0 : ($unknownTitle / $totalRegistrants) * 100;
            $Lion_percent = $totalRegistrants == 0 ? 0 : ($Lion / $totalRegistrants) * 100;
            $Leo_percent = $totalRegistrants == 0 ? 0 : ($Leo / $totalRegistrants) * 100;
            $Adult_percent = $totalRegistrants == 0 ? 0 : ($Adult / $totalRegistrants) * 100;

            return View('dashboard.index-admin', compact('totalRegistrants', 'totalPaidRegistrants', 'totalUnpaidRegistrants', 'totalNotIdentifiedRegistrants', 'registrationsByMonth', 'CC_percent', 'DG_percent', 'PCC_percent', 'PDG_percent', 'RC_percent', 'ZC_percent', 'CP_percent', 'CS_percent', 'Unknown_percent', 'Lion_percent', 'Leo_percent', 'Adult_percent'));
        } else {

            $pendaftaran = Pendaftaran::where('user_id',auth()->user()->id)->with('payment')->first();
    
            $historicalData = json_decode($pendaftaran->historical_data, true);

            $history = 0;
            
            if ($historicalData !== null) {
                foreach ($historicalData as $index => $subArray) {
                    $history = count($subArray);
                } 
            }

            return View('dashboard.index', compact('pendaftaran', 'history'));
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
}
