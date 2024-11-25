@extends('layouts.Plantilla1')

@section('titulo', 'Gestión de Departamentos')

@section('contenido')

<div class="container mt-5 col-md-8">
    <h1 class="text-center text-primary mb-4">Departamentos Disponibles</h1>

    @forelse($departamentos as $departamento)
        <div class="card text-justify font-monospace mt-4">
            <div class="card-header fs-5 text-primary">
                {{ $departamento->ubicacion }}
            </div>
            <div class="card-body">
                <p class="fw-bold">Habitaciones: {{ $departamento->habitaciones }}</p>
                <p class="fw-bold">Baños: {{ $departamento->baños }}</p>
                <p class="fw-bold">Servicios: {{ $departamento->servicios }}</p>
                <p class="fw-lighter">Precio: ${{ $departamento->precio }} MXN</p>
            </div>
        </div>
    @empty
        <p class="text-center text-muted">No hay departamentos disponibles.</p>
    @endforelse
</div>

@endsection
