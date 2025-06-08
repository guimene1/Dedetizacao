@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Editar Agendamento</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="/admin/atualizar/{{ $agendamento->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="data" class="form-label">Data da Dedetização</label>
                <input type="date" name="data" id="data" class="form-control" value="{{ $agendamento->data }}" required>

            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="pendente" {{ $agendamento->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="confirmado" {{ $agendamento->status == 'confirmado' ? 'selected' : '' }}>Confirmado
                    </option>
                    <option value="cancelado" {{ $agendamento->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <form action="/admin" method="GET" class="d-inline">
                <button type="submit" class="btn btn-primary">Cancelar</button>
            </form>
        </form>
    </div>
@endsection