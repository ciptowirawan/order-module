<!-- resources/views/expenses-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Event Participants Report for {{$district}} District</title>
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
    <h2>Event Participants Report for {{$district}} District</h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>District</th>
                <th>Full Name</th>
                <th>Club Name</th>
                <th>Title</th>
                <th>Devotional Period</th>
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
                <td>{{ date('Y', strtotime($participant->user->member_activate_in)). " - " . date('Y', strtotime($participant->user->member_over_in))}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="text-align: center; margin-top: 20px;">Exported By: {{ Auth::user()->full_name }}  on <?php echo date('Y-m-d h:i:s'); ?></p>
</body>
</html>
