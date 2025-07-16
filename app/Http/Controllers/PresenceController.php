<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Uuid;
use App\Models\Event;
use App\Models\Presence;
use App\Models\Registration;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PresenceController extends Controller
{
    public function index(Request $request, string $id) {
        $search = $request->search;

        $distinctDates = Registration::where('event_id', $id)
        ->whereHas('presences')
        ->with('presences')
        ->get()
        ->flatMap(function ($registration) {
            return $registration->presences->pluck('waktu_hadir');
        })
        ->map(function ($datetime) {
            return Carbon::parse($datetime)->format('Y-m-d');
        })
        ->unique()
        ->sort()
        ->values();

        $pendaftaran = Registration::with(['presences'])
        ->where('event_id', $id)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%")
                    ->orWhere('club_name', 'LIKE', "%{$search}%")
                    ->orWhere('district', 'LIKE', "%{$search}%")
                    ->orWhere('status_kehadiran', 'LIKE', "%{$search}%");
            });
        })->paginate(20);
        
        $currentPageItems = $pendaftaran->getCollection()->map(function ($registrant) use ($distinctDates) {
            $missedDates = $distinctDates->filter(function ($date) use ($registrant) {
                return !$registrant->presences->contains(function ($presence) use ($date) {
                    return Carbon::parse($presence->waktu_hadir)->format('Y-m-d') === $date;
                });
            });
    
            $registrant->missedDates = $missedDates;
    
            return $registrant;
        });

        $filteredItems = $currentPageItems->filter(function ($registrant) {
            return $registrant->missedDates->isNotEmpty();
        });
    
        // Replace the paginator's collection with the transformed data
        $pendaftaran->setCollection($filteredItems);

        return view('manage.participant.index-presence', compact('pendaftaran', 'id', 'distinctDates'));
    }

    public function index_participants(Request $request, string $id) {
        $search = $request->search;

        $pendaftaran = Registration::Where('event_id', $id)
        ->Where(function ($query) use ($search) {
            $query->orWhere('registrations.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.title', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.club_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.district', 'LIKE', '%'.$search.'%');
        })->with('user')->paginate(20);

        return view('manage.participant.index-participants', compact('pendaftaran', 'id'));
    }

    public function index_attended(Request $request, string $id) {
        $search = $request->search;

        $pendaftaran = Registration::where('event_id', $id)
        ->has('presences') // This ensures registrations with at least one presence are returned
        ->with(['admin', 'presences']) // Eager load related admin and ALL presences
        ->where(function ($query) use ($search) {
            $query->orWhere('registrations.full_name', 'LIKE', '%'.$search.'%')
                ->orWhere('registrations.title', 'LIKE', '%'.$search.'%')
                ->orWhere('registrations.club_name', 'LIKE', '%'.$search.'%')
                ->orWhere('registrations.district', 'LIKE', '%'.$search.'%')
                ->orWhereHas('admin', function ($q) use ($search) {
                    $q->where('full_name', 'LIKE', '%'.$search.'%');
                });
        })
        ->orderBy('id')
        ->paginate(20);

        $distinctDates = Registration::where('event_id', $id)
        ->whereHas('presences')
        ->with('presences')
        ->get()
        ->flatMap(function ($registration) {
            return $registration->presences->pluck('waktu_hadir');
        })
        ->map(function ($datetime) {
            return Carbon::parse($datetime)->format('Y-m-d');
        })
        ->unique()
        ->sort()
        ->values();

        return view('manage.participant.index-attended', compact('pendaftaran', 'id', 'distinctDates'));
    }

    public function sortAttendedByDate(Request $request, $checkInDate, string $id) {
        $search = $request->search;

        $pendaftaran = Registration::Where('event_id', $id)
        ->whereHas('presences', function ($query) use ($checkInDate) {
            $query->whereDate('waktu_hadir', $checkInDate);
        })
        ->with(['presences' => function ($query) use ($checkInDate) {
            $query->whereDate('waktu_hadir', $checkInDate);
        }])
        ->Where(function ($query) use ($search) {
            $query->orWhere('registrations.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.title', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.club_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.district', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.status_kehadiran', 'LIKE', '%'.$search.'%');
        })->paginate(20);

        $distinctDates = Registration::where('event_id', $id)
        ->whereHas('presences')
        ->with('presences')
        ->get()
        ->flatMap(function ($registration) {
            return $registration->presences->pluck('waktu_hadir');
        })
        ->map(function ($datetime) {
            return Carbon::parse($datetime)->format('Y-m-d');
        })
        ->unique()
        ->sort()
        ->values();

        return view('manage.participant.index-attended', compact('pendaftaran', 'id', 'distinctDates'));
    }

    public function sortUnattendedByDate(Request $request, $checkInDate, string $id) {
        $search = $request->search;

        $distinctDates = Registration::where('event_id', $id)
        ->whereHas('presences')
        ->with('presences')
        ->get()
        ->flatMap(function ($registration) {
            return $registration->presences->pluck('waktu_hadir');
        })
        ->map(function ($datetime) {
            return Carbon::parse($datetime)->format('Y-m-d');
        })
        ->unique()
        ->sort()
        ->values();

        $pendaftaran = Registration::with(['presences'])
        ->where('event_id', $id)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%")
                    ->orWhere('club_name', 'LIKE', "%{$search}%")
                    ->orWhere('district', 'LIKE', "%{$search}%")
                    ->orWhere('status_kehadiran', 'LIKE', "%{$search}%");
            });
        })->paginate(20);

        $currentPageItems = $pendaftaran->getCollection()->map(function ($registrant) use ($distinctDates) {
            $missedDates = $distinctDates->filter(function ($date) use ($registrant) {
                return !$registrant->presences->contains(function ($presence) use ($date) {
                    return Carbon::parse($presence->waktu_hadir)->format('Y-m-d') === $date;
                });
            });

            $registrant->missedDates = $missedDates;

            return $registrant;
        });

        // Filter participants based on whether they missed the specific date
        $filteredItems = $currentPageItems->filter(function ($registrant) use ($checkInDate) {
            return $registrant->missedDates->contains($checkInDate);
        });

        // Sort the filtered items alphabetically by name for clarity (optional)
        $sortedItems = $filteredItems->sortBy('full_name')->values();

        // Replace the paginator's collection with the sorted and filtered data
        $pendaftaran->setCollection($sortedItems);

        return view('manage.participant.index-presence', compact('pendaftaran', 'id', 'distinctDates'));
    }

    public function sortAttendedByDistrict(Request $request, string $district, string $id) {
        $search = $request->search;

        $pendaftaran = Registration::Where('registrations.status_kehadiran', 'HADIR'
        )->Where('event_id', $id)->Where('district', $district)
        ->Where(function ($query) use ($search) {
            $query->orWhere('registrations.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.title', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.club_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.district', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.status_kehadiran', 'LIKE', '%'.$search.'%');
        })->paginate(20);

        return view('manage.participant.index-attended', compact('pendaftaran'));
    }

    public function sortParticipantsByDistrict(Request $request, string $district, string $id) {
        $search = $request->search;

        $pendaftaran = Registration::Where('event_id', $id)->Where('district', $district)
        ->Where(function ($query) use ($search) {
            $query->orWhere('registrations.full_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.title', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.club_name', 'LIKE', '%'.$search.'%'
            )->orWhere('registrations.district', 'LIKE', '%'.$search.'%');
        })->with('user')->paginate(20);

        return view('manage.participant.index-participants', compact('pendaftaran', 'id'));
    }

    public function exportParticipantsByDistrict(string $district, Event $data) {
        
        $participants = Registration::Where('event_id', $data->id)->where('district', $district)->get();

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-participants', compact('participants', 'district', 'data'));

        return $pdf->download('Event_participants_' .$district. '.pdf');
    }

    public function exportParticipantsAsPdf(Event $data) {
        
        $participants = Registration::Where('event_id', $data->id)->get();

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $district = "All";

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-participants', compact('participants', 'district', 'data'));

        return $pdf->download('Event_participants_' .$district. '.pdf');
    }

    public function exportUnattendedParticipantsByDistrict(string $district, Event $data) {
        
        $participants = Registration::Where('event_id', $data->id)->WhereNull('registrations.status_kehadiran'
        )->where('district', $district)->get();

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $unattendedCount = $participants->count();

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-unattended', compact('participants', 'district', 'data','unattendedCount'));

        return $pdf->download('Unattended_participants_' .$district. '.pdf');
    }
    
    public function exportUnattendedParticipantsByDate($checkInDate, Event $data) {

        $distinctDates = Registration::where('event_id', $data->id)
        ->whereHas('presences')
        ->with('presences')
        ->get()
        ->flatMap(function ($registration) {
            return $registration->presences->pluck('waktu_hadir');
        })
        ->map(function ($datetime) {
            return Carbon::parse($datetime)->format('Y-m-d');
        })
        ->unique()
        ->sort()
        ->values();

        $participants = Registration::with(['presences'])
        ->where('event_id', $data->id)->paginate(20);

        $currentPageItems = $participants->getCollection()->map(function ($registrant) use ($distinctDates) {
            $missedDates = $distinctDates->filter(function ($date) use ($registrant) {
                return !$registrant->presences->contains(function ($presence) use ($date) {
                    return Carbon::parse($presence->waktu_hadir)->format('Y-m-d') === $date;
                });
            });

            $registrant->missedDates = $missedDates;

            return $registrant;
        });

        // Filter participants based on whether they missed the specific date
        $filteredItems = $currentPageItems->filter(function ($registrant) use ($checkInDate) {
            return $registrant->missedDates->contains($checkInDate);
        });

        // Sort the filtered items alphabetically by name for clarity (optional)
        $sortedItems = $filteredItems->sortBy('full_name')->values();

        // Replace the paginator's collection with the sorted and filtered data
        $participants->setCollection($sortedItems);

        $district = "All";
        $unattendedCount = $currentPageItems->filter(function ($registrant) {
            return $registrant->missedDates->isNotEmpty();
        })->count();
        // $unattendedCount = $unattendedParticipants->count();

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $unattendedCount = $participants->count();

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-unattended', compact('participants', 'district','checkInDate', 'data','unattendedCount'));

        return $pdf->download('Unattended_participants_' .$district. '.pdf');
    }

    public function exportUnattendedParticipantsAsPdf() {
        
        $participants = Registration::WhereNull('registrations.status_kehadiran'
        )->get();

        $data = Event::whereDate('registration_start_at', '<=', Carbon::today())
        ->whereDate('event_end_at', '>=', Carbon::today())
        ->first();

        $district = "All";

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $unattendedCount = $participants->count();

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-unattended', compact('participants', 'district', 'data','unattendedCount', 'hadirDate'));

        return $pdf->download('Unattended_participants_' .$district. '.pdf');
    }

    public function exportAttendedParticipantsByDate($checkInDate, Event $data) {        

        $participants = Registration::Where('event_id', $data->id)
        ->whereHas('presences', function ($query) use ($checkInDate) {
            $query->whereDate('waktu_hadir', $checkInDate);
        })
        ->with(['presences' => function ($query) use ($checkInDate) {
            $query->whereDate('waktu_hadir', $checkInDate);
        }])->get();

        $district = "All";

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-attended', compact('participants', 'data', 'checkInDate'));

        return $pdf->download('Attended_participants_' .$district. '.pdf');
    }

    public function exportAttendedParticipants() {
        
        $participants = Registration::Where('status_kehadiran', 'HADIR'
        )->get();

        $data = Event::whereDate('registration_start_at', '<=', Carbon::today())
        ->whereDate('event_end_at', '>=', Carbon::today())
        ->first();  

        $hadirDate = $participants->where('status_kehadiran', 'HADIR')->first()?->updated_at->format('d-m-Y') ?? '-';

        $district = "All";

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-attended', compact('participants', 'district', 'data', 'hadirDate'));

        return $pdf->download('Attended_participants_' .$district. '.pdf');
    }

    public function exportAttendedParticipantsByDistrict(string $district) {
        
        $participants = Registration::Where('registrations.status_kehadiran', 'HADIR'
        )->where('district', $district)->get();

        $data = Event::whereDate('registration_start_at', '<=', Carbon::today())
        ->whereDate('event_end_at', '>=', Carbon::today())
        ->first();  

        $hadirDate = $participants->where('status_kehadiran', 'HADIR')->first()?->updated_at->format('d-m-Y') ?? '-';

        if (!$participants) {
            abort(404, 'Member not found');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->setBasePath(public_path());
        $pdf->loadView('manage.participant.export-pdf-attended', compact('participants', 'district', 'data', 'hadirDate'));

        return $pdf->download('Attended_participants_' .$district. '.pdf');
    }

    public function checkPresence(Request $request)
    {

        $now = Carbon::now();
        if (auth()->user()->hasRole(['admin', 'admin-administrator'])) {
            $uuidData = Uuid::where('uuid', $request->input('uuid'))->first();        
            // Get the current date and time

            $event = Event::whereDate('event_start_at', '<=', Carbon::today())
            ->whereDate('event_end_at', '>=', Carbon::today())
            ->first();

            if ($event === null) {
                // If no such event exists, return an error
                return response()->json(['error' => 'The event has not started yet.'], 404);
            }

            $registrant = Registration::where('event_id', $event->id)->where('user_id', $uuidData->user_id)->first();
            if ($registrant === null) {
                return response()->json(['error' => 'This member has not registered on this event yet.'], 400);
            }
        
            // Check if the current date and time is the same or after the valid_on date
            if ($now->greaterThanOrEqualTo(Carbon::parse($uuidData->valid_on))) {
                    Presence::create([
                        "event_id" => $event->id,
                        "registrant_id" => $registrant->id,
                        "waktu_hadir" => Carbon::now()
                    ]);
        
                return response()->json(['success' => 'UUID is valid, presence confirmed.'], 200);
            } else {
                return response()->json(['error' => 'UUID is not yet valid.'], 400);
            }
        } else {
            return response()->json(['redirect' => 'Redirect to User Detail'], 404);
        }
    }

    public function showCheckStatus(Request $request) {
    
        $response = $this->checkPresence($request);

        $responseData = json_decode($response->getContent(), true);        

        if (isset($responseData['error'])) {
            Alert::error('Error', $responseData['error']);
            return redirect('/dashboard')->with('error', $responseData['error']);
        }

        if (isset($responseData['redirect'])) {
            return redirect('/dashboard');
        }

        Alert::success('Success', $responseData['success']);
        return redirect('/dashboard')->with('success', $responseData['success']);
    }

    public function resetStatusKehadiran()
    {
        // Update all records by setting status_kehadiran to null
        Registration::query()->update(['status_kehadiran' => null]);

        // Return a success response
        return redirect()->back()->with('success', 'All attendance statuses have been reset.');
    }
}
