@extends('layouts.Plantilla1')
@section('titulo', 'Resultados de Búsqueda')
@section('Contenido')

    <main class="min-vh-100 bg-light">
        <!-- Título de la Página -->
        <div class="container text-center my-4 p-4 rounded"
            style="background: linear-gradient(45deg, #800000, #000080); color: white; border: 2px solid #000;">
            <h2 class="mb-3" style="font-family: 'Arial Black', sans-serif; letter-spacing: 2px;">
                RESULTADOS DE BÚSQUEDA
            </h2>
            <p style="font-size: 18px;">Aquí están los detalles del los departamentos.</p>
        </div>

        <!-- Tarjeta del Usuario Compatible -->
        <div class="container my-5">
            <div class="row justify-content-center">
                <!-- Información del Usuario -->
                <!--
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-lg border-0">
                                    <div class="card-header text-white" style="background: linear-gradient(45deg, #4CAF50, #1E7D35);">
                                        <h4 class="mb-0">Usuario Más Compatible</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ asset('images/user-profile.png') }}" alt="Usuario" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 2px solid #007bff;">
                                            <div class="ml-3">
                                                <h5 class="mb-0 font-weight-bold"></h5>
                                                <p class="mb-0 text-muted">Edad: años</p>
                                            </div>
                                        </div>
                                        <p><strong>Preferencias:</strong></p>
                                        <p><strong>Hobbies:</strong></p>
                                    </div>
                                </div>
                            </div>
                            -->

                <!-- Información del Departamento -->
                @foreach($apartamentos as $depa)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg border-0 d-flex flex-column h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="ratio ratio-16x9 mb-3">
                                    <img src="{{ asset('images/departamento2.jpeg') }}" alt="Departamento"
                                        class="img-fluid rounded shadow" style="object-fit: cover; border-radius: 8px;">
                                </div>

                                <p><strong>Propietario: </strong>{{$depa->propietario_id}} <strong>Edad: 99</strong></p>
                                <p><strong>Edad: 99</strong></p>
                                <p><strong>Ubicación: </strong>{{$depa->direccion}}</p>
                                <p><strong>Precio: </strong>{{$depa->precio}} $ MXN/mes</p>
                                <p><strong>Habitaciones: </strong>{{$depa->habitaciones_disponibles}}</p>
                                <p><strong>Servicios: </strong>
                                @php
                                    $servicios = is_string($depa->servicios) ? json_decode($depa->servicios, true) : $depa->servicios;
                                @endphp
                                @foreach ($servicios as $servicios)
                                <div class="col-md-4">
                                    {{$servicios}}
                                </div>
                                
                                @endforeach
                                </p>
                                <div class="mt-auto d-flex justify-content-center">
                                    <button class="btn btn-outline-primary mb-3 w-50">Contactar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        <!-- Botón de Acción -->
        <div class="container text-center">
            <!--<a href="mailto:s" class="btn btn-primary btn-lg">Contactar a </a>-->
            <a href="{{ route('RutaBusqueda') }}" class="btn btn-secondary btn-lg">Volver a Buscar</a>
        </div>
    </main>

@endsection