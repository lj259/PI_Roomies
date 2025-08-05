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
                @php
                    // Since imagenes is cast as array in the model, check if it's already an array
                    $imagenes = is_array($apartamento->imagenes) ? $apartamento->imagenes : json_decode($apartamento->imagenes, true);
                    $imagenes = is_array($imagenes) ? $imagenes : [];
                    
                    // If no images are available, use placeholder images
                    if (empty($imagenes)) {
                        $imagenes = [
                            'images/departamento2.jpeg',
                            'images/casa3.avif',
                            'images/casa4.webp'
                        ];
                        $useStorage = false;
                    } else {
                        $useStorage = true;
                    }
                @endphp
                
                @if(count($imagenes) > 1)
                <div class="carousel-indicators">
                    @foreach($imagenes as $index => $imagen)
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                @endif
                
                <div class="carousel-inner">
                    @foreach($imagenes as $index => $imagen)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ $useStorage ? asset('storage/' . $imagen) : asset($imagen) }}" class="d-block w-100" alt="Imagen {{ $index + 1 }} del apartamento"
                            style="height: 400px; object-fit: cover;">
                    </div>
                    @endforeach
                </div>
                
                @if(count($imagenes) > 1)
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
                @endif
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
                            @auth
                                @if(\App\Models\MensajePropietario::tieneConversacion(Auth::id(), $propietario->id, $apartamento->id))
                                    <i class="fas fa-comments"></i> CONTINUAR CONVERSACIÓN
                                @else
                                    <i class="fas fa-envelope"></i> CONTACTAR
                                @endif
                            @else
                                <i class="fas fa-envelope"></i> CONTACTAR
                            @endauth
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
                        // Since servicios is cast as array in the model, no need to json_decode
                        $servicios = $apartamento->servicios;
                        
                        // If it's still a string for some reason, decode it
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="contactModalLabel">Contactar al propietario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información del propietario -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="fas fa-user"></i> Información del propietario</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Nombre:</strong> {{ $propietario->nombre }} {{ $propietario->apellido_paterno }}</p>
                                <p><strong>Teléfono:</strong> {{ $propietario->telefono }}</p>
                                <p><strong>Correo:</strong> {{ $propietario->correo }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Formulario de mensaje -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="fas fa-envelope"></i> Enviar mensaje</h6>
                            </div>
                            <div class="card-body">
                                @auth
                                    <form id="messageForm">
                                        @csrf
                                        <input type="hidden" name="propietario_id" value="{{ $propietario->id }}">
                                        <input type="hidden" name="apartamento_id" value="{{ $apartamento->id }}">
                                        
                                        <div class="mb-3">
                                            <label for="asunto" class="form-label">Asunto</label>
                                            <input type="text" class="form-control" id="asunto" name="asunto" 
                                                   value="Consulta sobre: {{ $apartamento->titulo }}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="mensaje" class="form-label">Mensaje</label>
                                            <textarea class="form-control" id="mensaje" name="mensaje" rows="4" 
                                                      placeholder="Escribe tu mensaje aquí..." required></textarea>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-paper-plane"></i> Enviar mensaje
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-info">
                                        <p class="mb-2"><i class="fas fa-info-circle"></i> Para enviar un mensaje al propietario, necesitas iniciar sesión.</p>
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Iniciar sesión</a>
                                        <a href="{{ route('RutaRegistroUsr') }}" class="btn btn-outline-primary btn-sm">Registrarse</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mensajes previos (si existen) -->
                @auth
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-comments"></i> Conversación</h6>
                            </div>
                            <div class="card-body" style="max-height: 300px; overflow-y: auto;" id="mensajes-container">
                                <div class="text-center text-muted" id="loading-messages">
                                    <i class="fas fa-spinner fa-spin"></i> Cargando mensajes...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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

<!-- Script para el sistema de mensajes -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    @auth
    // Cargar mensajes cuando se abra el modal
    const contactModal = document.getElementById('contactModal');
    contactModal.addEventListener('shown.bs.modal', function () {
        cargarMensajes();
    });
    
    // Manejar envío de mensaje
    const messageForm = document.getElementById('messageForm');
    if (messageForm) {
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            enviarMensaje();
        });
    }
    
    function cargarMensajes() {
        const propietarioId = {{ $propietario->id }};
        const apartamentoId = {{ $apartamento->id }};
        
        fetch(`/mensajes-propietario/${propietarioId}/${apartamentoId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('mensajes-container');
            
            if (data.success && data.mensajes.length > 0) {
                container.innerHTML = '';
                
                data.mensajes.forEach(mensaje => {
                    const mensajeDiv = document.createElement('div');
                    mensajeDiv.className = `mb-3 ${mensaje.es_mio ? 'text-end' : 'text-start'}`;
                    
                    const fecha = new Date(mensaje.created_at).toLocaleString('es-ES');
                    const nombreEmisor = mensaje.es_mio ? 'Tú' : '{{ $propietario->nombre }}';
                    
                    mensajeDiv.innerHTML = `
                        <div class="card ${mensaje.es_mio ? 'bg-primary text-white ms-auto' : 'bg-light'}" style="max-width: 80%;">
                            <div class="card-body p-2">
                                <h6 class="card-subtitle mb-1" style="font-size: 0.8rem;">
                                    <strong>${mensaje.asunto}</strong>
                                </h6>
                                <p class="card-text mb-1">${mensaje.contenido}</p>
                                <small class="${mensaje.es_mio ? 'text-white-50' : 'text-muted'}">${nombreEmisor} - ${fecha}</small>
                            </div>
                        </div>
                    `;
                    
                    container.appendChild(mensajeDiv);
                });
                
                // Scroll al final
                container.scrollTop = container.scrollHeight;
            } else {
                container.innerHTML = '<p class="text-muted text-center">No hay mensajes previos</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('mensajes-container').innerHTML = 
                '<p class="text-danger text-center">Error al cargar mensajes</p>';
        });
    }
    
    function enviarMensaje() {
        const form = document.getElementById('messageForm');
        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        
        // Deshabilitar botón
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
        
        fetch('/enviar-mensaje-propietario', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Limpiar formulario
                document.getElementById('mensaje').value = '';
                
                // Mostrar éxito
                Swal.fire({
                    title: '¡Mensaje enviado!',
                    text: 'Tu mensaje ha sido enviado al propietario',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
                
                // Recargar mensajes
                cargarMensajes();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Error al enviar el mensaje',
                    icon: 'error'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Error de conexión al enviar el mensaje',
                icon: 'error'
            });
        })
        .finally(() => {
            // Habilitar botón
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar mensaje';
        });
    }
    @endauth
});
</script>

@endsection
