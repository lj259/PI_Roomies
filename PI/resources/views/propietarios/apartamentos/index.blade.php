@extends('layouts.plantilla_propietarios')
@section('titulo', 'Mis Apartamentos')
@section('Contenido')

<link rel="stylesheet" href="{{asset('css/perfil.css')}}">

<main class="min-vh-100 bg-light">
    <div class="container py-5">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="text-dark mb-0">
                            <i class="fas fa-building me-2"></i>Mis Apartamentos
                        </h1>
                        <p class="text-muted mb-0">Gestiona todas tus propiedades</p>
                    </div>
                    <div>
                        <a href="{{ route('propietario.apartamentos.crear') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nuevo Apartamento
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('Exito'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('Exito') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Apartments Grid -->
        @if($apartamentos->count() > 0)
            <div class="row">
                @foreach($apartamentos as $apartamento)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            @if($apartamento->imagenes && count($apartamento->imagenes) > 0)
                                <div id="carousel{{ $apartamento->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($apartamento->imagenes as $index => $imagen)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $imagen) }}" 
                                                     alt="{{ $apartamento->titulo }}" 
                                                     class="d-block w-100" style="height: 250px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($apartamento->imagenes) > 1)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $apartamento->id }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $apartamento->id }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                    @endif
                                </div>
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 250px;">
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $apartamento->titulo }}</h5>
                                <p class="card-text text-muted flex-grow-1">{{ Str::limit($apartamento->descripcion, 100) }}</p>
                                
                                <div class="mb-3">
                                    <p class="mb-1"><i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $apartamento->direccion }}</p>
                                    <p class="mb-1"><i class="fas fa-dollar-sign text-success me-2"></i>${{ number_format($apartamento->precio, 0) }} MXN</p>
                                    <p class="mb-1"><i class="fas fa-bed text-info me-2"></i>{{ $apartamento->habitaciones_disponibles }} habitaciones</p>
                                    <p class="mb-0">
                                        <i class="fas fa-users text-warning me-2"></i>
                                        Disponible para: 
                                        <span class="badge bg-secondary">{{ ucfirst($apartamento->disponible_para) }}</span>
                                    </p>
                                </div>

                                @if($apartamento->servicios && count($apartamento->servicios) > 0)
                                    <div class="mb-3">
                                        <small class="text-muted">Servicios:</small>
                                        <div class="mt-1">
                                            @foreach(array_slice($apartamento->servicios, 0, 3) as $servicio)
                                                <span class="badge bg-light text-dark me-1">{{ $servicio }}</span>
                                            @endforeach
                                            @if(count($apartamento->servicios) > 3)
                                                <span class="badge bg-light text-dark">+{{ count($apartamento->servicios) - 3 }} más</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex gap-2 mt-auto">
                                    <a href="{{ route('propietario.apartamentos.editar', $apartamento->id) }}" 
                                       class="btn btn-outline-primary btn-sm flex-fill">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </a>
                                    <form action="{{ route('propietario.apartamentos.eliminar', $apartamento->id) }}" 
                                          method="POST" class="flex-fill">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                                onclick="return confirm('¿Estás seguro de eliminar este apartamento?')">
                                            <i class="fas fa-trash me-1"></i>Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-building fa-5x text-muted mb-4"></i>
                            <h3 class="text-muted mb-3">No tienes apartamentos publicados</h3>
                            <p class="text-muted mb-4">Comienza publicando tu primer apartamento para encontrar inquilinos</p>
                            <a href="{{ route('propietario.apartamentos.crear') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>Crear Mi Primer Apartamento
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>

@endsection
