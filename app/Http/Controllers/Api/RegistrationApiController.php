<?php

namespace App\Http\Controllers\Api;

use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Order;
use App\Models\Member;
use App\Models\Registration;
use Illuminate\Http\Request;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Enqueue\SimpleClient\SimpleClient;

class RegistrationApiController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new SimpleClient(config('enqueue.default'));
    }

    public function store(Request $request) {
        $tarif = Event::where('event_name', 'membership')->value('amount');
        $virtualAccount = '8888' . $this->generateVirtualAccountNumber();

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
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $reguser = User::create([
            'full_name' => strtoupper($request->full_name),
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
            'registrant_tag' => 'REGULAR',
            'virtual_account' => $virtualAccount,
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
            'emergency_contact' => strtoupper($request->emergency_contact),
            'emergency_phone_number' => $request->emergency_phone_code . $request->emergency_phone_number,
            'district' => $request->district,
            'terms' => $request->terms,
            'conditions' => $request->conditions,
            'registrant_tag' => 'REGULAR'
        ]);       

        $role = Role::where('name', 'user')->first();
        $perm = $role->permissions;
        $reguser->syncRoles('user');
        $reguser->syncPermissions($perm); 

        $registrant = Order::create([
            'user_id' => $reguser->id,
            'amount' => $tarif            
        ]);

        $registrantData = $registrant->toArray();
        $registrantData['account'] = $virtualAccount;
        $registrantData['full_name'] = $reguser->full_name;

        $message = new Message(
            topicName: 'registrant-created',
            headers: ['Content-Type' => 'application/json'],
            body: $registrantData,
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

    public function renew_member() {
        $tarif = Event::where('event_name', 'membership')->value('amount');
        $user = User::where('id', auth()->user()->id)->first();

        $registrant = Order::create([
            'user_id' => $user->id,
            'amount' => $tarif            
        ]);

        $registrantData = $registrant->toArray();
        $registrantData['account'] = $user->virtual_account;
        $registrantData['full_name'] = $reguser->full_name;

        $message = new Message(
            topicName: 'registrant-created',
            headers: ['Content-Type' => 'application/json'],
            body: $registrantData,
            key: 'registrant-created'  
        );
    
        try {
            $producer = Kafka::publishOn('registrant-created')->withMessage($message);

            $producer->send();
        } catch (Exception $e) {
            dd('Caught exception: ',  $e->getMessage(), "\n");
        }        

        return response()->json(['message' => 'Renewal Order Issued!']);
    }

    public function check_expiry(Request $request) {
        $user = User::where('id', auth()->user()->id)->first();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $now = Carbon::now();

    if ($user->member_over_in && $now->gt(Carbon::parse($user->member_over_in))) {
        $registrant = User::where('id', auth()->user()->id)
            ->update([
                'status' => "PENDING",
                'registrant_tag' => "REGULAR"            
            ]);

        return response()->json([
            'message' => 'Your membership has expired. Status updated to REGULAR.',
            'status' => $user->status,
            'registrant_tag' => $user->registrant_tag
        ]);
    }

        
    }

    public function store_lions_member(Request $request) {
        $tarif = 1680000;
        $virtualAccount = '8888' . $this->generateVirtualAccountNumber();

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
            'emergency_contact' => strtoupper($request->emergency_contact),
            'emergency_phone_number' => $request->emergency_phone_code . $request->emergency_phone_number,
            'district' => $request->district,
            'terms' => $request->terms,
            'conditions' => $request->conditions,
            'registrant_tag' => 'MEMBER',
            'virtual_account' => $virtualAccount
        ]);       

        $role = Role::where('name', 'user')->first();
        $perm = $role->permissions;
        $reguser->syncRoles('user');   
        $reguser->syncPermissions($perm); 

        $registrantData = $reguser->toArray();
        $registrantData['amount'] = $tarif;

        $message = new Message(
            topicName: 'member-created',
            headers: ['Content-Type' => 'application/json'],
            body: $registrantData,
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

    public function store_participant(Request $request) {

        $registeredData = User::where('id', auth()->user()->id)->first();

        $registrant = Registration::create([
            'title' => $registeredData->title,
            'address_1' => strtoupper($registeredData->address_1),
            'address_2' => $registeredData->address_2 ? strtoupper($registeredData->address_2) : null,
            'country' => $registeredData->country,
            'city' => strtoupper($registeredData->city),
            'province' => strtoupper($registeredData->province),
            'zip' => $registeredData->zip,
            'phone_number' => $registeredData->phone_code . $registeredData->phone_number,
            'alternate_phone_number' => $registeredData->alternate_phone_number ? $request->alternate_phone_code . $request->alternate_phone_number : null,            
            'club_number' => $registeredData->club_number,
            'club_name' => strtoupper($registeredData->club_name),
            'emergency_contact' => strtoupper($registeredData->emergency_contact),
            'emergency_phone_number' => $registeredData->emergency_phone_code . $registeredData->emergency_phone_number,
            'district' => $registeredData->district,
            'terms' => $registeredData->terms,
            'conditions' => $registeredData->conditions,
            'registrant_tag' => 'MEMBER'
        ]);         
         
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
        return User::where('virtual_account', '8888' . $number)->exists();
    }
}
