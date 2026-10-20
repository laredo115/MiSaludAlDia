@extends('layouts.app')

@section('titulo', 'Mi panel | Mi Salud al Día')

@section('contenido')
    <section class="tarjeta">
        <h1>Hola, {{ auth()->user()->name }}</h1>

        <p>Tu sesión está activa en Mi Salud al Día.</p>

        <nav aria-label="Secciones de salud">
            <p>
                <a href="{{ route('medicamentos.index') }}">
                    Mis medicamentos y tomas
                </a>
            </p>

            <p>
                <a href="{{ route('citas.index') }}">
                    Mis citas
                </a>
            </p>
        </nav>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    </section>
@endsection