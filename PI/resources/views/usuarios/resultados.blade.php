@extends('layouts.Plantilla1')
@section('titulo', 'Resultados de Búsqueda')
@section('Contenido')

    <link rel="stylesheet" href="{{asset('css/resultados.css')}}">
    <main class="min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
        <!-- Título de la Página -->
        <div class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">
                        <i class="fas fa-search me-3"></i>
                        RESULTADOS DE BÚSQUEDA
                    </h1>
                    <p class="hero-subtitle">Descubre tu hogar ideal entre estos increíbles departamentos</p>
                    <div class="hero-stats">
                        <span class="stat-item">
                            <i class="fas fa-home"></i>
                            {{ count($apartamentos) }} Departamentos Encontrados
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container my-5">
            <div class="row justify-content-center">
                @foreach($apartamentos as $depa)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="apartment-card">
                        <div class="card-image-container">
                            <img src="{{ asset('images/departamento2.jpeg') }}" alt="Departamento" class="card-image">
                            <div class="card-overlay">
                                <div class="price-badge">
                                    ${{ number_format($depa->precio) }} MXN/mes
                                </div>
                            </div>
                        </div>

                        <div class="card-content">
                            @php
                                // Buscar el nombre del propietario usando el ID del propietario
                                $propietario = $propietarios->where('id', $depa->propietario_id)->first();
                            @endphp

                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-building me-2"></i>
                                    Departamento Premium
                                </h5>
                                <div class="owner-info">
                                    <i class="fas fa-user-circle me-2"></i>
                                    <span>{{ $propietario ? $propietario->nombre : 'Desconocido' }}</span>
                                </div>
                            </div>

                            <div class="card-details">
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $depa->direccion }}</span>
                                </div>
                                
                                <div class="detail-item">
                                    <i class="fas fa-bed"></i>
                                    <span>{{ $depa->habitaciones_disponibles }} Habitaciones</span>
                                </div>
                            </div>

                            <div class="services-section">
                                <h6 class="services-title">
                                    <i class="fas fa-star me-2"></i>
                                    Servicios Incluidos y Cercanias
                                </h6>
                                @php
                                    // Verificar si servicios es un string JSON y decodificarlo si es necesario
                                    $servicios = is_string($depa->servicios) ? json_decode($depa->servicios, true) : $depa->servicios;
                                @endphp

                                @if(is_array($servicios) && count($servicios) > 0) 
                                    <div class="services-grid">
                                        @foreach ($servicios as $servicio)
                                            <div class="service-item">
                                                <i class="fas fa-check-circle me-2"></i>
                                                <span>{{ $servicio }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="no-services">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <span>No hay servicios especificados</span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('RutaDetalles', ['id' => $depa->id, 'propietario_id' => $depa->propietario_id]) }}"
                                    class="contact-btn">
                                    <i class="fas fa-phone me-2"></i>
                                    Mas Información
                                </a>
                            </div>
                        </div>
                    </div>
                </div>                 
                @endforeach

                @if(count($apartamentos) === 0)
                    <div class="col-12">
                        <div class="no-results">
                            <i class="fas fa-home fa-3x mb-3"></i>
                            <h4>No se encontraron departamentos</h4>
                            <p>Intenta ajustar tus criterios de búsqueda para encontrar más opciones.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </main>

@endsection
