<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama.
     */
    public function index()
    {
        return view('welcome'); // Mengarahkan ke tampilan home.blade.php
    }
}
