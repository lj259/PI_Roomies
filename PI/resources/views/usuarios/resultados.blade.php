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
            <div class="row justify-content-center">
                @foreach($apartamentos as $depa)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg border-0 d-flex flex-column h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="ratio ratio-16x9 mb-3">
                                    <img src="{{ asset('images/departamento2.jpeg') }}" alt="Departamento"
                                        class="img-fluid rounded shadow" style="object-fit: cover; border-radius: 8px;">
                                </div>

                                @php
                                    // Buscar el nombre del propietario usando el ID del propietario
                                    $propietario = $propietarios->where('id', $depa->propietario_id)->first();
                                @endphp

                                <p><strong>Propietario: </strong>{{ $propietario ? $propietario->nombre : 'Desconocido' }}</p>
                                <p><strong>Ubicación: </strong>{{$depa->direccion}}</p>
                                <p><strong>Precio: </strong>{{$depa->precio}} $ MXN/mes</p>
                                <p><strong>Habitaciones: </strong>{{$depa->habitaciones_disponibles}}</p>

                                <p><strong>Servicios: </strong>
                                    @php
                                        // Verificar si servicios es un string JSON y decodificarlo si es necesario
                                        $servicios = is_string($depa->servicios) ? json_decode($depa->servicios, true) : $depa->servicios;
                                    @endphp

                                    @if(is_array($servicios)) 
                                        <ul>
                                            @foreach ($servicios as $servicio)
                                                <li>{{ $servicio }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No hay servicios disponibles</p>
                                    @endif
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
