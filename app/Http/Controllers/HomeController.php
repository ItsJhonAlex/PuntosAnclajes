<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PuntoAnclaje;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $listaPrecintosDuplicadosSTR = \Session::pull('$listaPrecintosDuplicadosSTR');
        \Session::forget('$listaPrecintosDuplicadosSTR');
        \Session::save();

        return view('home',compact('listaPrecintosDuplicadosSTR'));
    }
}
