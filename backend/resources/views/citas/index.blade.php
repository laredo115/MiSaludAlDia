@extends('layouts.app')

@section('titulo', 'Citas | Mi Salud al Día')

@section('contenido')
    <section class="tarjeta">
        <h1>Mis citas</h1>

        <p>
            <a href="{{ route('panel') }}">Volver al panel</a>
        </p>

        <form method="POST" action="{{ route('citas.store') }}">
            @csrf

            <label for="especialidad">Especialidad o motivo</label>
            <input
                id="especialidad"
                name="especialidad"
                value="{{ old('especialidad') }}"
                maxlength="150"
                required
            >

            <label for="fecha_hora">Fecha y hora</label>
            <input
                id="fecha_hora"
                name="fecha_hora"
                type="datetime-local"
                value="{{ old('fecha_hora') }}"
                required
            >

            <label for="lugar">Lugar (opcional)</label>
            <input
                id="lugar"
                name="lugar"
                value="{{ old('lugar') }}"
                maxlength="255"
            >

            <label for="preguntas">Preguntas para la consulta (opcional)</label>
            <textarea
                id="preguntas"
                name="preguntas"
                rows="3"
                maxlength="2000"
            >{{ old('preguntas') }}</textarea>

            <button type="submit">Guardar cita</button>
        </form>
    </section>

    <section class="tarjeta">
        <h2>Citas registradas</h2>

        @forelse ($citas as $cita)
            <article>
                <h3>{{ $cita->especialidad }}</h3>

                <p>
                    <strong>Fecha y hora:</strong>
                    {{ $cita->fecha_hora->format('d/m/Y H:i') }}
                </p>

                @if ($cita->lugar)
                    <p><strong>Lugar:</strong> {{ $cita->lugar }}</p>
                @endif

                @if ($cita->preguntas)
                    <p><strong>Preguntas:</strong> {{ $cita->preguntas }}</p>
                @endif

                <form
                    method="POST"
                    action="{{ route('citas.destroy', $cita->id) }}"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit">Eliminar cita</button>
                </form>
                <hr>
            </article>
        @empty
            <p>Aún no tienes citas registradas.</p>
        @endforelse
    </section>
@endsection