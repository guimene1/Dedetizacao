@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="mb-4" style="color: var(--primary-color); font-weight: 800;">Agendar Dedetização</h3>

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
   
        @if (!empty($datasAgendadas))
            <div class="alert alert-info">
                <strong>Datas indisponíveis:</strong><br>
                @foreach ($datasAgendadas as $data)
                    {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}@if(!$loop->last), @endif
                @endforeach
            </div>
        @endif

        <form action="/agendar" method="POST" class="form-agendamento">
            @csrf
            <div class="mb-3">
                <label for="data" class="form-label">Data:</label>
                <input type="date" id="data" name="data" class="form-control" required>
            </div>

            <div class="mb-4">
                <label for="tipo_peste" class="form-label">Tipo de Praga</label>
                <select name="tipo_peste" id="tipo_peste" class="form-control" required>
                    <option value="">Selecione</option>
                    <option value="roedores">Roedores</option>
                    <option value="insetos_rasteiros">Insetos Rasteiros</option>
                    <option value="insetos_voadores">Insetos Voadores</option>
                    <option value="pragas_de_madeira">Pragas de Madeira</option>
                    <option value="outros">Outros</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Agendar</button>
        </form>
    </div>
@endsection