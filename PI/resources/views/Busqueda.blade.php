@extends('layouts.Plantilla1')
@section('titulo','Busqueda')
@section('Contenido')

<main class="min-vh-100">
    <div class="container my-4">
        <div class="text-dark p-3 rounded text-center">
            <!-- Sweet Alert -->
            <script>
                Swal.fire({
                    title: 'Hey Hola Cardenal UPQ!!!',
                    text: 'Conoce Poli Roomies, una plataforma donde podrás conocer a más compañeros que, como tú, buscan un dormitorio/apartamento adecuado para su estancia en la universidad. Podrás conocer personas con gustos similares a los tuyos y, lo mejor, ¡poder compartir! BIENVENIDO!!',
                    icon: 'info',
                    confirmButtonText: '¡Entendido!'
                });
            </script>
        </div>
    </div>
    
    <div class="container text-center font-weight-bold my-4 p-4 bg-light rounded" style="font-size: 24px; color: #2c3e50; border: 2px solid #800000; border-bottom-color: #000080;">
        <h2 class="mb-3" style="font-family: 'Arial', sans-serif;">¿CON QUIÉN BUSCAS RENTAR UN DORMITORIO/APARTAMENTO?</h2>
    </div>

    <div class="container d-flex justify-content-center gap-3">
        
        <div class="text-center font-weight-bold">
            <div class="rounded-circle bg-danger mx-auto d-flex align-items-center justify-content-center" style="width: 180px; height: 180px;">
                <img src="{{ asset('images/Poli1.png') }}" alt="Poli Amigas" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
            </div>
            <p class="text-muted mt-5" style="font-size: 16px;">
                <strong>En este apartado es para buscar compartir dormitorio solo con Roomies mujeres.</strong>
            </p>
            <a href="#" class="mt-2" style="font-size: 18px;">POLI - AMIGAS</a>
        </div>
    
        <div class="text-center font-weight-bold">
            <div class="rounded-circle bg-primary mx-auto d-flex align-items-center justify-content-center" style="width: 180px; height: 180px;">
                <img src="{{ asset('images/Polo1.png') }}" alt="Polo Amigos" class="img-fluid rounded-circle" style="width: 120px; height: 120px;">
            </div>
            <p class="text-muted mt-5" style="font-size: 16px;">
                <strong>En este apartado es para buscar compartir dormitorio solo con Roomies hombres.</strong>
            </p>
            <a href="#" class="mt-2" style="font-size: 18px;">POLO - AMIGOS</a>
        </div>
        
        <div class="text-center font-weight-bold">
            <div class="rounded-circle bg-success mx-auto d-flex align-items-center justify-content-center" style="width: 180px; height: 180px;">
                <img src="{{ asset('images/Polo-Poli.png') }}" alt="Mix Cardenal" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
            </div>
            <p class="text-muted mt-5" style="font-size: 16px;">
                <strong>En este apartado es para buscar compartir dormitorio solo con Roomies de ambos géneros.</strong>
            </p>
            <a href="#" class="mt-2" style="font-size: 18px;">MIX CARDENAL</a>
        </div>
    </div>

</main>

@endsection
