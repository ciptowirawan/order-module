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
    </style>
</head>
<body>
    <h1>Event Participants Report for {{$district}} District</h1>
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
</body>
</html>
