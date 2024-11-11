<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use libphonenumber\PhoneNumberUtil;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Validation\ValidationException;
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
    
        return redirect('/dashboard')->with('success', 'Terima kasih telah melakukan registrasi sebagai anggota. Silahkan salin nomor Virtual Account dibawah ini untuk melakukan pembayaran.');
    }

    public function store_event_participant(Request $request) {
        $response = $this->store_participant($request)->getData(true);

        if (isset($response['error'])) {
            Alert::error('Maaf!', $response['error']);
        } else {
            Alert::success('Pendaftaran Kegiatan Berhasil!', 'Anda telah berhasil mendaftarkan diri pada kegiatan ini.');
        }

        return redirect('/');
    }

    public function edit(Request $request, User $member) {                

        $countriesData = Countries::all();

        $titles = [
            'Council Chairperson',
            'District Governor',
            'Past Council Chairperson',
            'Past District Governor',
            'Region Chairperson',
            'Zone Chairperson',
            'Club President',
            'Club Secretary'
        ];

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

        
        // Trim the first digit of the phone number based on selected country's code
        // $memberCountryCode = $phoneNumberUtil->getCountryCodeForRegion($member->country);
        $memberCountryCode = null;
        foreach ($countries as $country) {
            if ($country['name'] === $member->country) {
                $memberCountryCode = $country['code'];
                break;
            }
        }
        $phoneNumber = substr($member->phone_number, strlen($memberCountryCode));
        $alternatePhoneNumber = substr($member->alternate_phone_number, strlen($memberCountryCode));
        $emergencyPhoneNumber = substr($member->emergency_phone_number, strlen($memberCountryCode));
        $member->phone_number = $phoneNumber;
        $member->alternate_phone_number = $alternatePhoneNumber;
        $member->emergency_phone_number = $emergencyPhoneNumber;

        return View('register.edit', compact('countries', 'member', 'memberCountryCode', 'titles'));
    }

    public function update(User $user, Request $request) {
       
        $tarif = Event::where('event_name', 'membership')->value('amount');
        
        $title = 'Council Chairperson, District Governor, Past Council Chairperson, Past District Governor, Region Chairperson, Zone Chairperson, Club President, Club Secretary';
        $titleOptions = explode(', ', $title);

        $district = 'MD307-A1, MD307-A2, MD307-B1, MD307-B2';
        $districtOptions = explode(', ', $district);

        $validator = Validator::make($request->all(), [
            'title' => ['nullable'],
            'address_1' => ['required', 'string', 'max:255'],
            'address_2' => ['max:255'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'integer', 'digits_between:3,10'],
            'phone_code' => ['required'],
            'phone_number' => ['required', 'digits_between:9,15'],
            'alternate_phone_number' => ['nullable', 'digits_between:9,15'],
            'club_name' => ['nullable', 'string', 'max:255'],             
            // 'emergency_contact' => ['required', 'string', 'max:255'],
            // 'emergency_phone_number' => ['required', 'digits_between:9,15'],
            'district' => ['required']
        ]);

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

        $user->update([
            'title' => $request->title,
            'address_1' => strtoupper($request->address_1),
            'address_2' => strtoupper($request->address_2),
            'country' => $request->country,
            'city' => strtoupper($request->city),
            'province' => strtoupper($request->province),
            'zip' => $request->zip,
            'phone_number' => $request->phone_code . $request->phone_number,
            'alternate_phone_number' => $request->alternate_phone_number ? $request->alternate_phone_code . $request->alternate_phone_number : null,            
            'club_name' => strtoupper($request->club_name),
            // 'emergency_contact' => strtoupper($request->emergency_contact),
            // 'emergency_phone_number' => $request->emergency_phone_code . $request->emergency_phone_number,
            'district' => $request->district
            ]);

        Alert::success('Success!', 'Changes has been updated!');

        return redirect('/dashboard')->with('success', 'Changes has been updated!');
    }
}
