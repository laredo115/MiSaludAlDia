<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Mi Salud al Día')</title>
    <link rel="stylesheet" href="{{ asset('css/salud.css') }}">
</head>
<body>
    <header class="cabecera">
        <a href="{{ url('/') }}">Mi Salud al Día</a>
    </header>

    <main class="contenedor">
        @if ($errors->any())
            <div class="mensaje error" role="alert">
                <p>Revisa los siguientes datos:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mensaje" role="status">
                {{ session('status') }}
            </div>
        @endif

        @yield('contenido')
    </main>
</body>
</html>