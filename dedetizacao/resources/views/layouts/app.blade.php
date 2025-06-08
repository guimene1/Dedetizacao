<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Dedetização</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
</head>

<body>
    <div id="app">
        <nav class="navbar" aria-label="Navegação principal">
    <div class="container">
        <form action="{{ url('/') }}" method="GET" class="d-inline">
            <button type="submit" class="btn btn-link navbar-brand p-0 m-0">Dedetização</button>
        </form>

        <ul class="navbar-nav">
            @guest
                @if (Route::has('login'))
                    <li>
                        <form action="{{ route('login') }}" method="GET" class="d-inline">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li>
                        <form action="{{ route('register') }}" method="GET" class="d-inline">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </form>
                    </li>
                @endif
            @else
                @if(Auth::user()->is_admin)
                    <li>
                        <form action="/admin" method="GET" class="d-inline">
                            <button type="submit" class="btn btn-primary">Painel Admin</button>
                        </form>
                    </li>
                @else
                    <li>
                        <form action="/agendar" method="GET" class="d-inline">
                            <button type="submit" class="btn btn-primary">Agendar</button>
                        </form>
                    </li>
                    <li>
                        <form action="/meus-agendamentos" method="GET" class="d-inline">
                            <button type="submit" class="btn btn-primary">Meus Agendamentos</button>
                        </form>
                    </li>
                @endif

                <li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Sair</button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>


        <main class="main-content container">
            @yield('content')
        </main>

        <footer>
            &copy; {{ date('Y') }} Sistema de Agendamento de Dedetização. Todos os direitos reservados.
        </footer>
    </div>
</body>