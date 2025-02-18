<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generatePDF()
    {
        $reservations = Reservation::all();
        $pdf = Pdf::loadView('reports.reservations', compact('reservations'));

        return $pdf->download('reservation_report.pdf');
    }
}

