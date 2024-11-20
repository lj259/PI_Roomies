@extends('layouts.Plantilla1')
@section('titulo','Busqueda')
@section('Contenido')


<div class="container my-4">
    <div class="text-dark p-3 rounded text-center" >
        ¡¡¡Hey Hola Cardenal UPQ!!! Conoce Poli Roomies, una plataforma donde podrás conocer a más compañeros que, como tú, buscan un dormitorio/apartamento adecuado para su estancia en la universidad. Podrás conocer personas con gustos similares a los tuyos y, lo mejor, ¡poder compartir! BIENVENIDO!!
    </div>
</div>


<div class="container text-center font-weight-bold my-4" style="font-size: 24px;">
    ¿CON QUIÉN BUSCAS RENTAR UN DORMITORIO/APARTAMENTO?
</div>


<div class="container d-flex justify-content-center gap-3">
    
    <div class="text-center font-weight-bold">
        <div class="rounded-circle bg-danger mx-auto" style="width: 150px; height: 150px;">
            <img src="{{asset('images/Poli1.png')}}" alt="Poli Amigas" class="img-fluid rounded-circle p-2">
        </div>
        <p class="text-muted" style="font-size: 12px;">
            En este apartado es para buscar compartir dormitorio solo con Roomies mujeres.
        </p>
        <a class="mt-2" style="font-size: 18px;">POLI - AMIGAS</a>
    </div>

    <div class="text-center font-weight-bold">
        <div class="rounded-circle bg-primary mx-auto" style="width: 150px; height: 150px;">
            <img src="{{asset('images/Polo1.png')}}" alt="Polo Amigos" class="img-fluid rounded-circle p-2">
        </div>
        <p class="text-muted" style="font-size: 12px;">
            En este apartado es para buscar compartir dormitorio solo con Roomies hombres.
        </p>
        <a class="mt-2" style="font-size: 18px;">POLO - AMIGOS</a>
    </div>
    
    <div class="text-center font-weight-bold">
        <div class="rounded-circle bg-success mx-auto" style="width: 150px; height: 150px;">
            <img src="{{asset('images/Polo-Poli.png')}}" alt="Mix Cardenal" class="img-fluid rounded-circle p-2">
        </div>
        <p class="text-muted" style="font-size: 12px;">
            En este apartado es para buscar compartir dormitorio solo con Roomies de ambos géneros.
        </p>
        <a class="mt-2" style="font-size: 18px;">MIX CARDENAL</a>
    </div>
</div>

@endsection
