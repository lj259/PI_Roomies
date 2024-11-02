@extends('layouts.Plantilla1')
@section('titulo','Recuperacion')
@section('Contenido')

<div class="bg-danger text-white d-flex align-items-center px-3" style="height: 50px; font-size: 14px;">
    <span class="mr-2" style="font-size: 20px;">⚠️</span> HOLA CARDENAL ¿OLVIDASTE TU CONTRASEÑA? NO PIERDAS EL ACCESO RECUPERA TU CUENTA AHORA
</div>

<div class="container d-flex align-items-center justify-content-center mt-4">
    <div class="bg-light p-3 rounded mr-4" style="max-width: 200px; font-size: 12px;">
        <p class="mb-2">HOLA CARDENAL<br>¿OLVIDASTE TU CONTRASEÑA? NO PIERDAS EL ACCESO RECUPERA TU CUENTA AHORA</p>
        <img src="cardenal.png" alt="Cardenal" class="img-fluid mt-2" style="width: 120px;">
    </div>
    
    <div class="text-center" style="max-width: 300px; width: 100%;">
        <h1 class="text-primary font-weight-bold" style="font-size: 32px;">POLI ROOMS</h1>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent border-0">👤</span>
            </div>
            <input type="email" class="form-control" placeholder="Matricula@upq.edu.mx" aria-label="Matricula">
        </div>
        
        <p class="text-muted">Introduce tu última contraseña que recuerdes haber usado en esta cuenta</p>
    
        <input type="password" class="form-control mb-3" placeholder="Introduce tu última contraseña">
    </div>
</div>

@endsection
