<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use Validator; 
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

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
        $rstMonth = Carbon::parse($request->input('registration_start_at'))->format('Y-m');
        $est = Carbon::parse($request->input('event_start_at'));
        $eet = Carbon::parse($request->input('event_end_at'));
    
        // Check for unique month in RST
        $existingRST = Event::whereYear('registration_start_at', $est->year)
            ->whereMonth('registration_start_at', $est->month)
            ->exists();
        if ($existingRST) {
            $validator->errors()->add('registration_start_at', 'The registration start time must have a unique month for each event.');
        }
        $overlappingEvents = Event::where(function ($query) use ($est, $eet) {
            $query->whereBetween('event_start_at', [$est, $eet])
                ->orWhereBetween('event_end_at', [$est, $eet])
                ->orWhere(function ($query) use ($est, $eet) {
                    $query->where('event_start_at', '<=', $est)
                        ->where('event_end_at', '>=', $eet);
                });
        })->exists();
    
        if ($overlappingEvents) {
            $validator->errors()->add('event_start_at', 'The event start and end times must not overlap with another event.');
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
        ]
    ); 

    $validator->after(function ($validator) use ($request) {
        $rstMonth = Carbon::parse($request->input('registration_start_at'))->format('Y-m');
        $est = Carbon::parse($request->input('event_start_at'));
        $eet = Carbon::parse($request->input('event_end_at'));
    
        // Check for unique month in RST
        $existingRST = Event::whereYear('registration_start_at', $est->year)
            ->whereMonth('registration_start_at', $est->month)
            ->exists();
        if ($existingRST) {
            $validator->errors()->add('registration_start_at', 'The registration start time must have a unique month for each event.');
        }
        $overlappingEvents = Event::where(function ($query) use ($est, $eet) {
            $query->whereBetween('event_start_at', [$est, $eet])
                ->orWhereBetween('event_end_at', [$est, $eet])
                ->orWhere(function ($query) use ($est, $eet) {
                    $query->where('event_start_at', '<=', $est)
                        ->where('event_end_at', '>=', $eet);
                });
        })->exists();
    
        if ($overlappingEvents) {
            $validator->errors()->add('event_start_at', 'The event start and end times must not overlap with another event.');
        }
    });
        
        // if there's error
        if (count($validator->errors()->toArray()) > 0) {
            $error_message = $validator->errors()->toArray();
            $error = ValidationException::withMessages($error_message);
            return Redirect::back()->withInput($request->input())->withErrors($validator);
        }

        $data->update([
                $request->all()
            ]);

        return redirect('/manage/events')->with('success', 'Perubahan Berhasil Disimpan!');
    }
    
    public function destroy(Event $data) {
        $data->delete();

        Alert::success('Success!', 'Event Berhasil Dihapus!');

        return redirect('/manage/events')->with('success', 'Event Berhasil Dihapus!');

    }
}
