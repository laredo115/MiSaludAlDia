@extends('layouts.app')

@section('titulo', 'Términos de uso | Mi Salud al Día')

@section('contenido')
    <section class="tarjeta">
        <h1>Términos de uso</h1>
        <p>Última actualización: 20 de octubre de 2026.</p>

        <h2>Propósito de la aplicación</h2>
        <p>
            Mi Salud al Día es un prototipo académico para organizar
            medicamentos, registrar tomas y guardar citas personales.
            Esta versión se utiliza en un entorno local de demostración.
        </p>

        <h2>Uso permitido</h2>
        <p>
            Puedes crear una cuenta y administrar tus propios registros.
            Durante las pruebas debes utilizar información ficticia.
            No debes acceder a cuentas ajenas, alterar registros de
            otros usuarios ni intentar dañar el sistema.
        </p>

        <h2>Responsabilidad del usuario</h2>
        <p>
            Debes mantener tu contraseña privada, cerrar sesión al
            terminar y revisar la información que introduces.
            Marcar una toma únicamente registra tu indicación de que
            tomaste el medicamento; la aplicación no verifica su consumo.
        </p>

        <h2>Alcance de salud</h2>
        <p>
            La aplicación no proporciona diagnósticos, recetas ni
            recomendaciones de tratamiento. Los medicamentos, dosis
            y horarios deben proceder de las indicaciones de un
            profesional de salud.
        </p>

        <h2>Limitaciones del prototipo</h2>
        <p>
            Esta versión no garantiza disponibilidad continua ni
            recordatorios automáticos. Puede presentar errores o
            pérdida de información. No debe utilizarse como único
            medio para controlar tratamientos ni para atender emergencias.
        </p>

        <h2>Responsabilidad del desarrollador</h2>
        <p>
            El desarrollador mantiene este prototipo con fines
            educativos. Su alcance se limita a las funciones
            demostradas; no ofrece supervisión médica ni garantiza
            resultados de salud.
        </p>

        <h2>Privacidad</h2>
        <p>
            Consulta el
            <a href="{{ route('privacidad') }}">Aviso de privacidad</a>
            para conocer los datos registrados, su finalidad y las
            medidas de protección del prototipo.
        </p>

        <p><a href="{{ url('/') }}">Volver al inicio</a></p>
    </section>
@endsection