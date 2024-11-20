@extends('layouts.plantilla_admins')
@section('titulo','Gestión de Roles y Permisos')
@section('Contenido')

<div class="container-fluid vh-100 bg-light p-0">
    <!--
    <div class="bg-danger text-white d-flex align-items-center justify-content-between px-4 py-2">
        <h4 class="mb-0 font-weight-bold">Gestión de Roles y Permiso</h4>
        <div class="d-flex gap-3">
            <button class="btn btn-outline-light d-flex align-items-center">
                <i class="bi bi-person-plus-fill"></i> AGREGAR PERFIL
            </button>
            <button class="btn btn-outline-light">
                <i class="bi bi-person-circle"></i> ADMI
            </button>
            <button class="btn btn-outline-light">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div> -->

    <div class="d-flex">
        <div class="bg-light p-3" style="width: 150px;">
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
                        <i class="bi bi-envelope-fill"></i> CORREO
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark d-flex align-items-center">
                        <i class="bi bi-gear-fill"></i> AJUSTES
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="container-fluid bg-info p-4">
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                            <h5 class="ms-2 mb-0">NOMBRE DE USUARIO: USER33</h5>
                        </div>
                        <button class="btn btn-light btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                    <p><strong>EDAD:</strong> 19</p>
                    <p><strong>ZONA:</strong> EL MARQUÉS QRO</p>
                    <p><strong>CORREO:</strong> 1678728@upq.edu.mx</p>
                    <p><strong>HÁBITOS:</strong> PASATIEMPO, ETC.</p>
                    <p><strong>ROL A ASIGNAR:</strong></p>

                    <div class="d-flex gap-3 mt-4">
                        <button class="btn btn-info w-50">ELIMINAR</button>
                        <button class="btn btn-success w-50">GUARDAR CAMBIO</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
