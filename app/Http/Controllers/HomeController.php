<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prestador;

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
        $user_id = \Auth::user()->id;

        $prestador_menu = \DB::select("SELECT obrasocial.nombre, obrasocial.id FROM obrasocial LEFT JOIN prestador on prestador.os_id = obrasocial.id WHERE prestador.user_id = " . $user_id . " GROUP BY obrasocial.id, obrasocial.nombre");

        return view('home', [
            "prestador" => $prestador_menu
        ]);
    }
}
