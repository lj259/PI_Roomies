@extends('layouts.Plantilla1')
@section('titulo','Registro de Actividad')
@section('Contenido')

<div class="container-fluid vh-100 p-0">
    <div class="bg-danger text-white d-flex align-items-center justify-content-between px-4 py-2">
        <h4 class="mb-0 font-weight-bold">REGISTRO ACTIVIDAD</h4>
        <div class="d-flex gap-3">
            <button class="btn btn-outline-light">
                <i class="bi bi-person-circle"></i> ADMI
            </button>
            <button class="btn btn-outline-light">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>

    <div class="d-flex">
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
        <div class="container-fluid bg-info p-4">
            <div class="input-group mb-4">
                <input type="text" class="form-control" placeholder="Buscar actividad">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Usuario</th>
                            <th>Tipo de Actividad</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>admin@ejemplo.com</td>
                            <td>Inicio de sesión</td>
                            <td>
                                Usuario admin inició sesión.
                                <button class="btn btn-link p-0">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="table-primary">
                            <td>admin@ejemplo.com</td>
                            <td>Creación de usuario</td>
                            <td>
                                Se creó el usuario Juan Pérez.
                                <button class="btn btn-link p-0">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>admin@ejemplo.com</td>
                            <td>Edición de departamento</td>
                            <td>
                                Se editaron los datos del departamento X.
                                <button class="btn btn-link p-0">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex gap-3 mt-4">
                <button class="btn btn-info">
                    <i class="bi bi-trash"></i> ELIMINAR
                </button>
                <button class="btn btn-success">
                    <i class="bi bi-save"></i> GUARDAR CAMBIO
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
