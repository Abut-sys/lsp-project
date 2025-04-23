<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        Log::info('Midtrans Callback Received:', $request->all());

        // 1. Validasi Signature Key
        $serverKey = config('services.midtrans.server_key');
        $hashedSignature = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($hashedSignature !== $request->signature_key) {
            Log::error('Invalid Midtrans Signature');
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // 2. Ambil order_id dan transaction_status
        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status; 

        // 3. Cari booking berdasarkan order_id (bukan ID database)
        $booking = Booking::where('order_id', $orderId)->first();

        if (!$booking) {
            Log::error('Booking not found: ' . $orderId);
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // 4. Update status
        switch (strtolower($transactionStatus)) {
            case 'settlement':
                $booking->update([
                    'payment_status' => 'settlement',
                    'status' => 'confirmed'
                ]);
                break;

            case 'pending':
                $booking->update(['payment_status' => 'pending']);
                break;

            case 'expire':
            case 'cancel':
            case 'deny':
                $booking->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled'
                ]);
                break;
        }

        Log::info('Booking Updated:', $booking->toArray());
        return response()->json(['message' => 'Status updated']);
    }
}
