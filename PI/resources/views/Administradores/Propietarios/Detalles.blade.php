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
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/departamento2.jpeg') }}" class="d-block w-100" alt="..."
                            style="height: 400px; object-fit: cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/casa3.avif') }}" class="d-block w-100" alt="..."
                            style="height: 400px; object-fit: cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/casa4.webp') }}" class="d-block w-100" alt="..."
                            style="height: 400px; object-fit: cover;">
                    </div>
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

                <p><strong>Servicios:</strong> 
                    @php
                        $servicios = json_decode($apartamento->servicios, true);

                        // Si después de la primera decodificación sigue siendo una cadena, decodificar de nuevo
                        if (is_string($servicios)) {
                            $servicios = json_decode($servicios, true);
                        }
                    @endphp

                    {{ is_array($servicios) ? implode(', ', $servicios) : 'No especificado' }}
                </p>

                <p><strong>Habitaciones disponibles:</strong> {{ $apartamento->habitaciones_disponibles }}</p>

                @if ($apartamento->disponible_para === 'masculino')
                        <p><strong>Disponible para:</strong> Solo Hombres</p>
                @endif
                @if ($apartamento->disponible_para === 'femenino')
                        <p><strong>Disponible para:</strong> Solo Mujeres</p>
                @endif
                @if ($apartamento->disponible_para === 'otro')
                        <p><strong>Disponible para:</strong> Mixto</p>
                @endif

            </div>

            <!-- Sección del mapa -->
            <div class="mt-3">
                <h5>Ubicación:</h5>
                <div id="map" style="height: 400px; border-radius: 10px;"></div> <!-- Mapa -->
            </div>
        </div>
    </div>
</div>

<!-- Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<!-- Modal de Contacto -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="contactModalLabel">Información de contacto del propietario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nombre:</strong> {{ $propietario->nombre }}</p>
                <p><strong>Teléfono:</strong> {{ $propietario->telefono }}</p>
                <p><strong>Correo:</strong> {{ $propietario->correo }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary contact-btn" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Script del mapa -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener latitud y longitud desde el backend
        var latitud = {{ $apartamento->latitud ?? 20.588055555556 }};
        var longitud = {{ $apartamento->longitud ?? -100.38805555556 }};

        // Inicializar el mapa centrado en la ubicación del apartamento
        var map = L.map('map').setView([latitud, longitud], 13);

        // Cargar los tiles del mapa
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Opcional: Agregar un círculo en la ubicación sin un marcador
        L.circle([latitud, longitud], {
            color: 'blue',
            fillColor: '#3a9dfc',
            fillOpacity: 0.3,
            radius: 50
        }).addTo(map);
    });
</script>

@endsection
