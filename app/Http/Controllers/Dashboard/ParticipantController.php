<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use libphonenumber\PhoneNumberUtil;
use PragmaRX\Countries\Package\Countries;
use libphonenumber\PhoneNumberFormat;
use Illuminate\Support\Facades\Redirect;

class ParticipantController extends Controller
{
    public function index_unpaid(Request $request) {
        $search = $request->search;

        $pendaftaran = Pendaftaran::select(
            'pendaftaran.*',
            'payments.amount',
            'payments.status',
            'users.email_verified_at',
        )->leftJoin('users', 'users.id', 'pendaftaran.user_id'
        )->leftJoin('payments', 'payments.pendaftaran_id', 'pendaftaran.id'
        )->orderBy('amount'
        )->where('payments.status', 'unpaid'
        )->Where(function ($query) use ($search) {
            $query->orWhere('pendaftaran.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('payments.amount', 'LIKE', '%'.$search.'%');
        })->paginate(20);

        return view('manage.participant.index-unpaid', compact('pendaftaran'));
    }

    public function index_paid(Request $request) {
        $search = $request->search;
        
        $pendaftaran = Pendaftaran::select(
            'pendaftaran.*',
            'payments.amount',
            'payments.paid_amount',
            'payments.payment_date',
            'payments.status',
            'users.email_verified_at',
        )->leftJoin('users', 'users.id', 'pendaftaran.user_id'
        )->leftJoin('payments', 'payments.pendaftaran_id', 'pendaftaran.id'
        )->orderBy('amount'
        )->where('payments.status', 'paid'
        )->Where(function ($query) use ($search) {
            $query->orWhere('pendaftaran.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('payments.paid_amount', 'LIKE', '%'.$search.'%'
            )->orWhere('payments.payment_date', 'LIKE', '%'.$search.'%'
            )->orWhere('payments.amount', 'LIKE', '%'.$search.'%');
        })->paginate(20);
        return view('manage.participant.index-paid', compact('pendaftaran'));
    }

    public function show(string $id) {
        $pendaftaran = Pendaftaran::where('user_id', $id)->with('user')->with('payment')->first();

        
        $historicalData = json_decode($pendaftaran->historical_data, true);

        
        $history = 0;
        foreach ($historicalData as $index => $subArray) {
            $history = count($subArray);
        } 

        return View('details.user-detail', compact('pendaftaran', 'history'));
    }

    public function modify(string $id) {
        $pendaftaran = Pendaftaran::where('id', $id)->with('user')->with('payment')->first();

        
        $historicalData = json_decode($pendaftaran->historical_data, true);

        $requestInputs = [
            'registration_type',
            'full_name',
            'title',
            'address_1',
            'address_2',
            'country',
            'city',
            'province',
            'zip',
            'phone_number',
            'alternate_phone_number',
            'club_number',
            'club_name',
            'email',
            'emergency_contact',
            'emergency_phone_number',
            'district',
        ];

        return View('details.modify', compact('pendaftaran', 'historicalData'));
    }

    

    public function edit(string $id, Request $request) {
        $data = Pendaftaran::find($id);

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

        return view('details.edit', compact('data', 'countries'));
    }

    public function update(string $id, Request $request) {
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
            'email' => ['required', 'string', 'email:dns', 'max:255'],  
            'emergency_contact' => ['required', 'string', 'max:255'],
            'emergency_phone_code' => ['required'],
            'emergency_phone_number' => ['required', 'digits_between:9,15'],
            'district' => ['required', Rule::in($districtOptions)],
        ]); 

        if (count($validator->errors()->toArray()) > 0) {
            $error_message = $validator->errors()->toArray();
            $error = ValidationException::withMessages($error_message);
            return Redirect::back()->withInput($request->input())->withErrors($validator);
        }

        $pendaftaran = Pendaftaran::find($id);

        $requestInputs = [
            'registration_type',
            'full_name',
            'title',
            'address_1',
            'address_2',
            'country',
            'city',
            'province',
            'zip',
            'phone_number',
            'alternate_phone_number',
            'club_number',
            'club_name',
            'email',
            'emergency_contact',
            'emergency_phone_number',
            'district',
        ];

        $originalData = array_intersect_key($pendaftaran->toArray(), array_flip($requestInputs));
        
