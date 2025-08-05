@extends('layouts.Plantilla1')

@section('titulo', 'Test Amigos')

@section('Contenido')

<div class="container mt-4">
    <h1>Test de Amigos</h1>
    <p>Si puedes ver esto, las rutas y el controlador funcionan correctamente.</p>
    <p>Amigos: {{ $amigos->count() }}</p>
    <p>Solicitudes: {{ $solicitudesPendientes->count() }}</p>
</div>

@endsection
