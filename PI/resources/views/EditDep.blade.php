@extends('layouts.Plantilla1')
@section('titulo','Editar Departamento')
@section('Contenido')
<nav class="navbar navbar-expand-lg navbar-dark bg-danger px-4">
    <a class="navbar-brand font-weight-bold" href="#">Editar Departamento</a>
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
        <h3 class="text-center mb-4">Editar Departamento</h3>
        <form>
            <div class="form-group mt-3">
                <label for="foto">Foto</label>
                <input type="file" class="form-control" id="foto">
            </div>
            <div class="form-group mt-3">
                <label for="precio">Precio</label>
                <input type="number" class="form-control" id="precio" value="Precio actual">
            </div>
            <div class="form-group mt-3">
                <label for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" value="Ubicación actual">
            </div>
            <div class="form-group mt-3">
                <label for="habitaciones">Habitaciones</label>
                <input type="number" class="form-control" id="habitaciones" value="Número de habitaciones actual">
            </div>
            <div class="form-group mt-3">
                <label for="banos">Baños</label>
                <input type="number" class="form-control" id="banos" value="Número de baños actual">
            </div>
            <div class="form-group mt-3">
                <label for="servicios">Servicios</label>
                <textarea class="form-control" id="servicios">Servicios actuales</textarea>
            </div>
            <div class="form-group mt-3">
                <label for="restricciones">Restricciones</label>
                <textarea class="form-control" id="restricciones">Restricciones actuales</textarea>
            </div>
            <div class="form-group mt-3">
                <label for="cercanias">Cercanías</label>
                <textarea class="form-control" id="cercanias">Cercanías actuales</textarea>
            </div>
            <div class="form-group form-check mt-4">
                <input type="checkbox" class="form-check-input" id="borrado_logico">
                <label class="form-check-label" for="borrado_logico">Borrado lógico</label>
            </div>
            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary w-50">Guardar Cambios</button>
                <a href="#" class="btn btn-secondary w-50">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection
