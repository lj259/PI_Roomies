@extends('layouts.Plantilla1')
@section('titulo','Panel Administrativo')
@section('Contenido')

<nav class="navbar navbar-expand-lg navbar-dark bg-danger px-4">
    <a class="navbar-brand font-weight-bold" href="#">Panel Administrativo</a>
    <div class="ml-auto">
        <a class="nav-link text-white" href="#">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </a>
    </div>
</nav>

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
    
    <div class="container-fluid bg-info p-4">
        <h2 class="text-center mb-4">Panel Administrativo</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <a href="#" class="btn btn-success btn-block w-100 py-3 my-3">
                    <i class="bi bi-people-fill"></i> Gestión de Usuarios
                </a>
            </div>
            <div class="col-md-4">
                <a href="#" class="btn btn-success btn-block w-100 py-3 my-3">
                    <i class="bi bi-building"></i> Gestión de Departamentos
                </a>
            </div>
            <div class="col-md-4">
                <a href="#" class="btn btn-success btn-block w-100 py-3 my-3">
                    <i class="bi bi-bell-fill"></i> Gestión de Avisos
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
