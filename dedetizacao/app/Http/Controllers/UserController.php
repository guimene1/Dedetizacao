<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function create()
    {
        $datasAgendadas = Agendamento::where('status', '!=', 'cancelado')
            ->orderBy('data', 'asc')
            ->pluck('data')
            ->toArray();

        return view('user.agendar', compact('datasAgendadas'));
    }

    public function store(Request $request)
    {
        $datasAgendadas = Agendamento::where('status', '!=', 'cancelado')
            ->pluck('data')
            ->toArray();

        $validator = Validator::make($request->all(), [
            'data' => [
                'required',
                'date',
                'after:today',
                function ($attribute, $value, $fail) use ($datasAgendadas) {
                    if (in_array($value, $datasAgendadas)) {
                        $fail('Esta data já está agendada. Por favor, escolha outra.');
                    }
                },
            ],
            'tipo_peste' => 'required|string',
        ], [
            'data.required' => 'A data do agendamento é obrigatória.',
            'data.date' => 'Informe uma data válida.',
            'data.after' => 'A data deve ser posterior a hoje.',
            'tipo_peste.required' => 'Você deve selecionar o tipo de praga.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Agendamento::create([
            'user_id' => auth()->id(),
            'data' => $request->data,
            'status' => 'pendente',
            'tipo_peste' => $request->tipo_peste,
        ]);

        return redirect('/meus-agendamentos')->with('success', 'Agendamento realizado com sucesso!');
    }

    public function index()
    {
        $agendamentos = Agendamento::where('user_id', auth()->id())->get();
        return view('user.meus-agendamentos', compact('agendamentos'));
    }
    public function edit($id)
    {
        $agendamento = Agendamento::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pendente')
            ->firstOrFail();

        return view('user.editar-agendamento', compact('agendamento'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_peste' => 'required|string',
            'endereco' => 'required|string',
        ], [
            'tipo_peste.required' => 'O tipo de praga é obrigatório.',
            'endereco.required' => 'O endereço é obrigatório.',
        ]);

        $agendamento = Agendamento::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pendente')
            ->firstOrFail();

        $agendamento->tipo_peste = $request->tipo_peste;
        $agendamento->user->address = $request->endereco;
        $agendamento->user->save();
        $agendamento->save();

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado com sucesso.');
    }


}
