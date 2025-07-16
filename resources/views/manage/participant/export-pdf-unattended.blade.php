<!-- resources/views/expenses-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Unattended Participants Report on {{ \Carbon\Carbon::parse($checkInDate)->format('d F Y') }}</title>
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
    <p>Jalan Mujahidin No. 12 Kec. Pontianak Selatan 78121<br>Pontianak, Kalimantan Barat</p>
    <h1>Event : {{'Lions ' . $data->event_name}}</h1>
    <h2>Unattended Participants Report on {{ \Carbon\Carbon::parse($checkInDate)->format('d F Y') }}</h2>
    <h3>Unattended Participants: {{ $unattendedCount ?? 0 }} Participants</h3>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>District</th>
                <th>Full Name</th>
                <th>Club Name</th>
                <th>Title</th>
                <th>Phone Number</th>
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
                <td>{{ $participant->phone_number ?? '-'}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="text-align: center; margin-top: 20px;">Exported By: {{ Auth::user()->full_name }}  on <?php echo date('Y-m-d h:i:s'); ?></p>
</body>
</html>
