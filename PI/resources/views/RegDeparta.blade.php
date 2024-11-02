@extends('layouts.Plantilla1')
@section('titulo','Registrar Departamento')
@section('Contenido')

<nav class="navbar navbar-expand-lg navbar-dark bg-danger px-4">
    <a class="navbar-brand font-weight-bold" href="#">Registrar Departamento</a>
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
        <h3 class="text-center mb-4">Registrar Departamento</h3>
        <form>
            <div class="form-group mt-3">
                <label for="foto">Foto</label>
                <input type="file" class="form-control" id="foto">
            </div>
            <div class="form-group mt-3">
                <label for="precio">Precio</label>
                <input type="number" class="form-control" id="precio" placeholder="Precio mensual">
            </div>
            <div class="form-group mt-3">
                <label for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" placeholder="Ubicación del departamento">
            </div>
            <div class="form-group mt-3">
                <label for="habitaciones">Habitaciones</label>
                <input type="number" class="form-control" id="habitaciones" placeholder="Número de habitaciones">
            </div>
            <div class="form-group mt-3">
                <label for="banos">Baños</label>
                <input type="number" class="form-control" id="banos" placeholder="Número de baños">
            </div>
            <div class="form-group mt-3">
                <label for="servicios">Servicios</label>
                <textarea class="form-control" id="servicios" placeholder="Servicios incluidos (e.g., agua, electricidad, internet)"></textarea>
            </div>
            <div class="form-group mt-3">
                <label for="restricciones">Restricciones</label>
                <textarea class="form-control" id="restricciones" placeholder="Restricciones del dueño"></textarea>
            </div>
            <div class="form-group mt-3">
                <label for="cercanias">Cercanías</label>
                <textarea class="form-control" id="cercanias" placeholder="Tiendas, servicios cercanos, paradas de camión"></textarea>
            </div>
            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary w-50">Registrar Departamento</button>
                <a href="#" class="btn btn-secondary w-50">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection
