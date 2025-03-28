@extends('layouts.Plantilla1')
@section('titulo', 'Detalles')
@section('Contenido')

    <link rel="stylesheet" href="{{ asset('css/detalles.css') }}">

    <div class="container justify-content-center">
        <div class="row">
            <div class="text-center mt-3">
                <h3>{{ $apartamento->titulo }}</h3>
            </div>

            <!-- Contenedor del carrusel y la información -->
            <div class="col-md-8 mx-auto mb-3 mt-3">
                <div id="carouselExampleIndicators" class="carousel slide" style="max-width: 900px; margin: 0 auto;">
                    <div class="carousel-indicators">
                        @foreach(json_decode($apartamento->imagenes, true) as $index => $imagen)
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}"
                                class="{{ $index === 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach(json_decode($apartamento->imagenes, true) as $index => $imagen)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset($imagen) }}" class="d-block w-100" alt="Imagen {{ $index + 1 }}"
                                    style="height: 400px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <!-- Sección en fila (descripción + card de precio) -->
                <div class="row mt-3">
                    <!-- Descripción -->
                    <div class="col-md-7 p-3 border rounded bg-light">
                        <p>{{ $apartamento->descripcion }}</p>
                    </div>
                    <!-- Card de precio/contacto -->
                    <div class="col-md-5">
                        <div class="card shadow-lg rounded-4 text-center p-4">
                            <div class="bg-light p-3 rounded-3">
                                <h3 class="fw-bold text-primary">MX${{ number_format($apartamento->precio, 2) }} 
                                    <span class="fs-6 text-dark">por mes</span>
                                </h3>
                            </div>
                            <button type="button" class="btn btn-primary rounded-pill mt-3 w-100 contact-btn" 
                                data-bs-toggle="modal" data-bs-target="#contactModal">
                                CONTACTAR
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Información alineada a la izquierda -->
                <div class="mt-3">
                    <p><strong>Dirección:</strong> {{ $apartamento->direccion }}</p>
                    <p><strong>Precio:</strong> MX${{ number_format($apartamento->precio, 2) }} / mes</p>
                    <p><strong>Servicios:</strong> {{ implode(', ', json_decode($apartamento->servicios, true)) }}</p>
                    <p><strong>Habitaciones disponibles:</strong> {{ $apartamento->habitaciones_disponibles }}</p>
                    <p><strong>Disponible para:</strong> {{ ucfirst($apartamento->disponible_para) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Contacto -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="contactModalLabel">Información de contacto del propietario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nombre:</strong> {{ $propietario->nombre }} {{ $propietario->apellido_paterno }} {{ $propietario->apellido_materno }}</p>
                    <p><strong>Teléfono:</strong> {{ $propietario->telefono }}</p>
                    <p><strong>Correo:</strong> {{ $propietario->correo }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary contact-btn" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@endsection
