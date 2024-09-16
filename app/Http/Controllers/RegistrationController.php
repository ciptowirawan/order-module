<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use libphonenumber\PhoneNumberUtil;
use PragmaRX\Countries\Package\Countries;
use App\Http\Controllers\Api\RegistrationApiController;

class RegistrationController extends RegistrationApiController
{
    public function index_info() {
        return View('register-information.index');
    }

    public function index() {
        return View('register.index');
    }

    public function form(Request $request) {
        $purpose = "individual"; // this controls which registration type executed


        $countriesData = Countries::all();

        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $countries = [];

        foreach ($countriesData as $country) {
            $region = $country->cca2; // Use cca2 for ISO 3166-1 alpha-2 code
            $phoneCode = $phoneNumberUtil->getCountryCodeForRegion($region);

            // Store both country name and phone code
            $countries[] = [
                'name' => $country->name->common,
                'code' => $phoneCode,
            ];
        }

        usort($countries, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        $chosenCode = null;

        if ($request->input('selectedValue') !== null) {
            $selectedValue = $request->input('selectedValue');

            $countriesCollection = collect($countries);
            $filteredCountries = $countriesCollection->where('name', $selectedValue)->first();
            $chosenCode = $filteredCountries['code'];
            
            return response()->json(['result' => 'success', 'data' => $chosenCode]);
        }

        return View('register.form', compact('countries', 'purpose'));
    }

    public function store_member(Request $request) {
        $response = $this->store($request)->getData(true);

        if (isset($response['errors'])) {
            return back()->withErrors($response['errors'])->withInput();
        }
    
        return redirect('/dashboard')->with('success', 'Kami telah mengirimkan tautan verifikasi ke Alamat Email anda. Silahkan cek email anda dan ikuti instruksinya untuk melanjutkan proses verifikasi email.');
    }

    public function store_event_participant(Request $request) {
        $response = $this->store_participant($request)->getData(true);
    
        return redirect('/dashboard')->with('success', 'Pendaftaran Kegiatan Berhasil!');
    }
}
