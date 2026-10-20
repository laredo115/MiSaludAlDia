@extends('layouts.app')

@section('titulo', 'Aviso de privacidad | Mi Salud al Día')

@section('contenido')
    <section class="tarjeta">
        <h1>Aviso de privacidad</h1>
        <p>Última actualización: 20 de octubre de 2026.</p>

        <h2>Responsable y alcance</h2>
        <p>
            Mi Salud al Día es un prototipo académico desarrollado por
            Jorge Iván Ramírez Laredo. Esta versión funciona en un
            entorno local para demostrar sus características.
            Utiliza datos ficticios durante las pruebas.
        </p>

        <h2>Datos que se registran</h2>
        <p>
            La aplicación almacena nombre, correo electrónico y una
            contraseña protegida mediante hash. También guarda los
            medicamentos, dosis, horarios, notas, tomas y citas que
            introduzcas. Esta información puede revelar datos de salud.
        </p>

        <h2>Finalidad</h2>
        <p>
            Los datos permiten crear tu cuenta, iniciar sesión y
            organizar tus registros personales de medicamentos,
            tomas y citas.
        </p>

        <h2>Almacenamiento y protección</h2>
        <p>
            Los registros se almacenan en la base de datos MySQL del
            equipo donde se ejecuta el prototipo. La aplicación utiliza
            HTTPS, controles de acceso por usuario y protección contra
            solicitudes falsificadas. Estas medidas no eliminan todos
            los riesgos de seguridad.
        </p>

        <h2>Sesión y registros técnicos</h2>
        <p>
            Se utilizan cookies para mantener la sesión y proteger los
            formularios. El servidor puede guardar registros técnicos
            de acceso y errores para diagnosticar problemas.
        </p>

        <h2>Acceso y eliminación</h2>
        <p>
            Puedes consultar y eliminar tus medicamentos y citas desde
            tu cuenta. Al eliminar un medicamento también se eliminan
            sus tomas asociadas. La eliminación completa de una cuenta
            debe solicitarse al responsable durante la demostración,
            pues este prototipo aún no incluye esa función.
        </p>

        <h2>Transferencias y conservación</h2>
        <p>
            Esta versión no incluye funciones para compartir los
            registros con terceros. Los datos de prueba permanecen
            en el equipo hasta que se eliminen. El administrador del
            equipo y de la base de datos puede acceder a ellos.
        </p>

        <p><a href="{{ url('/') }}">Volver al inicio</a></p>
    </section>
@endsection