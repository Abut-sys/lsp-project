@extends('layouts.detail_kamar')

@section('content')
<div class="container mx-auto p-4 text-center">
    <h1 class="text-2xl font-bold">Pembayaran Kamar: {{ $room->roomType->name }} - No. {{ $room->room_number }}</h1>
    <p class="text-lg text-gray-700 mt-2">Harga: <strong>Rp {{ number_format($room->price, 0, ',', '.') }}</strong></p>

    <button id="pay-button"
        class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-300 mt-4">
        Bayar Sekarang
    </button>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                alert('Pembayaran berhasil!');
                console.log(result);
                window.location.href = "{{ route('home') }}"; // Redirect setelah pembayaran sukses
            },
            onPending: function(result) {
                alert('Menunggu pembayaran...');
                console.log(result);
            },
            onError: function(result) {
                alert('Pembayaran gagal!');
                console.log(result);
            }
        });
    };
</script>
@endsection
