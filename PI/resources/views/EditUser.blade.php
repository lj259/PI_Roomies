@extends('layouts.Plantilla1')
@section('titulo', 'Editar Usuario')
@section('Contenido')

@session('exito')
    <script>
        Swal.fire({
            title: "Edición de usuario exitosa ",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession
<nav class="navbar navbar-expand-lg navbar-dark bg-danger px-4">
    <a class="navbar-brand font-weight-bold" href="#">Editar Usuario</a>
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
        <h3 class="text-center mb-4">Editar Usuario</h3>
        <form method="POST" action="/ValidarEditUsr">
            @csrf
            <div class="form-group">
                <label for="name">Nombre Completo</label>
                <input type="text" class="form-control" name="nombreEdit" value="Nombre actual">
                <small>{{$errors->first('nombreEdit')}}</small>
            </div>
            <div class="form-group mt-3">
                <label for="status">Estado</label>
                <select class="form-control" name="estatus">
                    <option>Activo</option>
                    <option>Bloqueado</option>
                </select>
            </div>
            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary w-50">Guardar Cambios</button>
                <a href="#" class="btn btn-secondary w-50">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection