@extends('layouts.plantilla_propietarios')
@section('titulo', 'Dashboard')
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
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </h1>
                        <p class="text-muted mb-0">Bienvenido, {{ $propietario->nombre_completo }}</p>
                    </div>
                    <div>
                        <a href="{{ route('propietario.apartamentos.crear') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nuevo Apartamento
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary text-white p-3">
                                <i class="fas fa-building fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="mb-1">{{ $total_apartamentos }}</h3>
                        <p class="text-muted mb-0">Total Apartamentos</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success text-white p-3">
                                <i class="fas fa-home fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="mb-1">{{ $total_apartamentos - $apartamentos_ocupados }}</h3>
                        <p class="text-muted mb-0">Disponibles</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning text-white p-3">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="mb-1">{{ $apartamentos_ocupados }}</h3>
                        <p class="text-muted mb-0">Ocupados</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info text-white p-3">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="mb-1">${{ number_format($ingresos_totales, 0) }}</h3>
                        <p class="text-muted mb-0">Ingresos Potenciales</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Apartments -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-building me-2 text-primary"></i>
                                Mis Apartamentos
                            </h4>
                            <a href="{{ route('propietario.apartamentos') }}" class="btn btn-outline-primary btn-sm">
                                Ver todos
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($apartamentos->count() > 0)
                            <div class="row">
                                @foreach($apartamentos->take(6) as $apartamento)
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 border">
                                            @if($apartamento->imagenes && count($apartamento->imagenes) > 0)
                                                <img src="{{ asset('storage/' . $apartamento->imagenes[0]) }}" 
                                                     alt="{{ $apartamento->titulo }}" 
                                                     class="card-img-top" style="height: 200px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                                     style="height: 200px;">
                                                    <i class="fas fa-image fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $apartamento->titulo }}</h6>
                                                <p class="card-text small text-muted">{{ Str::limit($apartamento->descripcion, 80) }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-primary">${{ number_format($apartamento->precio, 0) }}</span>
                                                    <span class="small text-muted">
                                                        {{ $apartamento->habitaciones_disponibles }} habitaciones
                                                    </span>
                                                </div>
                                                <div class="mt-2">
                                                    <a href="{{ route('propietario.apartamentos.editar', $apartamento->id) }}" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('propietario.apartamentos.eliminar', $apartamento->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                                onclick="return confirm('¿Estás seguro de eliminar este apartamento?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-building fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">No tienes apartamentos publicados</h5>
                                <p class="text-muted">Comienza publicando tu primer apartamento</p>
                                <a href="{{ route('propietario.apartamentos.crear') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Crear Apartamento
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
