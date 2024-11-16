@extends('layouts.Plantilla1')
@section('titulo','Perfil')
@section('Contenido')


<div class="bg-danger text-white d-flex align-items-center px-3" style="height: 60px; font-size: 18px;">
    <div>Perfil de Usuario</div>
    <div class="ml-auto text-white" style="cursor: pointer; font-size: 16px;">✏️ Editar perfil usuario</div>
</div>


<div class="container mt-4">
    <div class="row align-items-start">
        
        <div class="col-md-3 text-center">
            <img src="..." alt="Foto de Perfil" class="img-fluid rounded" style="width: 120px;">
            <p class="mt-2 font-weight-bold">NOMBRE: POLI UPQ</p>
        </div>

        
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">NOMBRE: POLI UPQ</h5>
                    <p class="card-text">
                        <strong>Género:</strong> Información del género del usuario.<br>
                        <strong>Edad:</strong> Mostrar la edad.<br>
                        <strong>Teléfono:</strong> Mostrar el número de contacto.<br>
                        <strong>Correo Electrónico:</strong> Mostrar el correo vinculado.<br>
                        <strong>Gustos y Preferencias:</strong> Sección que muestre los gustos y preferencias actuales del usuario.
                    </p>
                    <button class="btn btn-primary btn-sm">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-around mt-4">
    <a href="#" class="btn btn-info btn-lg">PÁGINA PRINCIPAL</a>
    <a href="{{route('RutaBusqueda')}}" class="btn btn-info btn-lg">BUSCA UN ROOMIES</a>
</div>

@endsection
