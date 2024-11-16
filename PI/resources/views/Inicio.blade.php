@extends('layouts.Plantilla1')
@section('titulo','Inicio')
@section('Contenido')

<div class="position-relative vh-100 text-center text-white">

    <img src="{{asset('images/Fondo_uni.jpg')}}" alt="Fondo" class="position-absolute w-100 h-100" style="object-fit: cover; top: 0; left: 0; z-index: -1;">


    <div class="d-flex flex-column align-items-center justify-content-center h-100">

        <h1 class="display-1 font-weight-bold text-primary">POLI ROOMS</h1>


        <div class="d-flex gap-3 mt-3">
            <a class="btn btn-info btn-lg font-weight-bold">INICIA</a>
            <a href="{{route('RutaRegsitroUsuario')}}" class="btn btn-info btn-lg font-weight-bold">REGÍSTRATE</a>
        </div>
    </div>

    <img src="{{asset('images/Polo1.png')}}" alt="Polo" class="position-absolute" style="bottom: 20px; left: 10px; width: 250px;">
    <img src="{{asset('images/Poli1.png')}}" alt="Poli" class="position-absolute" style="bottom: 20px; right: 10px; width: 300px;">

    <a href="#" class="position-absolute text-dark font-weight-bold" style="bottom: 10px; right: 20px;">¿Quiénes somos?</a>
</div>

@endsection
