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
    <div class="bg-light border-end p-3 vh-100" style="width: 170px; border-right: 2px solid #ccc;">
        <ul class="nav flex-column gap-3">
            <li class="nav-item">
                <a href="{{route('RutaVerAvisos')}}" class="nav-link text-dark d-flex align-items-center">Consultar avisos</a>
            </li>
            <li class="nav-item">
                <a href="{{route('RutaRegistroAvisos')}}" class="nav-link text-dark d-flex align-items-center">Crear un nuevo aviso</a>
            </li>
        </ul>
    </div>

    <!--Campos de crear aviso-->
    <div class="container-fluid p-4 justify-content-around border">
        <h3 class="text-center mb-4">Crear un aviso</h3>
        <div class="col-4 mx-auto">
            <div class=""></div>
            <form method="POST" action="{{{route('ValidarAviso')}}}" enctype="multipart/form-data">
                @csrf

                <div class="form-group mt-3">
                    <label for="titulo">Título</label>
                    <input type="text" class="form-control" value="{{old('titulo')}}" name="titulo"
                        placeholder="Titulo del aviso">
                    <small class="text-danger fst-italic">{{$errors->first('titulo')}}</small>
                </div>
                <div class="form-group mt-3">
                    <label for="descripcion">Descripción</label>
                    <input type="text" class="form-control" value="{{old('descripcion')}}" name="descripcion"
                        placeholder="Descripción del aviso">
                    <small class="text-danger fst-italic">{{$errors->first('descripcion')}}</small>
                </div>
                <div class="form-group mt-3">
                    <label for="estado">Estado</label>
                    <input type="text" class="form-control" value="{{old('estado')}}" name="estado"
                        placeholder="Activo o inactivo">
                    <small class="text-danger fst-italic">{{$errors->first('estado')}}</small>
                </div>
                <div class="form-group mt-3">
                    <label for="banos">Categoría</label>
                    <input type="text" class="form-control" value="{{old('categoria')}}" name="categoria"
                        placeholder="xd">
                    <small class="text-danger fst-italic">{{$errors->first('categoria')}}</small>
                </div>
                <div class="d-flex justify-content-center gap-3 mt-4"> 
                    <button type="submit" class="btn btn-outline-primary">Registrar</button>
                    <a href="#" class="btn btn-outline-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection