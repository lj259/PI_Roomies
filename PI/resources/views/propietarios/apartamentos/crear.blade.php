@extends('layouts.plantilla_propietarios')
@section('titulo', 'Crear Apartamento')
@section('Contenido')

<link rel="stylesheet" href="{{asset('css/perfil.css')}}">
<!-- Leaflet CSS for OpenStreetMap -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
      crossorigin=""/>

<style>
#map {
    height: 400px;
    width: 100%;
    border-radius: 0.375rem;
    border: 1px solid #dee2e6;
}

.map-instructions {
    background-color: #e3f2fd;
    border-left: 4px solid #2196f3;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 0 0.375rem 0.375rem 0;
}

.coordinates-display {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 0.375rem;
    border: 1px solid #e9ecef;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
}
</style>

<main class="min-vh-100 bg-light">
    <div class="container py-5">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <h1 class="text-dark mb-0">
                        <i class="fas fa-plus me-2"></i>Crear Nuevo Apartamento
                    </h1>
                </div>
                <nav aria-label="breadcrumb" class="mt-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('propietario.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('propietario.apartamentos') }}">Apartamentos</a></li>
                        <li class="breadcrumb-item active">Crear</li>
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
                        <form action="{{ route('propietario.apartamentos.guardar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
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
                                               value="{{ old('titulo') }}" required>
                                        <label for="titulo">Título del Apartamento</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="precio" name="precio" 
                                               value="{{ old('precio') }}" min="0" step="0.01" required>
                                        <label for="precio">Precio (MXN)</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" id="descripcion" name="descripcion" 
                                                  style="height: 120px" required>{{ old('descripcion') }}</textarea>
                                        <label for="descripcion">Descripción</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="direccion" name="direccion" 
                                               value="{{ old('direccion') }}" required>
                                        <label for="direccion">Dirección Completa</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Map -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="text-primary mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>Ubicación en el Mapa
                                    </h4>
                                    
                                    <div class="map-instructions">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Instrucciones:</strong> Busca la dirección de tu apartamento o haz clic en el mapa para seleccionar la ubicación exacta.
                                    </div>
                                    
                                    <!-- Search Box -->
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="search-address" 
                                                       placeholder="Buscar dirección... (ej: Calle 5 de Mayo, Guadalajara)">
                                                <button class="btn btn-outline-primary" type="button" id="search-btn">
                                                    <i class="fas fa-search"></i> Buscar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-outline-secondary w-100" id="get-location-btn">
                                                <i class="fas fa-crosshairs"></i> Mi Ubicación
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Map Container -->
                                    <div id="map"></div>
                                    
                                    <!-- Coordinates Display -->
                                    <div class="coordinates-display mt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Latitud:</strong> <span id="lat-display">20.6596</span>
                                                <input type="hidden" id="latitud" name="latitud" value="{{ old('latitud', '20.6596') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Longitud:</strong> <span id="lng-display">-103.3496</span>
                                                <input type="hidden" id="longitud" name="longitud" value="{{ old('longitud', '-103.3496') }}">
                                            </div>
                                        </div>
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
                                               name="habitaciones_disponibles" value="{{ old('habitaciones_disponibles') }}" 
                                               min="1" required>
                                        <label for="habitaciones_disponibles">Habitaciones Disponibles</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="disponible_para" name="disponible_para" required>
                                            <option value="">Selecciona para quién está disponible</option>
                                            <option value="masculino" {{ old('disponible_para') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                            <option value="femenino" {{ old('disponible_para') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                            <option value="otro" {{ old('disponible_para') == 'otro' ? 'selected' : '' }}>Mixto</option>
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
                                        @endphp
                                        
                                        @foreach($servicios_disponibles as $servicio)
                                            <div class="col-md-3 col-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           id="servicio_{{ $loop->index }}" 
                                                           name="servicios[]" value="{{ $servicio }}"
                                                           {{ (old('servicios') && in_array($servicio, old('servicios'))) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="servicio_{{ $loop->index }}">
                                                        {{ $servicio }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Images -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="text-primary mb-3">
                                        <i class="fas fa-images me-2"></i>Imágenes del Apartamento
                                    </h4>
                                    <p class="text-muted mb-3">Sube imágenes de tu apartamento para atraer más inquilinos</p>
                                    
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
                                            <i class="fas fa-save me-2"></i>Crear Apartamento
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
// Image preview functionality
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

<!-- Leaflet JavaScript for OpenStreetMap -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<script>
// Initialize map
let map, marker;
let defaultLat = {{ old('latitud', '20.6596') }};
let defaultLng = {{ old('longitud', '-103.3496') }};

function initMap() {
    // Create map centered on Guadalajara, Mexico
    map = L.map('map').setView([defaultLat, defaultLng], 13);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Add initial marker
    marker = L.marker([defaultLat, defaultLng], {
        draggable: true
    }).addTo(map);
    
    // Update coordinates when marker is dragged
    marker.on('dragend', function(e) {
        updateCoordinates(e.target.getLatLng().lat, e.target.getLatLng().lng);
    });
    
    // Add marker when map is clicked
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateCoordinates(e.latlng.lat, e.latlng.lng);
        
        // Try to get address from coordinates
        reverseGeocode(e.latlng.lat, e.latlng.lng);
    });
}

function updateCoordinates(lat, lng) {
    document.getElementById('lat-display').textContent = lat.toFixed(6);
    document.getElementById('lng-display').textContent = lng.toFixed(6);
    document.getElementById('latitud').value = lat;
    document.getElementById('longitud').value = lng;
}

// Search for address
document.getElementById('search-btn').addEventListener('click', function() {
    const address = document.getElementById('search-address').value;
    if (address.trim() === '') {
        Swal.fire({
            title: 'Campo vacío',
            text: 'Por favor ingresa una dirección para buscar',
            icon: 'warning',
            confirmButtonText: 'Entendido'
        });
        return;
    }
    
    searchAddress(address);
});

// Allow search on Enter key
document.getElementById('search-address').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('search-btn').click();
    }
});

// Get current location
document.getElementById('get-location-btn').addEventListener('click', function() {
    if (!navigator.geolocation) {
        Swal.fire({
            title: 'Geolocalización no disponible',
            text: 'Tu navegador no soporta geolocalización',
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
        return;
    }
    
    const btn = this;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Obteniendo...';
    btn.disabled = true;
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            map.setView([lat, lng], 15);
            marker.setLatLng([lat, lng]);
            updateCoordinates(lat, lng);
            
            // Get address for current location
            reverseGeocode(lat, lng);
            
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            Swal.fire({
                title: '¡Ubicación encontrada!',
                text: 'Se ha establecido tu ubicación actual en el mapa',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        },
        function(error) {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            let errorMessage = 'No se pudo obtener tu ubicación';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = 'Permiso de ubicación denegado';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = 'Información de ubicación no disponible';
                    break;
                case error.TIMEOUT:
                    errorMessage = 'Tiempo de espera agotado para obtener ubicación';
                    break;
            }
            
            Swal.fire({
                title: 'Error de ubicación',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 60000
        }
    );
});

// Search address using Nominatim API (OpenStreetMap)
async function searchAddress(address) {
    const btn = document.getElementById('search-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    btn.disabled = true;
    
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1&countrycodes=MX`);
        const data = await response.json();
        
        if (data.length > 0) {
            const lat = parseFloat(data[0].lat);
            const lng = parseFloat(data[0].lon);
            
            map.setView([lat, lng], 15);
            marker.setLatLng([lat, lng]);
            updateCoordinates(lat, lng);
            
            // Update address field if found
            const foundAddress = data[0].display_name;
            document.getElementById('direccion').value = foundAddress;
            
            Swal.fire({
                title: '¡Dirección encontrada!',
                text: 'Se ha establecido la ubicación en el mapa',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        } else {
            Swal.fire({
                title: 'Dirección no encontrada',
                text: 'No se pudo encontrar la dirección especificada. Intenta con una dirección más específica.',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
        }
    } catch (error) {
        console.error('Error searching address:', error);
        Swal.fire({
            title: 'Error de búsqueda',
            text: 'Ocurrió un error al buscar la dirección. Intenta nuevamente.',
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
    }
    
    btn.innerHTML = originalText;
    btn.disabled = false;
}

// Reverse geocoding to get address from coordinates
async function reverseGeocode(lat, lng) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
        const data = await response.json();
        
        if (data.display_name) {
            // Update the address field with found address
            document.getElementById('direccion').value = data.display_name;
        }
    } catch (error) {
        console.error('Error in reverse geocoding:', error);
    }
}

// Sync address field with search
document.getElementById('direccion').addEventListener('blur', function() {
    const address = this.value;
    if (address.trim() !== '') {
        document.getElementById('search-address').value = address;
    }
});

// Initialize map when page loads
document.addEventListener('DOMContentLoaded', function() {
    initMap();
});
</script>

@endsection
