@extends('layouts.app')

@section('titulo', 'Medicamentos | Mi Salud al Día')

@section('contenido')
    <section class="tarjeta">
        <h1>Mis medicamentos</h1>

        <p>
            <a href="{{ route('panel') }}">Volver al panel</a>
        </p>

        <form method="POST" action="{{ route('medicamentos.store') }}">
            @csrf

            <label for="nombre">Nombre del medicamento</label>
            <input
                id="nombre"
                name="nombre"
                value="{{ old('nombre') }}"
                maxlength="150"
                required
            >

            <label for="dosis">Dosis indicada</label>
            <input
                id="dosis"
                name="dosis"
                value="{{ old('dosis') }}"
                maxlength="150"
                required
            >

            <label for="hora">Hora diaria</label>
            <input
                id="hora"
                name="hora"
                type="time"
                value="{{ old('hora') }}"
                required
            >

            <label for="notas">Notas (opcional)</label>
            <textarea
                id="notas"
                name="notas"
                rows="3"
                maxlength="2000"
            >{{ old('notas') }}</textarea>

            <button type="submit">Guardar medicamento</button>
        </form>
    </section>

    <section class="tarjeta">
        <h2>Medicamentos registrados</h2>

        @forelse ($medicamentos as $medicamento)
            <article>
                <h3>{{ $medicamento->nombre }}</h3>

                <p><strong>Dosis:</strong> {{ $medicamento->dosis }}</p>
                <p>
                    <strong>Hora:</strong>
                    {{ substr($medicamento->hora, 0, 5) }}
                </p>

                @if ($medicamento->notas)
                    <p>{{ $medicamento->notas }}</p>
                @endif

                <form
    method="POST"
    action="{{ route('tomas.store', $medicamento->id) }}"
>
    @csrf

    <button type="submit">Marcar como tomado hoy</button>
</form>

                <form
                    method="POST"
                    action="{{ route('medicamentos.destroy', $medicamento->id) }}"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit">
                        Eliminar {{ $medicamento->nombre }}
                    </button>
                </form>
                <hr>
            </article>
        @empty
            <p>Aún no tienes medicamentos registrados.</p>
        @endforelse
    </section>
@endsection