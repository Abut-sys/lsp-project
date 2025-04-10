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

        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status;

        $booking = Booking::find($orderId);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Update status pembayaran berdasarkan response dari Midtrans
        if ($transactionStatus == 'settlement') {
            $booking->update([
                'payment_status' => 'settlement',
                'status' => 'confirmed',
            ]);
        } elseif ($transactionStatus == 'pending') {
            $booking->update(['payment_status' => 'pending']);
        } elseif (in_array($transactionStatus, ['cancel', 'failure', 'expire'])) {
            $booking->update([
                'payment_status' => 'failure',
                'status' => 'cancelled',
            ]);
        }

        return response()->json(['message' => 'Payment status updated']);
    }
}
