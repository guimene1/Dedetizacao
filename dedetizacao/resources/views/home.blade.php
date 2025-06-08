@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-info rounded-3 my-4 py-3 px-4"
            style="font-size: 1.2rem; font-weight: 600; color:rgb(26, 78, 37); background-color:rgb(53, 116, 61); border-color:rgb(58, 117, 52);">
            <p class="mb-0">
                <strong>Sua casa precisa de dedetização?</strong><br>
                Proteja seu lar contra pragas indesejadas e garanta um ambiente saudável para sua família.<br>
                Agende agora mesmo uma dedetização rápida, eficaz e feita por profissionais qualificados!
            </p>
        </div>

        <h2 class="mb-4">Bem-vindo ao Sistema de Dedetização!</h2>

        @auth
            @if(auth()->user()->is_admin)
                <h3 class="mb-3">Agendamentos Confirmados:</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Endereço</th>
                                <th>Data</th>
                                <th>Peste</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agendamentos as $a)
                                <tr>
                                    <td>{{ $a->user->name }}</td>
                                    <td>{{ $a->user->address }}</td>
                                    <td>{{ \Carbon\Carbon::parse($a->data)->format('d/m/Y') }}</td>
                                    <td>{{ \Illuminate\Support\Str::of($a->tipo_peste)->replace('_', ' ')->title() ?? 'Não informado' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr class="my-4">
            @endif

            <h3 class="mb-3">Avaliações de Usuários</h3>

            <form action="{{ route('avaliacoes.store') }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-3">
                    <textarea name="comentario" rows="3" class="form-control" placeholder="Deixe seu comentário..."
                        required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
            </form>
            <h1>Avaliações</h1>
            @foreach($avaliacoes as $avaliacao)
                <div class="mb-3 p-3 border rounded bg-light">
                    <strong>{{ $avaliacao->user->name }}</strong>
                    <small class="text-muted">- {{ $avaliacao->created_at->format('d/m/Y H:i') }}</small>
                    <p class="mt-2 mb-0">{{ $avaliacao->comentario }}</p>
                </div>
            @endforeach
        <br>
        <br>
        <br>
        <br>
        @endauth
    </div>
@endsection