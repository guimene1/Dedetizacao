@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Editar Agendamento</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('agendamentos.update', $agendamento->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="tipo_peste" class="form-label">Tipo de Praga</label>
                <select name="tipo_peste" id="tipo_peste" class="form-control" required>
                    <option value="">Selecione</option>
                    <option value="roedores" {{ $agendamento->tipo_peste == 'roedores' ? 'selected' : '' }}>Roedores</option>
                    <option value="insetos_rasteiros" {{ $agendamento->tipo_peste == 'insetos_rasteiros' ? 'selected' : '' }}>
                        Insetos Rasteiros</option>
                    <option value="insetos_voadores" {{ $agendamento->tipo_peste == 'insetos_voadores' ? 'selected' : '' }}>
                        Insetos Voadores</option>
                    <option value="pragas_de_madeira" {{ $agendamento->tipo_peste == 'pragas_de_madeira' ? 'selected' : '' }}>
                        Pragas de Madeira</option>
                    <option value="outros" {{ $agendamento->tipo_peste == 'outros' ? 'selected' : '' }}>Outros</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <input type="text" name="endereco" id="endereco" class="form-control"
                    value="{{ $agendamento->user->address }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>

        <!-- Botão Cancelar como form GET -->
        <form action="{{ route('agendamentos.index') }}" method="GET" class="d-inline">
            <button type="submit" class="btn btn-primary">Cancelar</button>
        </form>

    </div>
@endsection