@extends('layouts.plantilla_propietarios')

@section('titulo', 'Mensajes')

@section('Contenido')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-envelope"></i> Mensajes de Usuarios</h2>
                <div class="badge bg-primary fs-6">
                    {{ $mensajes->sum(function($apartamentoMensajes) { return $apartamentoMensajes->count(); }) }} mensajes totales
                </div>
            </div>

            @if($mensajes->isEmpty())
                <div class="alert alert-info text-center">
                    <h4><i class="fas fa-inbox"></i></h4>
                    <p>No tienes mensajes de usuarios aún.</p>
                    <small class="text-muted">Los usuarios podrán contactarte a través de tus publicaciones de apartamentos.</small>
                </div>
            @else
                @foreach($mensajes as $apartamentoId => $apartamentoMensajes)
                    @php
                        $apartamento = $apartamentoMensajes->first()->apartamento;
                        $usuarios = $apartamentoMensajes->groupBy('usuario_id');
                    @endphp
                    
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-building"></i> {{ $apartamento->titulo }}
                                <span class="badge bg-light text-dark ms-2">{{ $usuarios->count() }} conversaciones</span>
                            </h5>
                            <small>{{ $apartamento->direccion }}</small>
                        </div>
                        
                        <div class="card-body">
                            @foreach($usuarios as $usuarioId => $usuarioMensajes)
                                @php
                                    $usuario = $usuarioMensajes->first()->usuario;
                                    $ultimoMensaje = $usuarioMensajes->sortByDesc('created_at')->first();
                                @endphp
                                
                                <div class="border rounded p-3 mb-3 conversacion-item" data-usuario="{{ $usuario->id }}" data-apartamento="{{ $apartamento->id }}">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center mb-2">
                                                @if($usuario->foto_perfil && $usuario->foto_perfil !== 'perfil/default.jpg')
                                                    <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" 
                                                         alt="Foto de perfil" 
                                                         class="rounded-circle me-3" 
                                                         width="40" height="40">
                                                @else
                                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3"
                                                         style="width: 40px; height: 40px;">
                                                        {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $usuario->nombre }} {{ $usuario->apellido_paterno }}</h6>
                                                    <small class="text-muted">{{ $usuario->correo }}</small>
                                                </div>
                                            </div>
                                            
                                            <div class="ultimo-mensaje">
                                                <strong>Último mensaje:</strong> {{ $ultimoMensaje->asunto }}
                                                <br>
                                                <span class="text-muted">{{ Str::limit($ultimoMensaje->contenido, 100) }}</span>
                                                <br>
                                                <small class="text-muted">{{ $ultimoMensaje->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 text-end">
                                            <div class="d-flex flex-column gap-2">
                                                <span class="badge bg-info">{{ $usuarioMensajes->count() }} mensajes</span>
                                                <button class="btn btn-primary btn-sm ver-conversacion" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#conversacionModal"
                                                        data-usuario-id="{{ $usuario->id }}"
                                                        data-apartamento-id="{{ $apartamento->id }}"
                                                        data-usuario-nombre="{{ $usuario->nombre }} {{ $usuario->apellido_paterno }}">
                                                    <i class="fas fa-eye"></i> Ver conversación
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Modal para ver conversación completa -->
<div class="modal fade" id="conversacionModal" tabindex="-1" aria-labelledby="conversacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="conversacionModalLabel">
                    <i class="fas fa-comments"></i> Conversación con <span id="modal-usuario-nombre"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Mensajes de la conversación -->
                <div id="mensajes-conversacion" style="max-height: 400px; overflow-y: auto;" class="mb-3">
                    <div class="text-center">
                        <i class="fas fa-spinner fa-spin"></i> Cargando conversación...
                    </div>
                </div>
                
                <!-- Formulario para responder -->
                <div class="border-top pt-3">
                    <form id="responderForm">
                        @csrf
                        <input type="hidden" id="modal-usuario-id" name="usuario_id">
                        <input type="hidden" id="modal-apartamento-id" name="apartamento_id">
                        
                        <div class="mb-3">
                            <label for="respuesta-asunto" class="form-label">Asunto</label>
                            <input type="text" class="form-control" id="respuesta-asunto" name="asunto" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="respuesta-mensaje" class="form-label">Tu respuesta</label>
                            <textarea class="form-control" id="respuesta-mensaje" name="mensaje" rows="3" 
                                      placeholder="Escribe tu respuesta aquí..." required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-reply"></i> Enviar respuesta
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.conversacion-item {
    transition: all 0.3s ease;
    cursor: pointer;
}

.conversacion-item:hover {
    background-color: #f8f9fa;
    border-color: #007bff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.ultimo-mensaje {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 8px;
}

#mensajes-conversacion::-webkit-scrollbar {
    width: 6px;
}

#mensajes-conversacion::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

#mensajes-conversacion::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

#mensajes-conversacion::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar click en ver conversación
    document.querySelectorAll('.ver-conversacion').forEach(button => {
        button.addEventListener('click', function() {
            const usuarioId = this.dataset.usuarioId;
            const apartamentoId = this.dataset.apartamentoId;
            const usuarioNombre = this.dataset.usuarioNombre;
            
            // Actualizar modal
            document.getElementById('modal-usuario-nombre').textContent = usuarioNombre;
            document.getElementById('modal-usuario-id').value = usuarioId;
            document.getElementById('modal-apartamento-id').value = apartamentoId;
            
            // Cargar conversación
            cargarConversacion(usuarioId, apartamentoId);
        });
    });
    
    // Manejar envío de respuesta
    document.getElementById('responderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        enviarRespuesta();
    });
});

