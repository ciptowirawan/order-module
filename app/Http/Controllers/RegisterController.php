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

        $validator = Validator::make($request->all(), [
            'registration_type' => ['required', 'string'],
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
            'account' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();

        $reguser = User::create([
            'name' => strtoupper($request->full_name),
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
            'registration_type' => $request->registration_type,
            'full_name' => strtoupper($request->full_name),
            'title' => $request->title,
            'address_1' => strtoupper($request->address_1),
            'address_2' => $request->address_2,
            'country' => $request->country,
            'city' => strtoupper($request->city),
            'province' => strtoupper($request->province),
            'zip' => $request->zip,
            'phone_number' => $request->phone_number,
            'alternate_phone_number' => $request->alternate_phone_number,
            'club_number' => $request->club_number,
            'club_name' => strtoupper($request->club_name),
            'email' =>  $request->email,
            // 'nomor_hp' => '+62'. $request->nomor_hp,
            'emergency_contact' => strtoupper($request->emergency_contact),
            'emergency_phone_number' => $request->emergency_phone_number,
            'district' => $request->district,
        ]);

        $reguserData = $reguser->toArray();
        $reguserData['amount'] = $tarif;
        $reguserData['account'] = $validatedData['account'];

        // $fck = [
        //     'data' => 'test'
        // ];

        $message = new Message(
            topicName: 'registrant-created',
            headers: ['Content-Type' => 'application/json'],
            body: $reguserData,
            key: 'registrant-created'  
        );
    
        try {
            $producer = Kafka::publishOn('registrant-created', '192.168.99.100:29092')->withMessage($message);

            $producer->send();
        } catch (Exception $e) {
            dd('Caught exception: ',  $e->getMessage(), "\n");
        }
        

        return response()->json(['message' => 'User registered successfully']);
    }

}
