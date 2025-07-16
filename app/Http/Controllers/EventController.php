<?php

namespace App\Http\Controllers;

use Validator; 
use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    public function index() {
        $events = Event::WhereNotNull('registration_start_at')->get();
        return view('manage.events.index', compact('events'));
    }

    public function create() {
        return view('manage.events.create');
    }

    public function edit(Event $data) {        
        return View('manage.events.edit', compact('data'));
    }

    public function store(Request $request)  {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'event_name' => ['required', 'string', 'max:255'],
            'registration_start_at' => ['required', 'date', 'before_or_equal:registration_end_at'],
            'registration_end_at' => ['required', 'date', 'after_or_equal:registration_start_at'],
            'event_start_at' => ['required', 'date', 'before_or_equal:event_end_at'],
            'event_end_at' => ['required', 'date', 'after_or_equal:event_start_at'],
        ], [
            // Custom error messages
            'registration_start_at.before_or_equal' => 'The registration start time must not be later than the registration end time.',
            'registration_end_at.after_or_equal' => 'The registration end time must not be earlier than the registration start time.',
            'event_start_at.before_or_equal' => 'The event start time must not be later than the event end time.',
            'event_end_at.after_or_equal' => 'The event end time must not be earlier than the event start time.',
        ]
    ); 

    $validator->after(function ($validator) use ($request) {
        $rst = Carbon::parse($request->input('registration_start_at')); 
        $ret = Carbon::parse($request->input('registration_end_at')); 
        $est = Carbon::parse($request->input('event_start_at'));
        $eet = Carbon::parse($request->input('event_end_at'));

        $overlappingRegistrations = Event::where(function ($query) use ($rst, $ret) {
            $query->where('registration_start_at', '<=', $ret) 
                  ->where('registration_end_at', '>=', $rst);
        })->exists();
        
        if ($overlappingRegistrations) {
            $validator->errors()->add('registration_start_at', 'Registration period overlaps with another event.');
        }
        
        // Check for event period overlaps
        $overlappingEvents = Event::where(function ($query) use ($est, $eet) {
            $query->where('event_start_at', '<=', $eet)
                  ->where('event_end_at', '>=', $est);
        })->exists();
        
        if ($overlappingEvents) {
            $validator->errors()->add('event_start_at', 'This event overlaps with another event.');
        }

        if ($ret->isAfter($est)) {
            $validator->errors()->add('registration_end_at', 'Registration must end before the event starts.');
        }

        $now = Carbon::now();
        if ($rst->toDateString() < $now->toDateString()) {
            $validator->errors()->add('registration_start_at', 'Registration cannot start in the past.');
        }

    });
        
        // if there's error
        if (count($validator->errors()->toArray()) > 0) {
            $error_message = $validator->errors()->toArray();
            $error = ValidationException::withMessages($error_message);
            return Redirect::back()->withInput($request->input())->withErrors($validator);
        }

        Event::create($request->all());
    
        return redirect('/manage/events')->with('success', 'Berhasil Menambahkan Kegiatan!');
    }

    public function update(Event $data, Request $request) {
        $validator = Validator::make($request->all(), [
            'event_name' => ['required', 'string', 'max:255'],
            'registration_start_at' => ['required', 'date', 'before_or_equal:registration_end_at'],
            'registration_end_at' => ['required', 'date', 'after_or_equal:registration_start_at'],
            'event_start_at' => ['required', 'date', 'before_or_equal:event_end_at'],
            'event_end_at' => ['required', 'date', 'after_or_equal:event_start_at'],
        ], [
            // Custom error messages
            'registration_start_at.before_or_equal' => 'The registration start time must not be later than the registration end time.',
            'registration_end_at.after_or_equal' => 'The registration end time must not be earlier than the registration start time.',
            'event_start_at.before_or_equal' => 'The event start time must not be later than the event end time.',
            'event_end_at.after_or_equal' => 'The event end time must not be earlier than the event start time.',
        ]); 
    
        $validator->after(function ($validator) use ($request, $data) {
            $rst = Carbon::parse($request->input('registration_start_at')); 
            $ret = Carbon::parse($request->input('registration_end_at')); 
            $est = Carbon::parse($request->input('event_start_at'));
            $eet = Carbon::parse($request->input('event_end_at'));
            $now = Carbon::now();
            
            // Check for registration period overlaps (excluding current event)
            $overlappingRegistrations = Event::where(function ($query) use ($rst, $ret) {
                $query->where('registration_start_at', '<=', $ret) 
                      ->where('registration_end_at', '>=', $rst);
            })
            ->where('id', '!=', $data->id)
            ->exists();
            
            if ($overlappingRegistrations) {
                $validator->errors()->add('registration_start_at', 'Registration period overlaps with another event.');
            }
            
            // Check for event period overlaps (excluding current event)
            $overlappingEvents = Event::where(function ($query) use ($est, $eet) {
                $query->where('event_start_at', '<=', $eet)
                      ->where('event_end_at', '>=', $est);
            })
            ->where('id', '!=', $data->id)
            ->exists();
            
            if ($overlappingEvents) {
                $validator->errors()->add('event_start_at', 'This event overlaps with another event.');
            }
    
            // Registration must end before event starts
            if ($ret->isAfter($est)) {
                $validator->errors()->add('registration_end_at', 'Registration must end before the event starts.');
            }
    
            // Past date validation - but with more flexibility for updates
            // Only check if registration hasn't started yet
            if ($rst->isPast() && Carbon::parse($data->registration_start_at)->isFuture()) {
                $validator->errors()->add('registration_start_at', 'Registration cannot start in the past.');
            }
            
            // If registration has already started, don't allow changing the start date to past
            if (Carbon::parse($data->registration_start_at)->isPast() && $rst->ne(Carbon::parse($data->registration_start_at))) {
                $validator->errors()->add('registration_start_at', 'Cannot modify registration start date for events that have already started registration.');
            }
            
            // If event has already started, don't allow major changes
            if (Carbon::parse($data->event_start_at)->isPast()) {
                if ($est->ne(Carbon::parse($data->event_end_at))) {
                    $validator->errors()->add('event_start_at', 'Cannot modify start date for events that have already started.');
                }
                if ($eet->isBefore(Carbon::parse($data->event_end_at))) {
                    $validator->errors()->add('event_end_at', 'Cannot shorten an event that has already started.');
                }
            }
            
            // Don't allow shortening registration period if it has already started
            if (Carbon::parse($data->registration_start_at)->isPast() && $ret->isBefore(Carbon::parse($data->registration_end_at))) {
                $validator->errors()->add('registration_end_at', 'Cannot shorten registration period that has already started.');
            }
            
            // Warn if trying to extend registration after it has ended
            if (Carbon::parse($data->registration_end_at)->isPast() && $ret->isAfter(Carbon::parse($data->registration_end_at))) {
                $validator->errors()->add('registration_end_at', 'Cannot extend registration period after it has already ended.');
            }
        });
            
        // if there's error
        if (count($validator->errors()->toArray()) > 0) {
            $error_message = $validator->errors()->toArray();
            $error = ValidationException::withMessages($error_message);
            return Redirect::back()->withInput($request->input())->withErrors($validator);
        }
    
        $data->update($request->all());
    
        return redirect('/manage/events')->with('success', 'Perubahan Berhasil Disimpan!');
    }
    
    public function destroy(Event $data) {
        $data->delete();

        Alert::success('Success!', 'Event Berhasil Dihapus!');

        return redirect('/manage/events')->with('success', 'Event Berhasil Dihapus!');

    }
}
