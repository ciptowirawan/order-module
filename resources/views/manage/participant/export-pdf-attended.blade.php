<!-- resources/views/expenses-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Attended Participants Report on {{ \Carbon\Carbon::parse($checkInDate)->format('d F Y') }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        h1 {
            margin-bottom: 0;
            text-align: center;
        }
        p {
            margin-top: 0;
            text-align:center;
        }
    </style>
</head>
<body>
    <h1>Lions Clubs Multiple District 307</h1>
    <p>Gedung PPMLI Jl. Pluit Timur Raya Kavling B2, RT.10/RW.9, Pluit, Kec. Penjaringan, Jkt Utara, Daerah Khusus Ibukota Jakarta 14450</p>
    <h1>Event : {{'Lions ' . $data->event_name}}</h1>
    <h2>Attended Participants Report on {{ \Carbon\Carbon::parse($checkInDate)->format('d F Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>District</th>
                <th>Full Name</th>
                <th>Club Name</th>
                <th>Title</th>
                <th>Check In</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $participant)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $participant->district ?? "-" }}</td>
                <td>{{ $participant->full_name }}</td>
                <td>{{ $participant->club_name == "" || $participant->club_name == null ? "-" : $participant->club_name }}</td>
                <td>{{ $participant->title ?? '-'}}</td>
                @foreach($participant->presences as $presence)
                   <td>{{ $presence->waktu_hadir }}</td>
                @endforeach
                
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
