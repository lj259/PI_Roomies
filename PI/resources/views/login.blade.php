@extends('layouts.footer_degradado.blade')
@section('titulo','Inicio de Sesión')
@section('Contenido')

    <div class="container my-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body mb-10">
                <h3 class="card-title text-center">Inicio de Sesión</h3>
                <form action="{{route('ValidarUsrLogin')}}" method="POST">
                    <div class="form-group mt-3">
                        <label for="email">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" placeholder="Ingresa tu correo">
                    </div>
                    <div class="form-group mt-3">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" placeholder="Contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-4">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
    <p>hola</p>
 @endsection