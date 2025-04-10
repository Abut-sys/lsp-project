<?php

use Filament\Facades\Filament;
use App\Filament\Pages\UserLogin;
use Filament\Pages\Auth\EditProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Filament\Resources\RoomResource;
use App\Filament\Resources\UserResource;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReportController;
use App\Filament\Resources\BookingResource;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Filament\Resources\FacilityResource;
use App\Filament\Resources\RoomTypeResource;
use App\Http\Controllers\RoomListController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordOtpController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome.home');

Route::get('/', [RoomListController::class, 'showPopularHotels'])->name('welcome.home');

Route::get('/room/{roomNumber}', [RoomController::class, 'show'])->name('room.show');

// Middleware untuk admin (akses ke Filament)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return redirect(Filament::getPanel('admin')->getUrl());
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('user.profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('user.profile.update');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    Route::get('/booking-history', [BookingController::class, 'history'])->name('booking.history');

    Route::post('/payment/{room}', [PaymentController::class, 'process'])->name('payment.process');
    Route::post('/payment/notification', [PaymentController::class, 'handleNotification']);

    Route::post('/logout', [UserLoginController::class, 'logout'])->name('user.logout');


});

Route::middleware('guest')->group(function () {
    Route::get('/register', [UserRegisterController::class, 'showRegisterForm'])->name('user.register.email');
    Route::post('/register', [UserRegisterController::class, 'registerWithEmail'])->name('user.register.email.submit');

    Route::get('/register/phone', [UserRegisterController::class, 'showRegisterPhoneForm'])->name('user.register.phone');
    Route::post('/register/phone', [UserRegisterController::class, 'registerWithPhone'])->name('user.register.phone.submit');

    Route::get('/login', [UserLoginController::class, 'showEmailLoginForm'])->name('user.login.email');
    Route::get('/login/phone', [UserLoginController::class, 'showPhoneLoginForm'])->name('user.login.phone');
    Route::post('/login', [UserLoginController::class, 'loginWithEmail'])->name('user.login.email.submit');
    Route::post('/login/phone', [UserLoginController::class, 'loginWithPhone'])->name('user.login.phone.submit');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetOtp'])->name('password.sendotp');
    Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('password.verifyotp');
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.checkotp');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

