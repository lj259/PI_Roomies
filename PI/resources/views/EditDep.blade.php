@extends('layouts.Plantilla1')
@section('titulo', 'Editar Departamento')
@section('Contenido')

@session('editado')
    <script>
        Swal.fire({
            title: "Edición exitosa",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession

@session('borrado')
    <script>
        Swal.fire({
            title: "Borrado exitoso",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession


<nav class="navbar navbar-expand-lg navbar-dark bg-danger px-4">
    <a class="navbar-brand font-weight-bold" href="#">Editar Departamento</a>
    <div class="ml-auto">
        <a class="nav-link text-white" href="#">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </a>
    </div>
</nav>

<form method="POST" action="/ValidarEditDepa">
    @csrf
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
            <div class="form-group mt-3">
                <label for="foto">Foto</label>
                <input type="file" class="form-control" name="foto">
                <small class="text-light fst-italic"><strong>{{$errors->first('foto')}}</strong></small>
            </div>
            <div class="form-group mt-3">
                <label for="precio">Precio</label>
                <input type="number" class="form-control" name="precio" >
                <small class="text-light fst-italic"><strong>{{$errors->first('precio')}}</strong></small>
            </div>
            <div class="form-group mt-3">
                <label for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" name="ubicacion" >
                <small class="text-light fst-italic"><strong>{{$errors->first('ubicacion')}}</strong></small>
            </div>
            <div class="form-group mt-3">
                <label for="habitaciones">Habitaciones</label>
                <input type="number" class="form-control" name="habitaciones" >
                <small class="text-light fst-italic"><strong>{{$errors->first('habitaciones')}}</strong></small>
            </div>
            <div class="form-group mt-3">
                <label for="banos">Baños</label>
                <input type="number" class="form-control" name="banos" >
                <small class="text-light fst-italic"><strong>{{$errors->first('banos')}}</strong></small>
            </div>
            <div class="form-group mt-3">
                <label for="servicios">Servicios</label>
                <textarea class="form-control" name="servicios"></textarea>
                <small class="text-light fst-italic"><strong>{{$errors->first('servicios')}}</strong></small>
            </div>
            <div class="form-group mt-3">
                <label for="restricciones">Restricciones</label>
                <textarea class="form-control" name="restricciones"></textarea>
                <small class="text-light fst-italic"><strong>{{$errors->first('restricciones')}}</strong></small>
            </div>
            <div class="form-group mt-3">
                <label for="cercanias">Cercanías</label>
                <textarea class="form-control" name="cercanias"></textarea>
                <small class="text-light fst-italic"><strong>{{$errors->first('cercanias')}}</strong></small>
            </div>
            <div class="form-group form-check mt-4">
                <input type="checkbox" class="form-check-input" name="borrado_logico">
                <label class="form-check-label" for="borrado_logico">Borrado lógico</label>
            </div>
            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary w-50">Guardar Cambios</button>
                <a href="#" class="btn btn-secondary w-50">Cancelar</a>
            </div>
        </div>

    </div>
</form>

@endsection