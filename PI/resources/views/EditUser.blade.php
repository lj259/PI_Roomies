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
        @foreach($registro as $datos)
        <form method="POST" action="{{route('EnvioActualizarUsuario',[$datos->id])}}">
            @csrf
            <div class="form-group text-left mt-3">
                <label for="nombre" class="font-weight-bold">Nombre:</label>
                <input type="text" class="form-control" name="nombre" placeholder="Ingresa tu nombre completo"
                    value="{{$datos->nombre}}">
                <small class="text-danger fst-italic">{{$errors->first('nombre')}}</small>
            </div>

            <div class="form-group text-left mt-3">
                <label for="ap_reg">Apellido paterno</label>
                <input type="text" class="form-control" name="ap_reg" placeholder="Ingresa tu Apellido paterno"
                value="{{$datos->apellido_paterno}}">
                <small class="text-danger fst-italic">{{$errors->first('ap_reg')}}</small>
            </div>

            <div class="form-group text-left mt-3">
                <label for="am_reg">Apellido materno</label>
                <input type="text" class="form-control" name="am_reg" placeholder="Ingresa tu Apellido materno"
                value="{{$datos->apellido_materno}}">
                <small class="text-danger fst-italic">{{$errors->first('am_reg')}}</small>
            </div>

            <div>
                <div class="form-check mt-3 form-check-inline">
                    <input class="form-check-input" type="radio" name="radio_gen" value="h">
                    <label class="form-check-label" for="radio_gen">
                        Hombre
                    </label>
                </div>
                <div class="form-check mt-3 form-check-inline">
                    <input class="form-check-input" type="radio" name="radio_gen" value="m">
                    <label class="form-check-label" for="radio_gen">
                        Mujer
                    </label>
                </div>
                <br>
                <small class="text-danger fst-italic">{{$errors->first('radio_gen')}}</small>

            </div>
            
            <div class="form-group text-left mt-3">
                <label for="telefono" class="font-weight-bold">Teléfono:</label>
                <input type="tel" class="form-control" name="telefono" placeholder="Ingresa tu teléfono"
                    value="{{$datos->telefono}}">
                <small class="text-danger fst-italic">{{$errors->first('telefono')}}</small>

            </div>
            <div class="form-group text-left mt-3">
                <label for="password" class="font-weight-bold">Contraseña:</label>
                <input type="password" class="form-control" name="password" placeholder="Ingresa una contraseña segura nueva">
                <small class="text-danger fst-italic">{{$errors->first('password')}}</small>
            </div>
            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary w-50">Guardar Cambios</button>
            </div>
            <input type="hidden" name="correo" value="{{$datos->email}}">
        </form>
        @endforeach
    </div>
</div>

@endsection