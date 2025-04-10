<?php

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransCallbackController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handleCallback']);

Route::get('/rooms/{room}/availability', function (Room $room) {
    $checkIn = request('check_in');
    $checkOut = request('check_out');

    return response()->json([
        'available' => $room->isAvailable($checkIn, $checkOut)
    ]);
});
