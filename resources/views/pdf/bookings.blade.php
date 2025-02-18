<!DOCTYPE html>
<html>
<head>
    <title>Data Booking</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Data Booking</h1>
    <table>
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Kamar</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->room->room_number }}</td>
                    <td>{{ $booking->check_in_date }}</td>
                    <td>{{ $booking->check_out_date }}</td>
                    <td>{{ $booking->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
