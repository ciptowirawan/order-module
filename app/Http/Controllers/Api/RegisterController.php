<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Hash;
use Enqueue\SimpleClient\SimpleClient;

class RegisterController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new SimpleClient(config('enqueue.default'));
    }

    public function store(Request $request) {
        $tarif = 1680000;
        $virtualAccount = generateVirtualAccountNumber();

        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string', 'max:255',],
            'title' => ['nullable'],
            'address_1' => ['required', 'string', 'max:255'],
            'address_2' => ['max:255'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'integer', 'digits_between:3,10'],
            'phone_number' => ['required', 'digits_between:9,15'],
            'alternate_phone_number' => ['nullable', 'digits_between:9,15'],
            'club_number' => ['nullable', 'integer'],
            'club_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:dns', 'max:255', 'unique:users'],  
            'emergency_contact' => ['required', 'string', 'max:255'],
            'emergency_phone_number' => ['required', 'digits_between:9,15'],
            'district' => ['required'],
            'terms' => ['required'],
            'conditions' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();

        $reguser = User::create([
            'full_name' => strtoupper($request->full_name),
            'email' =>  $request->email,
            'registrant_tag' => 'REGISTRANT',
            'password' => Hash::make($request->password)
        ]);

        $role = Role::where('name', 'user')->first();
        $perm = $role->permissions;
        $reguser->syncRoles('user');   
        $reguser->syncPermissions($perm); 

        $registrant = Pendaftaran::create([
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

        $reguserData = $reguser->toArray();
        $reguserData['account'] = '8888' + $virtualAccount;
        $reguserData['amount'] = $tarif;

        $role = Role::where('name', 'user')->first();
        $perm = $role->permissions;
        $reguser->syncRoles('user');   
        $reguser->syncPermissions($perm); 

        $message = new Message(
            topicName: 'registrant-created',
            headers: ['Content-Type' => 'application/json'],
            body: $reguserData,
            key: 'registrant-created'  
        );
    
        try {
            $producer = Kafka::publishOn('registrant-created')->withMessage($message);

            $producer->send();
        } catch (Exception $e) {
            dd('Caught exception: ',  $e->getMessage(), "\n");
        }
        
        Auth::login($reguser);

        return response()->json(['message' => 'User registered successfully']);
    }

    public function store_member(Request $request) {
        $tarif = 1680000;
        $virtualAccount = $this->generateVirtualAccountNumber();

        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string', 'max:255',],
            'title' => ['nullable'],
            'address_1' => ['required', 'string', 'max:255'],
            'address_2' => ['max:255'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'integer', 'digits_between:3,10'],
            'phone_number' => ['required', 'digits_between:9,15'],
            'alternate_phone_number' => ['nullable', 'digits_between:9,15'],
            'club_number' => ['nullable', 'integer'],
            'club_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:dns', 'max:255', 'unique:users'],  
            'emergency_contact' => ['required', 'string', 'max:255'],
            'emergency_phone_number' => ['required', 'digits_between:9,15'],
            'district' => ['required'],
            'terms' => ['required'],
            'conditions' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();

        $reguser = User::create([
            'full_name' => strtoupper($request->full_name),
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
            'title' => $request->title,
            'address_1' => strtoupper($request->address_1),
            'address_2' => $request->address_2,
            'country' => $request->country,
            'city' => strtoupper($request->city),
            'province' => strtoupper($request->province),
            'zip' => $request->zip,
            'phone_number' => $request->phone_code . $request->phone_number,
            'alternate_phone_number' => $request->alternate_phone_number ? $request->alternate_phone_code . $request->alternate_phone_number : null,
            'club_number' => $request->club_number,
            'club_name' => strtoupper($request->club_name),
            // 'nomor_hp' => '+62'. $request->nomor_hp,
            'emergency_contact' => strtoupper($request->emergency_contact),
            'emergency_phone_number' => $request->emergency_phone_code . $request->emergency_phone_number,
            'district' => $request->district,
            'registrant_tag' => 'MEMBER',
            'terms' => $request->terms,
            'conditions' => $request->conditions
        ]);

        $reguserData = $reguser->toArray();
        $reguserData['account'] = '8888' + $virtualAccount;
        $reguserData['amount'] = $tarif;

        $role = Role::where('name', 'lions_member')->first();
        $perm = $role->permissions;
        $reguser->syncRoles('lions_member');   
        $reguser->syncPermissions($perm); 

        $message = new Message(
            topicName: 'member-created',
            headers: ['Content-Type' => 'application/json'],
            body: $reguserData,
            key: 'member-created'  
        );
    
        try {
            $producer = Kafka::publishOn('member-created')->withMessage($message);

            $producer->send();
        } catch (Exception $e) {
            dd('Caught exception: ',  $e->getMessage(), "\n");
        }
        
        Auth::login($reguser);

        return response()->json(['message' => 'User registered successfully']);
    }

    private function generateVirtualAccountNumber() {
        $number = mt_rand(100000000000, 999999999999); // better than rand()
    
        // call the same function if the barcode exists already
        if ($this->barcodeNumberExists($number)) {
            return $this->generateVirtualAccountNumber();
        }
    
        // otherwise, it's valid and can be used
        return $number;
    }
    
    private function barcodeNumberExists($number) {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return User::where('account', $number)->exists();
    }

}
