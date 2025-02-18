<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserLogin extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';
    protected static string $view = 'filament.auth.user-login';

    public $email;
    public $password;
    public $remember = false;

    public function login()
    {
        $credentials = $this->only(['email', 'password']);

        if (!Auth::attempt($credentials, $this->remember)) {
            throw ValidationException::withMessages([
                'email' => __('Email atau password salah.'),
            ]);
        }

        session()->regenerate();

        return redirect()->intended('/dashboard'); // Sesuaikan dengan rute tujuan setelah login
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(),

            Checkbox::make('remember')
                ->label('Ingat saya'),

        ])->statePath('data');
    }
}
