@extends('layouts.plantilla_simple')

@section('titulo', 'Política de Privacidad')

@section('navbar-content')
<ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('RutaRegistroUsuario') }}">Registrarse</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('politica') }}">Política de Privacidad</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('about') }}">Quiénes Somos</a>
    </li>
</ul>
@endsection

@section('Contenido')
<div class="card shadow-sm p-4 bg-white">
    <h1 class="mb-4 text-primary">Política de Privacidad</h1>
    <p>En <strong>PI Roomies</strong>, valoramos tu privacidad. Esta política explica cómo recopilamos, usamos y protegemos tu información personal.</p>

    <h5>1. Información que recopilamos</h5>
    <ul>
        <li class="mb-2">Datos personales como nombre, correo electrónico, y teléfono.</li>
        <li class="mb-2">Información de navegación y uso del sitio.</li>
    </ul>

    <h5>2. Finalidad</h5>
    <p>Usamos tu información para mejorar tu experiencia, brindarte soporte, y enviarte notificaciones relevantes.</p>

    <h5>3. Seguridad</h5>
    <p>Aplicamos medidas técnicas y administrativas para proteger tus datos personales.</p>

    <h5>4. Derechos del Usuario</h5>
    <p>Puedes solicitar acceso, corrección o eliminación de tus datos enviando un correo a <a href="mailto:soporte@piroomies.com">soporte@piroomies.com</a>.</p>
</div>
@endsection
