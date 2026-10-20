@extends('layouts.app')

@section('titulo', 'Iniciar sesión | Mi Salud al Día')

@section('contenido')
    <section class="tarjeta">
        <h1>Iniciar sesión</h1>
        <p>Accede para organizar tus medicamentos y citas.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Correo electrónico</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                autocomplete="username"
                maxlength="255"
                required
                autofocus
            >

            <label for="password">Contraseña</label>
            <input
                id="password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
            >

            <button type="submit">Entrar</button>
        </form>

        <p>
            ¿No tienes cuenta?
            <a href="{{ route('register') }}">Regístrate</a>
        </p>
    </section>
@endsection