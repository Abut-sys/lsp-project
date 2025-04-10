<!DOCTYPE html>
<html>
<head>
    <title>Data Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            text-align: center;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background-color: #007bff;
            color: white;
            padding: 12px;
            text-transform: uppercase;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .status {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }

        .status-confirmed {
            background-color: #28a745;
            color: white;
        }

        .status-cancelled {
            background-color: #dc3545;
            color: white;
        }

        .status-pending {
            background-color: #ffc107;
            color: black;
        }
    </style>
</head>
<body>
    <h1>Data Booking</h1>

    @php
    // Definisikan array terjemahan status
    $statusTranslations = [
        'pending' => 'Menunggu Pembayaran',
        'confirmed' => 'Dibayar',
        'failure' => 'Gagal',
        'cancel' => 'Dibatalkan'
    ];
    @endphp

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
                    <td>
                        <span class="status
                            @if($booking->payment_status == 'confirmed') status-confirmed
                            @elseif($booking->payment_status == 'cancelled') status-cancelled
                            @else status-pending
                            @endif">
                            {{ $statusTranslations[$booking->payment_status] ?? $booking->payment_status }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
