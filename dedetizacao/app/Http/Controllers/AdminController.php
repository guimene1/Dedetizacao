<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $agendamentos = \App\Models\Agendamento::with('user')->get();
        return view('admin.index', compact('agendamentos'));
    }

    public function confirm($id)
    {
        $agendamento = \App\Models\Agendamento::findOrFail($id);
        $agendamento->update(['status' => 'confirmado']);
        return back();
    }

    public function cancel($id)
    {
        $agendamento = \App\Models\Agendamento::findOrFail($id);
        $agendamento->update(['status' => 'cancelado']);
        return back();
    }

    public function edit($id)
    {
        $agendamento = \App\Models\Agendamento::findOrFail($id);
        return view('admin.edit', compact('agendamento'));
    }

    /* validação para não ter datas repetidas */
    public function update(Request $request, $id)
    {
        $datasAgendadas = \App\Models\Agendamento::where('id', '!=', $id)->where('status', '!=', 'cancelado')->pluck('data')->toArray();
        $request->validate([
            'data' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($datasAgendadas) {
                    if (in_array($value, $datasAgendadas)) {
                        $fail('Essa data já está agendada. Por favor, escolha outra.');
                    }
                },
            ],
            'status' => 'required|in:pendente,confirmado,cancelado',
        ], [
            'data.required' => 'A data é obrigatória.',
            'data.date' => 'Informe uma data válida.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status selecionado não é válido.',
        ]);


        $agendamento = \App\Models\Agendamento::findOrFail($id);
        $agendamento->update([
            'data' => $request->data,
            'status' => $request->status,
        ]);

        return redirect('/admin')->with('success', 'Agendamento atualizado com sucesso!');
    }



    public function destroy($id)
    {
        \App\Models\Agendamento::destroy($id);
        return back();
    }

}
