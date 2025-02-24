<?php

use Filament\Facades\Filament;
use App\Filament\Pages\UserLogin;
use Filament\Pages\Auth\EditProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Filament\Resources\RoomResource;
use App\Filament\Resources\UserResource;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Filament\Resources\BookingResource;
use App\Http\Controllers\ProfileController;
use App\Filament\Resources\FacilityResource;
use App\Filament\Resources\RoomTypeResource;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserRegisterController;

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
})->name('welcome');

// Middleware untuk admin (akses ke Filament)
Route::middleware(['auth', 'admin'])->group(function () {
    // Akses ke Filament Panel langsung
    Route::get('/admin', function () {
        return redirect(Filament::getPanel('admin')->getUrl());
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('user.profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('user.profile.update');
});

Route::get('/register', [UserRegisterController::class, 'showRegisterForm'])->name('user.register.email');
Route::post('/register', [UserRegisterController::class, 'registerWithEmail'])->name('user.register.email.submit');

Route::get('/register/phone', [UserRegisterController::class, 'showRegisterPhoneForm'])->name('user.register.phone');
Route::post('/register/phone', [UserRegisterController::class, 'registerWithPhone'])->name('user.register.phone.submit');

Route::get('/login', [UserLoginController::class, 'showEmailLoginForm'])->name('user.login.email');
Route::get('/login/phone', [UserLoginController::class, 'showPhoneLoginForm'])->name('user.login.phone');

Route::post('/login', [UserLoginController::class, 'loginWithEmail'])->name('user.login.email.submit');
Route::post('/login/phone', [UserLoginController::class, 'loginWithPhone'])->name('user.login.phone.submit');

Route::post('/logout', [UserLoginController::class, 'logout'])->name('user.logout');
