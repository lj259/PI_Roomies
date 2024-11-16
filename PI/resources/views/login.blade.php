@extends('layouts.Plantilla1')
@section('titulo','Inicio de Sesión')
@section('Contenido')

    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h3 class="card-title text-center">Inicio de Sesión</h3>
                <form action="{{route('ValidarUsrLogin')}}">
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" placeholder="Ingresa tu correo">
                    </div>
                    <div class="form-group mt-3">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" placeholder="Contraseña">
                    </div>
                    <button class="btn btn-primary btn-block mt-4">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
 @endsection