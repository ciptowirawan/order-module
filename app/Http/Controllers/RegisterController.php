<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
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
            'password' => ['required', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

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

        $producer = $this->client->getProducer();
        $producer->sendEvent('order-created', json_encode($user));

        return response()->json(['message' => 'User registered successfully']);
    }

}
