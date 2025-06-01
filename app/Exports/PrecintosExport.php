<?php

namespace App\Exports;

use App\Models\PuntoAnclaje;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;


class PrecintosExport implements FromView
{

    public function view(): View
    {
        return view('exports.precintos', [
            'precintos' => PuntoAnclaje::with('empresa')->get()
        ]);
    }
}
