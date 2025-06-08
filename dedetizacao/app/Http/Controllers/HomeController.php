<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avaliacao;


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
        $agendamentos = [];

        if (auth()->check() && auth()->user()->is_admin) {
            $agendamentos = \App\Models\Agendamento::where('status', 'confirmado')->with('user')->get();
        }

        $avaliacoes = Avaliacao::with('user')->latest()->get();

        return view('home', compact('agendamentos', 'avaliacoes'));
    }


}
