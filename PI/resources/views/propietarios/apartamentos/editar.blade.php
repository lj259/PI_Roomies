@extends('layouts.plantilla_propietarios')
@section('titulo', 'Editar Apartamento')
@section('Contenido')

<link rel="stylesheet" href="{{asset('css/perfil.css')}}">

<main class="min-vh-100 bg-light">
    <div class="container py-5">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <h1 class="text-dark mb-0">
                        <i class="fas fa-edit me-2"></i>Editar Apartamento
                    </h1>
                </div>
                <nav aria-label="breadcrumb" class="mt-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('propietario.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('propietario.apartamentos') }}">Apartamentos</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Form -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('propietario.apartamentos.actualizar', $apartamento->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Basic Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="text-primary mb-3">
                                        <i class="fas fa-info-circle me-2"></i>Información Básica
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="titulo" name="titulo" 
                                               value="{{ old('titulo', $apartamento->titulo) }}" required>
                                        <label for="titulo">Título del Apartamento</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="precio" name="precio" 
                                               value="{{ old('precio', $apartamento->precio) }}" min="0" step="0.01" required>
                                        <label for="precio">Precio (MXN)</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" id="descripcion" name="descripcion" 
                                                  style="height: 120px" required>{{ old('descripcion', $apartamento->descripcion) }}</textarea>
                                        <label for="descripcion">Descripción</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="direccion" name="direccion" 
                                               value="{{ old('direccion', $apartamento->direccion) }}" required>
                                        <label for="direccion">Dirección Completa</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Room Details -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="text-primary mb-3">
                                        <i class="fas fa-bed me-2"></i>Detalles de Habitaciones
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="habitaciones_disponibles" 
                                               name="habitaciones_disponibles" value="{{ old('habitaciones_disponibles', $apartamento->habitaciones_disponibles) }}" 
                                               min="0" required>
                                        <label for="habitaciones_disponibles">Habitaciones Disponibles</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="disponible_para" name="disponible_para" required>
                                            <option value="">Selecciona para quién está disponible</option>
                                            <option value="masculino" {{ old('disponible_para', $apartamento->disponible_para) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                            <option value="femenino" {{ old('disponible_para', $apartamento->disponible_para) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                            <option value="otro" {{ old('disponible_para', $apartamento->disponible_para) == 'otro' ? 'selected' : '' }}>Mixto</option>
                                        </select>
                                        <label for="disponible_para">Disponible Para</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Services -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="text-primary mb-3">
                                        <i class="fas fa-cogs me-2"></i>Servicios Incluidos
                                    </h4>
                                    <p class="text-muted mb-3">Selecciona todos los servicios que incluye tu apartamento</p>
                                    
                                    <div class="row">
                                        @php
                                            $servicios_disponibles = [
                                                'Wi-Fi', 'Agua', 'Luz', 'Gas', 'Limpieza', 'Lavandería',
                                                'Estacionamiento', 'Seguridad', 'Gym', 'Piscina', 
                                                'Cocina equipada', 'Refrigerador', 'Microondas', 'TV',
                                                'Aire acondicionado', 'Calefacción', 'Jardín', 'Terraza'
                                            ];
                                            $servicios_actuales = old('servicios', $apartamento->servicios ?? []);
                                        @endphp
                                        
                                        @foreach($servicios_disponibles as $servicio)
                                            <div class="col-md-3 col-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           id="servicio_{{ $loop->index }}" 
                                                           name="servicios[]" value="{{ $servicio }}"
                                                           {{ in_array($servicio, $servicios_actuales) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="servicio_{{ $loop->index }}">
                                                        {{ $servicio }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Current Images -->
                            @if($apartamento->imagenes && count($apartamento->imagenes) > 0)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h4 class="text-primary mb-3">
                                            <i class="fas fa-images me-2"></i>Imágenes Actuales
                                        </h4>
                                        <div class="row">
                                            @foreach($apartamento->imagenes as $imagen)
                                                <div class="col-md-3 col-6 mb-3">
                                                    <div class="card">
                                                        <img src="{{ Storage::url($imagen) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                                        <div class="card-body p-2 text-center">
                                                            <small class="text-muted">Imagen {{ $loop->iteration }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- New Images -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="text-primary mb-3">
                                        <i class="fas fa-image me-2"></i>Agregar Nuevas Imágenes
                                    </h4>
                                    <p class="text-muted mb-3">Sube nuevas imágenes para tu apartamento (las imágenes actuales se mantendrán)</p>
                                    
                                    <div class="mb-3">
                                        <input type="file" class="form-control" id="imagenes" name="imagenes[]" 
                                               multiple accept="image/*">
                                        <div class="form-text">Puedes seleccionar múltiples imágenes. Máximo 2MB por imagen.</div>
                                    </div>
                                    
                                    <div id="image-preview" class="row mt-3"></div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    <hr class="my-4">
                                    <div class="d-flex gap-3">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i>Actualizar Apartamento
                                        </button>
                                        <a href="{{ route('propietario.apartamentos') }}" class="btn btn-outline-secondary btn-lg">
                                            <i class="fas fa-times me-2"></i>Cancelar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.getElementById('imagenes').addEventListener('change', function() {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    
    Array.from(this.files).forEach((file, index) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3 col-6 mb-3';
                col.innerHTML = `
                    <div class="card">
                        <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                        <div class="card-body p-2">
                            <small class="text-muted">${file.name}</small>
                        </div>
                    </div>
                `;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

@endsection
