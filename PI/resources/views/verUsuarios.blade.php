@extends('layouts.Plantilla1')

@section('titulo', 'Lista de Usuarios')

@section('contenido')
    <div class="container mt-5 col-md-8">
        <h1 class="text-center text-primary mb-4">Lista de Usuarios</h1>

        @forelse($usuarios as $usuario)
            <div class="card text-justify font-monospace mt-4">
                <div class="card-header fs-5 text-primary">
                    {{ $usuario->nombre }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}
                </div>
                <div class="card-body">
                    <p><strong>Género:</strong> {{ $usuario->genero }}</p>
                    <p><strong>Email:</strong> {{ $usuario->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $usuario->telefono }}</p>
                </div>
            </div>
        @empty
            <p class="text-center text-danger">No hay usuarios registrados.</p>
        @endforelse
    </div>
@endsection