function cargarConversacion(usuarioId, apartamentoId) {
    const container = document.getElementById('mensajes-conversacion');
    
    fetch(`/propietario/conversacion/${usuarioId}/${apartamentoId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.mensajes.length > 0) {
            container.innerHTML = '';
            
            data.mensajes.forEach(mensaje => {
                const mensajeDiv = document.createElement('div');
                mensajeDiv.className = `mb-3 ${mensaje.emisor_tipo === 'propietario' ? 'text-end' : 'text-start'}`;
                
                const fecha = new Date(mensaje.created_at).toLocaleString('es-ES');
                const esPropio = mensaje.emisor_tipo === 'propietario';
                
                mensajeDiv.innerHTML = `
                    <div class="card ${esPropio ? 'bg-primary text-white ms-auto' : 'bg-light'}" style="max-width: 80%;">
                        <div class="card-body p-3">
                            <h6 class="card-subtitle mb-2" style="font-size: 0.9rem;">
                                <strong>${mensaje.asunto}</strong>
                            </h6>
                            <p class="card-text mb-2">${mensaje.contenido}</p>
                            <small class="${esPropio ? 'text-white-50' : 'text-muted'}">
                                ${esPropio ? 'Tú' : data.usuario.nombre} - ${fecha}
                            </small>
                        </div>
                    </div>
                `;
                
                container.appendChild(mensajeDiv);
            });
            
            // Scroll al final
            container.scrollTop = container.scrollHeight;
            
            // Prellenar asunto de respuesta
            const ultimoMensaje = data.mensajes[data.mensajes.length - 1];
            const asuntoRespuesta = ultimoMensaje.asunto.startsWith('Re: ') ? 
                ultimoMensaje.asunto : 'Re: ' + ultimoMensaje.asunto;
            document.getElementById('respuesta-asunto').value = asuntoRespuesta;
            
        } else {
            container.innerHTML = '<p class="text-muted text-center">No se encontraron mensajes</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        container.innerHTML = '<p class="text-danger text-center">Error al cargar la conversación</p>';
    });
}

function enviarRespuesta() {
    const form = document.getElementById('responderForm');
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    
    // Debug: log form data
    console.log('Form data being sent:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
    
    // Deshabilitar botón
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    
    // Get CSRF token with fallback
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const csrfValue = csrfToken ? csrfToken.getAttribute('content') : '{{ csrf_token() }}';
    
    fetch('/propietario/responder-mensaje', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfValue
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            // Limpiar formulario
            document.getElementById('respuesta-mensaje').value = '';
            
            // Mostrar éxito
            Swal.fire({
                title: '¡Respuesta enviada!',
                text: 'Tu respuesta ha sido enviada al usuario',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
            
            // Recargar conversación
            const usuarioId = document.getElementById('modal-usuario-id').value;
            const apartamentoId = document.getElementById('modal-apartamento-id').value;
            cargarConversacion(usuarioId, apartamentoId);
            
        } else {
            console.error('Error response:', data);
            Swal.fire({
                title: 'Error',
                text: data.message || 'Error al enviar la respuesta',
                icon: 'error'
            });
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error de conexión al enviar la respuesta',
            icon: 'error'
        });
    })
    .finally(() => {
        // Habilitar botón
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="fas fa-reply"></i> Enviar respuesta';
    });
}
</script>

@endsection