        // Get only the specified request inputs from the request object
        $requestData = $request->only($requestInputs);
        
        // Modify the phone number to include the hardcoded country code
        $requestData['full_name'] = strtoupper($request->full_name);
        $requestData['phone_number'] = $request->phone_code . $request->phone_number;
        $requestData['alternate_phone_number'] = $request->alternate_phone_number ?        
                            $request->alternate_phone_code . $request->alternate_phone_number : null;
        $requestData['emergency_phone_number'] = $request->emergency_phone_code .  $request->emergency_phone_number;
        $requestData['address_1'] = strtoupper($request->address_1);
        $request->address_2 ? $requestData['address_2'] = strtoupper($request->address_2) : '';
        $requestData['city'] = strtoupper($request->city);
        $requestData['province'] = strtoupper($request->province);
        $requestData['emergency_contact'] = strtoupper($request->emergency_contact);
        
        // Compare the specified request inputs with the original data
        $oldChanges = array_diff_assoc($originalData, $requestData);
        $oldChanges['timestamp'] = now()->toDateTimeString();
        $newChanges = array_diff_assoc($requestData, $originalData);

        if (!empty($newChanges)) {
            $historicalData = json_decode($pendaftaran->historical_data, true) ?? [];
            $historicalData[] = $oldChanges;

            User::where('id', $pendaftaran->user_id)
            ->update([
                'full_name' => $request->full_name,            
                'email' =>  $request->email
            ]);
            
            // Update only the changed fields
            $pendaftaran->update($newChanges);

            $pendaftaran->update(['historical_data' => json_encode($historicalData)]);
        }

        return redirect('/dashboard')->with('success', 'Perubahan Berhasil Disimpan!');

        // $pendaftaran->update([
        //     'registration_type' => $request->registration_type,
        //     'full_name' => strtoupper($request->full_name),
        //     'title' => $request->title,
        //     'address_1' => strtoupper($request->address_1),
        //     'address_2' => $request->address_2,
        //     'country' => $request->country,
        //     'city' => strtoupper($request->city),
        //     'province' => strtoupper($request->province),
        //     'zip' => $request->zip,
        //     'phone_number' => $request->phone_code . $request->phone_number,
        //     'alternate_phone_number' => $request->alternate_phone_number ? $request->alternate_phone_code . $request->alternate_phone_number : null,
        //     'club_number' => $request->club_number,
        //     'club_name' => $request->club_name,
        //     'email' =>  $request->email,
        //     // 'nomor_hp' => '+62'. $request->nomor_hp,
        //     'emergency_contact' => strtoupper($request->emergency_contact),
        //     'emergency_phone_number' => $request->emergency_phone_code . $request->emergency_phone_number,
        //     'district' => $request->district,
        // ]);

        // return redirect('/details/show/' . $pendaftaran->user_id)->with('success', 'Perubahan Berhasil Disimpan!');
    }

    public function undo(string $id, Request $request)  {

        // Find the participant by ID
        $pendaftaran = Pendaftaran::find($id);

        // Get the historical data array
        $historicalData = json_decode($pendaftaran->historical_data, true);
        $versionIndex = $request->version;
        

        if (isset($historicalData[$versionIndex])) {
            // Get the selected version
            $selectedData = $historicalData[$versionIndex];

            // Update the participant with the selected version
            $pendaftaran->update($selectedData);
            
            // Update User table if full_name or email is changed
            $userChanges = array_intersect_key($selectedData, array_flip(['full_name', 'email']));

            if (!empty($userChanges)) {
                User::where('id', $pendaftaran->user_id)->update($userChanges);
            }

            // Remove the selected version from historical data
            unset($historicalData[$versionIndex]);

            // Re-index the array
            $historicalData = array_values($historicalData);

            // Update the historical data
            $pendaftaran->update(['historical_data' => json_encode($historicalData)]);

            return redirect('/details/show/' . $pendaftaran->user_id)->with('success', 'Changes reverted successfully.');
        } else {
            return redirect('/details/show/' . $pendaftaran->user_id)->with('error', 'Invalid version selected.');
        }

    }

    public function destroy(string $id) {
        User::destroy($id);

        return redirect('/')->with('success', 'data registrasi Berhasil Dihapus!');
    }
}
