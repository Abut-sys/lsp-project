<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function process(Request $request, Room $room)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        Log::debug('Booking validation passed', $validated);

        // Cek konflik dengan booking user yang sudah ada
        if ($this->hasBookingConflict($user, $room, $validated)) {
            Log::warning('Booking conflict detected', ['user_id' => $user->id, 'room_id' => $room->id, 'dates' => $validated]);
            return redirect()
                ->back()
                ->withErrors(['dates' => 'Anda sudah memiliki pemesanan aktif untuk kamar ini di tanggal tersebut'])
                ->withInput();
        }

        // Validasi ketersediaan kamar untuk pengguna lain
        if (!$room->isAvailable($validated['check_in_date'], $validated['check_out_date'], $user->id)) {
            Log::warning('Room not available', ['room_id' => $room->id, 'dates' => $validated]);
            return redirect()
                ->back()
                ->withErrors(['check_in_date' => 'Kamar tidak tersedia pada tanggal yang dipilih'])
                ->withInput();
        }

        // Hitung durasi dan total harga
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $totalPrice = $room->price * $checkIn->diffInDays($checkOut);

        // Buat booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'total_price' => $totalPrice,
            'payment_status' => 'pending',
        ]);

        Log::debug('Booking created', ['booking_id' => $booking->id]);

        // Proses pembayaran Midtrans
        $midtrans = new MidtransService();
        $transactionData = $this->prepareTransactionData($booking, $user, $totalPrice);

        Log::debug('Preparing transaction data', $transactionData);

        $response = $midtrans->createTransaction($transactionData);

        Log::debug('Midtrans response', $response);

        if (isset($response['token']) && isset($response['redirect_url'])) {
            $booking->update(['midtrans_token' => $response['token']]);
            return redirect()->away($response['redirect_url']);
        }

        Log::error('Failed to get Midtrans token or redirect URL', $response);

        return back()->with('error', 'Gagal memproses pembayaran');
    }

    private function hasBookingConflict($user, $room, $dates)
    {
        return $user
            ->bookings()
            ->where('room_id', $room->id)
            ->where('payment_status', 'confirmed')
            ->where(function ($query) use ($dates) {
                $query
                    ->whereBetween('check_in_date', [$dates['check_in_date'], $dates['check_out_date']])
                    ->orWhereBetween('check_out_date', [$dates['check_in_date'], $dates['check_out_date']])
                    ->orWhere(function ($q) use ($dates) {
                        $q->where('check_in_date', '<', $dates['check_in_date'])->where('check_out_date', '>', $dates['check_out_date']);
                    });
            })
            ->exists();
    }

    private function prepareTransactionData($booking, $user, $totalPrice)
    {
        return [
            'transaction_details' => [
                'order_id' => "BOOKING-{$booking->id}-" . now()->timestamp,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
            'callbacks' => [
                'finish' => route('welcome.home', $booking->id),
                'error' => route('welcome.home', $booking->id),
            ],
            'metadata' => [
                'booking_id' => $booking->id,
                'user_id' => $user->id,
            ],
        ];
    }

    public function handleNotification(Request $request)
    {
        $payload = $request->all();

        Log::debug('Midtrans notification received', $payload);

        // Validasi signature key
        $signatureKey = hash('sha512', $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . config('services.midtrans.server_key'));

        if ($payload['signature_key'] !== $signatureKey) {
            Log::error('Invalid signature key', ['received' => $payload['signature_key'], 'expected' => $signatureKey]);
            return response()->json(['status' => 'Invalid signature'], 403);
        }

        // Proses update status booking
        $booking = $this->processBookingStatus($payload);

        return response()->json(['status' => 'success']);
    }

    private function processBookingStatus($payload)
    {
        $parts = explode('-', $payload['order_id']);
        $bookingId = $parts[1] ?? null;
        $booking = Booking::findOrFail($bookingId);

        Log::debug('Processing booking status', ['booking_id' => $bookingId, 'status' => $payload['transaction_status']]);

        $status = $this->mapPaymentStatus($payload['transaction_status']);

        $booking->update([
            'payment_status' => $status,
            'midtrans_response' => json_encode($payload),
        ]);

        if ($status === 'confirmed') {
            $room = $booking->room;
            $room->update(['is_available' => false]);
        }

        return $booking;
    }

    private function mapPaymentStatus($transactionStatus)
    {
        Log::debug('Mapping payment status', ['input' => $transactionStatus]);

        return match ($transactionStatus) {
            'capture', 'settlement' => 'confirmed',
            'pending' => 'pending',
            'expire' => 'expired',
            'cancel', 'deny' => 'canceled',
            default => 'failed',
        };
    }
}
