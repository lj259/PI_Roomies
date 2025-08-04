@extends('layouts.plantilla_simple')
@section('titulo', 'Quiénes Somos')

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
    <h1 class="mb-4 text-primary">Quiénes Somos</h1>
    <p><strong>PI Roomies</strong> es una plataforma que conecta a personas que buscan compartir departamento, promoviendo comunidad, confianza y seguridad.</p>

    <h5>Nuestra Misión</h5>
    <p>Facilitar el proceso de búsqueda de compañeros de cuarto mediante tecnología y verificación.</p>

    <h5>Nuestro Equipo</h5>
    <p>Somos un grupo apasionado de desarrolladores, diseñadores y líderes en innovación con enfoque social.</p>

    <h5>Contacto</h5>
    <p>¿Tienes preguntas? Escríbenos a <a href="mailto:soporte@piroomies.com">soporte@piroomies.com</a></p>
</div>
@endsection
