@extends('layouts.app')

@section('content')
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .table thead {
            background-color: #004d00;
            color: white;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table tbody tr:nth-child(even) {
            background-color: rgb(61, 128, 44);
        }

        .btn-confirmar {
            background-color: #004d00;
            color: white;
            border: none;
            padding: 4px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .btn-confirmar:hover {
            background-color: #003300;
        }

        .btn-cancelar {
            background-color: #cc7a00;
            color: white;
            border: none;
            padding: 4px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .btn-cancelar:hover {
            background-color: #995c00;
        }

        .btn-editar {
            background-color: #0066cc;
            color: white;
            border: none;
            padding: 4px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .btn-editar:hover {
            background-color: #004d99;
        }

        .btn-excluir {
            background-color: #cc0000;
            color: white;
            border: none;
            padding: 4px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .btn-excluir:hover {
            background-color: #990000;
        }

        form[style="display:inline-block;"] {
            margin-right: 5px;
            display: inline-block;
        }
    </style>

    <h3>Painel do Administrador</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Endereço</th>
                <th>Data</th>
                <th>Tipo de Praga</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agendamentos as $ag)
                <tr>
                    <td>{{ $ag->user->name }}</td>
                    <td>{{ $ag->user->address ?? 'Não informado' }}</td>
                    <td>{{ $ag->data }}</td>
                    <td>{{ $ag->tipo_peste ?? 'Não informado' }}</td>
                    <td>{{ ucfirst($ag->status) }}</td>
                    <td>
                        @if($ag->status === 'pendente')
                            <form action="/admin/confirmar/{{ $ag->id }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button class="btn-confirmar btn-sm" type="submit">Confirmar</button>
                            </form>
                            <form action="/admin/cancelar/{{ $ag->id }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button class="btn-cancelar btn-sm" type="submit">Cancelar</button>
                            </form>
                        @endif
                        @if($ag->status !== 'cancelado')
                            <a href="/admin/editar/{{ $ag->id }}" class="btn-editar btn-sm">Editar</a>
                        @endif
                        <form action="/admin/excluir/{{ $ag->id }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn-excluir btn-sm" type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection