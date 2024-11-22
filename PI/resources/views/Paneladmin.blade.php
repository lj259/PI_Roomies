@extends('layouts.plantilla_admins')
@section('titulo', 'Panel Administrativo')
@section('Contenido')
<link rel="stylesheet" href="{{asset('css/panel_admin.css')}}">

<div class="d-flex">
    <div class="bg-light border-end p-3 vh-100" style="width: 150px; border-right: 2px solid #ccc;">
        <ul class="nav flex-column gap-3">
            <li class="nav-item">
                <a href="#" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-house-door-fill"></i> Inicio
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-person-fill"></i> Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-building"></i> Departamentos
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-bell-fill"></i> Avisos
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-gear-fill"></i> Configuración
                </a>
            </li>
        </ul>
    </div>

    <div class="container-fluid bg_panel">
        <h2 class="text-center text-light mb-4 mt-4">Panel Administrativo</h2>
        <div class="row mt-4">
            <div class="col-md-4 mx-auto d-flex flex-column align-items-center">
                <a href="{{route('RutaAdminUsers')}}" class="btn btn-outline-light w-100 py-3 my-3 text-center">
                    <i class="bi bi-people-fill"></i> Gestión de Usuarios
                </a>
                <a href="#" class="btn btn-outline-light w-100 py-3 my-3 text-center">
                    <i class="bi bi-building"></i> Gestión de Departamentos
                </a>
                <a href="#" class="btn btn-outline-light w-100 py-3 my-3 text-center">
                    <i class="bi bi-bell-fill"></i> Gestión de Avisos
                </a>
            </div>
        </div>
    </div>

</div>
</div>
</div>

@endsection