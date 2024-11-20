@extends('layouts.plantilla_admins')
@section('titulo','Gestión de Usuarios')
@section('Contenido')

<div class="container-fluid vh-100 p-0">

    <div class="d-flex">
        <!-- Barra lateral de navegación -->
        <div class="bg-light border-end p-3 vh-100" style="width: 150px; border-right: 2px solid #ccc;">
            <ul class="nav flex-column gap-3">
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark d-flex align-items-center">
                        <i class="bi bi-bell-fill"></i> NOTIFICACIÓN
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill"></i> REPORTES
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark d-flex align-items-center">
                        <i class="bi bi-gear-fill"></i> AJUSTES
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark d-flex align-items-center">
                        <i class="bi bi-envelope-fill"></i> EMAIL
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark d-flex align-items-center">
                        <i class="bi bi-lock-fill"></i> PERMISOS
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="container-fluid bg-info p-4">
            <h3 class="text-center mb-4">Gestión de Usuarios</h3>
            <div class="row mt-4">
                <div class="col-md-6">
                    <a href="#" class="btn btn-success btn-block w-100 py-3">
                        <i class="bi bi-person-plus-fill"></i> Registrar Usuario
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="btn btn-secondary btn-block w-100 py-3">
                        <i class="bi bi-arrow-left"></i> Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
