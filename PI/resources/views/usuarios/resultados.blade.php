@extends('layouts.Plantilla1')
@section('titulo', 'Resultados de Búsqueda')
@section('Contenido')

    <link rel="stylesheet" href="{{asset('css/resultados.css')}}">
    <main class="min-vh-100 bg-light">
        <!-- Título de la Página -->
        <div class="container text-center my-4 p-4 rounded"
            style="background: linear-gradient(45deg, #800000, #000080); color: white; border: 2px solid #000;">
            <h2 class="mb-3" style="font-family: 'Arial Black', sans-serif; letter-spacing: 2px;">
                RESULTADOS DE BÚSQUEDA
            </h2>
            <p style="font-size: 18px;">Aquí están los detalles del los departamentos.</p>
        </div>

        <div class="container my-5">
            <div class="row align-items-center justify-content-start my-4">
                <div class="col-auto">
                    <div class="dropdown">
                        <button class="btn filtro-dropdown dropdown-toggle" type="button" id="filtroDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ request('publico', 'todos') == 'todos' ? 'Todos' : '' }}
                            {{ request('publico') == 'hombres' ? 'Hombres' : '' }}
                            {{ request('publico') == 'mujeres' ? 'Mujeres' : '' }}
                            {{ request('publico') == 'mixto' ? 'Mixto' : '' }}
                        </button>
                        <ul class="dropdown-menu filtro-menu" aria-labelledby="filtroDropdown">
                            <li><a class="dropdown-item filtro-item {{ request('publico', 'todos') == 'todos' ? 'active' : '' }}"
                                    href="{{ route('RutaResultados', ['publico' => 'todos']) }}">Todos</a></li>
                            <li><a class="dropdown-item filtro-item {{ request('publico') == 'hombres' ? 'active' : '' }}"
                                    href="{{ route('RutaResultados', ['publico' => 'hombres']) }}">Hombres</a></li>
                            <li><a class="dropdown-item filtro-item {{ request('publico') == 'mujeres' ? 'active' : '' }}"
                                    href="{{ route('RutaResultados', ['publico' => 'mujeres']) }}">Mujeres</a></li>
                            <li><a class="dropdown-item filtro-item {{ request('publico') == 'mixto' ? 'active' : '' }}"
                                    href="{{ route('RutaResultados', ['publico' => 'mixto']) }}">Mixto</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-auto">
                    <a href="{{ route('RutaResultados', ['publico' => 'todos']) }}" class="refresh-btn">Refresh</a>
                </div>
            </div>

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
                                    <a href="{{ route('RutaDetalles', ['id' => $depa->id, 'propietario_id' => $depa->propietario_id]) }}"
                                        class="btn btn-outline-primary mb-3 w-50">Contacto</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </main>

@endsection