<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\OpenRegistration;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redirect;
use libphonenumber\PhoneNumberUtil;
use PragmaRX\Countries\Package\Countries;
use libphonenumber\PhoneNumberFormat;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function index_info() {
        return View('register-information.index');
    }

    public function index() {
        return View('register.index');
    }

    public function form(Request $request) {
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

        return View('register.form', compact('countries'));
    }

    public function store(Request $request) {

        $state = OpenRegistration::where('kode_status', "open-registration")->first();

        $tarif = ($state->value == 'early') ? 1680000 : (($state->value == 'regular') ? 1800000 : 2000000);
        
        $title = 'Council Chairperson, District Governor, Past Council Chairperson, Past District Governor, Region Chairperson, Zone Chairperson, Club President, Club Secretary';
        $titleOptions = explode(', ', $title);

        $district = 'MD307-A1, MD307-A2, MD307-B1, MD307-B2';
        $districtOptions = explode(', ', $district);

        $validator = Validator::make($request->all(), [
            'registration_type' => ['required', 'in:Lion,Leo,Adult Guest'],
            'full_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]*$/'],
            'title' => ['nullable', Rule::in($titleOptions)],
            'address_1' => ['required', 'string', 'max:255'],
            'address_2' => ['max:255'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'integer', 'digits_between:3,10'],
            'phone_code' => ['required'],
            'phone_number' => ['required', 'digits_between:9,15'],
            'alternate_phone_number' => ['nullable', 'digits_between:9,15'],
            'club_number' => ['nullable', 'integer'],
            'club_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:dns', 'max:255', 'unique:users'],  
            'emergency_contact' => ['required', 'string', 'max:255'],
            'emergency_phone_code' => ['required'],
            'emergency_phone_number' => ['required', 'digits_between:9,15'],
            'district' => ['required', Rule::in($districtOptions)],
            'terms' => ['required'],
            'conditions' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]); 

        if (count($validator->errors()->toArray()) > 0) {
            $error_message = $validator->errors()->toArray();
            $error = ValidationException::withMessages($error_message);
            return Redirect::back()->withInput($request->input())->withErrors($validator);
        }

        $reguser = User::create([
            'full_name' => strtoupper($request->full_name),
            'email' =>  $request->email,
            'password' => Hash::make($request->password)
        ]);

        $role = Role::where('name', 'user')->first();
        $perm = $role->permissions;
        $reguser->syncRoles('user');   
        $reguser->syncPermissions($perm); 

        $registrant = Pendaftaran::create([
            'registration_type' => $request->registration_type,
            'full_name' => strtoupper($request->full_name),
            'title' => $request->title,
            'address_1' => strtoupper($request->address_1),
            'address_2' => $request->address_2,
            'country' => $request->country,
            'city' => strtoupper($request->city),
            'province' => strtoupper($request->province),
            'zip' => $request->zip,
            'phone_number' => $request->phone_code . $request->phone_number,
            'alternate_phone_number' => $request->alternate_phone_number ? $request->alternate_phone_code . $request->alternate_phone_number : null,
            'user_id' => $reguser->id,
            'club_number' => $request->club_number,
            'club_name' => strtoupper($request->club_name),
            'email' =>  $request->email,
            // 'nomor_hp' => '+62'. $request->nomor_hp,
            'emergency_contact' => strtoupper($request->emergency_contact),
            'emergency_phone_number' => $request->emergency_phone_code . $request->emergency_phone_number,
            'district' => $request->district,
            'terms' => $request->terms,
            'conditions' => $request->conditions
        ]);

        Payment::create([
            'amount' => $tarif,
            'pendaftaran_id' => $registrant->id
        ]);

        // $historicalData = $registrant->historical_data ?? [];

        // $historicalData[] = [
        //     'registration_type' => $request->registration_type,
        //     'first_name' => $request->first_name,
        //     'last_name' => $request->last_name,
        //     'title' => $request->title,
        //     'address_1' => $request->address_1,
        //     'address_2' => $request->address_2,
        //     'country' => $request->country,
        //     'city' => $request->city,
        //     'province' => $request->province,
        //     'zip' => $request->zip,
        //     'invitation_letter' => $request->invitation_letter,
        //     'phone_number' => $request->phone_number,
        //     'alternate_phone_number' => $request->alternate_phone_number,
        //     'club_number' => $request->club_number,
        //     'club_name' => $request->club_name,
        //     'email' =>  $request->email,
        //     // 'nomor_hp' => '+62'. $request->nomor_hp,
        //     'emergency_contact' => $request->emergency_contact,
        //     'emergency_phone_number' => $request->emergency_phone_number,
        //     'district' => $request->district,            
        //     'timestamp' => now(), // Optionally, include a timestamp for each historical version
        // ];

        // $registrant->update(['historical_data' => $historicalData]);

        event(new Registered($reguser));

        Auth::login($reguser);

        return redirect('/dashboard')->with('success', 'Kami telah mengirimkan tautan verifikasi ke Alamat Email anda. Silahkan cek email anda dan ikuti instruksinya untuk melanjutkan proses verifikasi email.');

    }

}
