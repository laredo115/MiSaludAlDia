@extends('layouts.app')

@section('titulo', 'Crear cuenta | Mi Salud al Día')

@section('contenido')
    <section class="tarjeta">
        <h1>Crear cuenta</h1>
        <p>Regístrate para organizar tus medicamentos y citas.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">Nombre</label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                autocomplete="name"
                maxlength="255"
                required
                autofocus
            >

            <label for="email">Correo electrónico</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                autocomplete="username"
                maxlength="255"
                required
            >

            <label for="password">Contraseña</label>
            <input
                id="password"
                name="password"
                type="password"
                autocomplete="new-password"
                minlength="8"
                aria-describedby="ayuda-password"
                required
            >
            <p id="ayuda-password">Usa al menos 8 caracteres.</p>

            <label for="password_confirmation">
                Confirmar contraseña
            </label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                minlength="8"
                required
            >

            <button type="submit">Crear cuenta</button>
        </form>

        <p>
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}">Inicia sesión</a>
        </p>
    </section>
@endsection