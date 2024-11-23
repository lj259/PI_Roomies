@extends('layouts.Plantilla1')
@section('titulo', 'Perfil')
@section('Contenido')

<main class="min-vh-100 bg-light">
    <div class="container py-4">
        <!-- Título del Perfil -->
        <div class="bg-danger text-white d-flex align-items-center px-3 py-2 rounded" style="font-size: 18px;">
            <div><strong>Perfil de Usuario</strong></div>
            <div class="ml-auto text-white" style="cursor: pointer; font-size: 16px;">
                ✏️ <a href="#" class="text-white text-decoration-none">Editar perfil</a>
            </div>
        </div>

        <!-- Información del Usuario -->
        <div class="row align-items-start mt-4">
            <!-- Foto de Perfil -->
            <div class="col-md-3 text-center">
                <img src="..." alt="Foto de Perfil" class="img-fluid rounded shadow-sm" style="width: 140px; height: 140px; object-fit: cover;">
                <p class="mt-3 font-weight-bold text-dark">NOMBRE: POLI UPQ</p>
            </div>

            <!-- Detalles del Usuario -->
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><strong>Información Personal</strong></h5>
                        <p class="card-text">
                            <strong>Nombre:</strong> Poli UPQ<br>
                            <strong>Género:</strong> Información del género del usuario.<br>
                            <strong>Edad:</strong> Mostrar la edad.<br>
                            <strong>Teléfono:</strong> Mostrar el número de contacto.<br>
                            <strong>Correo Electrónico:</strong> Mostrar el correo vinculado.<br>
                            <strong>Gustos y Preferencias:</strong> Breve descripción de los intereses del usuario.
                        </p>
                        <button class="btn btn-success btn-sm mt-3">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enlaces -->
        <div class="d-flex justify-content-around my-4">
            <a href="#" class="btn btn-info btn-lg shadow-sm">PÁGINA PRINCIPAL</a>
            <a href="{{ route('RutaBusqueda') }}" class="btn btn-info btn-lg shadow-sm">BUSCA UN ROOMIE</a>
        </div>
    </div>
</main>

@endsection
