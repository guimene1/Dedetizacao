<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avaliacao;

class AvaliacaoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comentario' => 'required|string|max:1000',
        ]);

        Avaliacao::create([
            'user_id' => auth()->id(),
            'comentario' => $request->comentario,
        ]);

        return redirect()->back()->with('success', 'Avaliação enviada com sucesso!');
    }
}
