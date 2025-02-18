<?php

use App\Filament\Pages\UserLogin;
use Filament\Pages\Auth\EditProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\UserLoginController;

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
    return view('filament.welcome');
})->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return $user->role === 'admin'
            ? redirect()->route('filament.admin.pages.dashboard')
            : redirect()->route('welcome');
    })->name('dashboard');
});


Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserLoginController::class, 'login'])->name('login.submit');

// Route logout
Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');

Route::get('/login', UserLogin::class)->name('login');
