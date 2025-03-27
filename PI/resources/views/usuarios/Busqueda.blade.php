@extends('layouts.Plantilla1')
@section('titulo', 'Búsqueda')
@section('Contenido')

<main class="min-vh-100 bg-light mb-5">
    <!-- Alerta Inicial 
    <div class="container py-4">
        <div class="text-dark text-center">
            <script>
                Swal.fire({
                    title: '¡Hola, Cardenal UPQ!',
                    text: 'Conoce Poli Roomies: una plataforma donde podrás encontrar compañeros que, como tú, buscan un lugar perfecto para vivir mientras estudian en la universidad. ¡Descubre personas con tus mismos intereses y crea recuerdos inolvidables!',
                    icon: 'info',
                    confirmButtonText: '¡Entendido!'
                });
            </script>
        </div>
    </div>
    -->

    <!-- Sección de Título -->
    <div class="container text-center my-4 p-4 rounded" style="background: linear-gradient(45deg, #800000, #000080); color: white; border: 2px solid #000;">
        <h2 class="mb-3" style="font-family: 'Arial Black', sans-serif; letter-spacing: 2px;">
            ¿CON QUIÉN BUSCAS RENTAR UN DORMITORIO/APARTAMENTO?
        </h2>
    </div>

        <!-- Opciones de Búsqueda -->
        <div class="container">
            <!-- Primera fila (Hombres y Mujeres) -->
            <div class="row justify-content-center mb-5">
                <!-- Mujeres -->
                 @if (Auth::user()->genero === 'femenino')
                 <div class="col-md-5 text-center font-weight-bold mx-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-lg"
                        style="width: 200px; height: 200px; background: radial-gradient(circle, #FF6F61, #C0392B);">
                        <img src="{{ asset('images/Poli1.png') }}" alt="Poli Amigas" class="img-fluid rounded-circle"
                            style="width: 140px; height: 140px;">
                    </div>
                    <p class="text-dark mt-4" style="font-size: 16px;">
                        <strong>Encuentra compañeras de cuarto y comparte momentos únicos.</strong>
                    </p>
                    <a href="{{route('RutaResultados', ['publico' => 'mujeres'])}}" class="btn btn-outline-danger mt-2"
                        style="font-size: 18px;">Solo mujeres</a>
                </div>
                 @endif
                 <!-- Hombres -->
                 @if (Auth::user()->genero === 'masculino')
                 <div class="col-md-5 text-center font-weight-bold mx-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-lg"
                        style="width: 200px; height: 200px; background: radial-gradient(circle, #3498DB, #2E86C1);">
                        <img src="{{ asset('images/Polo1.png') }}" alt="Polo Amigos" class="img-fluid rounded-circle"
                            style="width: 130px; height: 130px;">
                    </div>
                    <p class="text-dark mt-4" style="font-size: 16px;">
                        <strong>Busca compañeros con quienes compartir tu espacio.</strong>
                    </p>
                    <a href="{{ route('RutaResultados', ['publico' => 'hombres']) }}" class="btn btn-outline-primary mt-2"
                        style="font-size: 18px;">
                        Solo hombres
                    </a>
                </div>
                 @endif           
            </div>

            <!-- Segunda fila (Mixto) -->
            <div class="row justify-content-center">
                <div class="col-md-5 text-center font-weight-bold">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-lg"
                        style="width: 200px; height: 200px; background: radial-gradient(circle, #58D68D, #28B463);">
                        <img src="{{ asset('images/Polo-Poli.png') }}" alt="Mix Cardenal" class="img-fluid rounded-circle"
                            style="width: 140px; height: 140px;">
                    </div>
                    <p class="text-dark mt-4" style="font-size: 16px;">
                        <strong>Compañeros mixtos</strong>
                    </p>
                    <a href="{{route('RutaResultados', ['publico' => 'mixto'])}}" class="btn btn-outline-success mt-2"
                        style="font-size: 18px;">Mixtos</a>
                </div>
            </div>
        </div>
    </main>

@endsection

