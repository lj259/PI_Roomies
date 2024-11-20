@extends('layouts.plantilla_admins')
@section('titulo', 'Registrar Departamento')
@section('Contenido')

@session('registrado')
    <script>
        Swal.fire({
            title: "Registro exitoso",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession

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
        <form method="POST" action="/ValidarDepa">
            @csrf
            <div class="form-group mt-3">
                <label for="foto">Foto</label>
                <input type="file" class="form-control" value="{{old('foto')}}" name="foto">
                <small class="text-danger fst-italic">{{$errors->first('foto')}}</small>
            </div>
            <div class="form-group mt-3">
                <label for="precio">Precio</label>
                <input type="number" class="form-control" value="{{old('precio')}}" name="precio"
                    placeholder="Precio mensual">
                <small class="text-danger fst-italic">{{$errors->first('precio')}}</small>
            </div>
            <div class="form-group mt-3">
                <label for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" value="{{old('ubicacion')}}" name="ubicacion"
                    placeholder="Ubicación del departamento">
                <small class="text-danger fst-italic">{{$errors->first('ubicacion')}}</small>
            </div>
            <div class="form-group mt-3">
                <label for="habitaciones">Habitaciones</label>
                <input type="number" class="form-control" value="{{old('habitaciones')}}" name="habitaciones"
                    placeholder="Número de habitaciones">
                <small class="text-danger fst-italic">{{$errors->first('habitaciones')}}</small>
            </div>
            <div class="form-group mt-3">
                <label for="banos">Baños</label>
                <input type="number" class="form-control" value="{{old('banos')}}" name="banos"
                    placeholder="Número de baños">
                <small class="text-danger fst-italic">{{$errors->first('banos')}}</small>
            </div>
            <div class="form-group mt-3">
                <label for="servicios">Servicios</label>
                <textarea class="form-control" value="{{old('servicios')}}" name="servicios"
                    placeholder="Servicios incluidos (e.g., agua, electricidad, internet)"></textarea>
                <small class="text-danger fst-italic">{{$errors->first('servicios')}}</small>
            </div>
            <div class="form-group mt-3">
                <label for="restricciones">Restricciones</label>
                <textarea class="form-control" value="{{old('restricciones')}}" name="restricciones"
                    placeholder="Restricciones del dueño"></textarea>
                <small class="text-danger fst-italic">{{$errors->first('restricciones')}}</small>
            </div>
            <div class="form-group mt-3">
                <label for="cercanias">Cercanías</label>
                <textarea class="form-control" value="{{old('cercanias')}}" name="cercanias"
                    placeholder="Tiendas, servicios cercanos, paradas de camión"></textarea>
                <small class="text-danger fst-italic">{{$errors->first('cercanias')}}</small>
            </div>
            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary w-50">Registrar Departamento</button>
                <a href="#" class="btn btn-secondary w-50">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection