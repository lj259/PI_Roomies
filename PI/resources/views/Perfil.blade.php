@extends('layouts.Plantilla1')
@section('titulo', 'Perfil')
@section('Contenido')

<!--
<div class="bg-danger text-white d-flex align-items-center px-3" style="height: 60px; font-size: 18px;">
    <div>Perfil de Usuario</div>
    <div class="ml-auto text-white" style="cursor: pointer; font-size: 16px;">✏️ Editar perfil usuario</div>
</div>-->
<main class="min-vh-100">
    <div class="container mt-4">
        <div class="row align-items-start">

            
            <div class="col-md-3 text-center">
                <img src="..." alt="" class="img-fluid rounded" style="width: 120px;">
            </div>
            

            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">NOMBRE: {{ $usuario->nombre}} {{$usuario->apellido_paterno}} {{$usuario->apellido_materno }}</h5>
                        <p class="card-text">
                            <strong>Género:</strong> {{ $usuario->genero?? 'Información no disponible' }}<br>
                            <strong>Teléfono:</strong> {{ $usuario->telefono?? 'Información no disponible' }}<br>
                            <strong>Correo Electrónico:</strong> {{ $usuario->email}}<br>
                            <strong>Fecha de registro:</strong> {{ $usuario->created_at?? 'Información no disponible' }}
                        </p>
                        <button class="btn btn-primary btn-sm">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br><br>
    <div class="d-flex justify-content-around my-4">
        <a href="#" class="btn btn-info btn-lg">PÁGINA PRINCIPAL</a>
        <a href="{{route('RutaBusqueda')}}" class="btn btn-info btn-lg">BUSCA UN ROOMIES</a>
    </div>

</main>

@endsection