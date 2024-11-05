<!-- resources/views/expenses-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Inactive Members Report</title>
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
    <h1>Inactive Members Report</h1>
    <h2>District with Most Inactive Members: {{ $districtWithMostInactive ?? '-' }} ({{ $mostInactiveDistrictCount ?? 0 }} members)</h2>
    <h2>District with Least Inactive Members: {{ $districtWithLeastInactive ?? '-' }} ({{ $leastInactiveDistrictCount ?? 0 }} members)</h2>
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
</body>
</html>
