@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="mb-3" style="color: var(--primary-color); font-weight: 800;">Meus Agendamentos</h3>

        @if($agendamentos->isEmpty())
            <p class="text-muted">Você ainda não fez nenhum agendamento.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Tipo da Peste</th>
                            <th>Endereço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agendamentos as $a)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($a->data)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="status-badge 
                                        @if($a->status === 'confirmado') status-confirmado
                                        @elseif($a->status === 'pendente') status-pendente
                                        @elseif($a->status === 'cancelado') status-cancelado
                                        @endif">
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </td>
                                <td>{{ \Illuminate\Support\Str::of($a->tipo_peste)->replace('_', ' ')->title() }}</td>
                                <td>{{ $a->user->address ?? 'Endereço não disponível' }}</td>
                                <td>
                                    @if($a->status === 'pendente')
                                        <a href="{{ route('agendamentos.edit', $a->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
