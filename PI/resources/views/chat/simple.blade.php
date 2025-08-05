@extends('layouts.Plantilla1')

@section('titulo', 'Chat')

@section('Contenido')

@extends('layouts.Plantilla1')

@section('titulo', 'Chat Unificado')

@section('Contenido')

<link rel="stylesheet" href="{{ asset('css/amigos-chat.css') }}">

<div class="container-fluid mt-4">
    <div class="row h-100">
        <!-- Lista de amigos -->
        <div class="col-md-4 col-lg-3">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-users"></i> Amigos
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($amigos->count() > 0)
                        @foreach($amigos as $amigo)
                            <div class="amigo-item" data-amigo-id="{{ $amigo->id }}">
                                @if($amigo->foto_perfil && $amigo->foto_perfil !== 'perfil/default.jpg')
                                    <img src="{{ asset('storage/' . $amigo->foto_perfil) }}" 
                                         alt="Foto de perfil" 
                                         class="rounded-circle me-2" 
                                         width="35" height="35">
                                @else
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                         style="width: 35px; height: 35px; font-size: 0.9rem;">
                                        {{ strtoupper(substr($amigo->nombre, 0, 1)) }}
                                    </div>
                                @endif
                                
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $amigo->nombre }} {{ $amigo->apellido_paterno }}</h6>
                                    <small class="text-muted">{{ $amigo->correo }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-plus fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-3">No tienes amigos para chatear aún.</p>
                            <a href="{{ route('amigos.index') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Agregar Amigos
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card chat-area">
                <div id="chat-placeholder" class="card-body text-center py-5">
                    <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Bienvenido al Chat Unificado</h4>
                    <p class="text-muted">Selecciona un amigo para comenzar a chatear</p>
                    <small class="text-muted">
                        <i class="fas fa-sync-alt"></i> 
                        Sincronizado en tiempo real con la aplicación móvil
                    </small>
                </div>
                
                <div id="chat-content" style="display: none;">
                    <div class="card-header d-flex align-items-center">
                        <div id="chat-amigo-info" class="d-flex align-items-center flex-grow-1">
                            <!-- Se llenará dinámicamente -->
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-secondary" title="Marcar como leído"
                                    onclick="window.UnifiedChatFunctions.markAsRead()">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" 
                                    onclick="window.UnifiedChatFunctions.closeChat()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        <div id="mensajes-container" style="height: 400px; overflow-y: auto; padding: 15px;">
                            <!-- Los mensajes se cargarán aquí -->
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <form id="form-enviar-mensaje" class="d-flex">
                            @csrf
                            <input type="hidden" id="receptor-id" name="receptor_id">
                            <input type="text" 
                                   id="mensaje-input" 
                                   name="mensaje" 
                                   class="form-control me-2" 
                                   placeholder="Escribe tu mensaje..."
                                   maxlength="1000"
                                   required>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Connection Status Indicator -->
<div id="connection-status" class="position-fixed" style="bottom: 20px; left: 20px; z-index: 1000;">
    <div class="badge bg-success">
        <i class="fas fa-wifi"></i> Conectado
    </div>
</div>

<!-- Include the unified chat service -->
<script src="{{ asset('js/unified-chat.js') }}"></script>

<style>
.amigo-item {
    padding: 15px;
    border-bottom: 1px solid #f1f3f4;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
}

.amigo-item:hover {
    background-color: #f8f9fa;
    transform: translateX(3px);
}

.amigo-item.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-left: 4px solid #ffd700;
}

.amigo-item.active .text-muted {
    color: rgba(255,255,255,0.8) !important;
}

.mensaje-propio .mensaje-contenido {
    background-color: #007bff;
    color: white;
}

.mensaje-amigo .mensaje-contenido {
    background-color: #f1f3f4;
    color: #333;
}

.chat-area {
    height: 600px;
}

#mensajes-container::-webkit-scrollbar {
    width: 6px;
}

#mensajes-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#mensajes-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

#mensajes-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.mensaje {
    margin-bottom: 15px;
    animation: fadeInUp 0.3s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mensaje-contenido {
    max-width: 75%;
    padding: 12px 18px;
    border-radius: 20px;
    font-size: 0.95rem;
    line-height: 1.4;
    word-wrap: break-word;
    position: relative;
}

.mensaje-propio .mensaje-contenido {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    margin-left: auto;
    border-bottom-right-radius: 5px;
}

.mensaje-amigo .mensaje-contenido {
    background: white;
    color: #333;
    border: 1px solid #e9ecef;
    border-bottom-left-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.mensaje-tiempo {
    font-size: 0.7rem;
    color: #6c757d;
    margin-top: 5px;
    opacity: 0.8;
}

#connection-status .badge {
    padding: 8px 12px;
    font-size: 0.8rem;
}

.connection-error {
    background-color: #dc3545 !important;
}

.connection-warning {
    background-color: #ffc107 !important;
    color: #000 !important;
}
</style>

<script>
// Enhanced functionality for unified chat
document.addEventListener('DOMContentLoaded', function() {
    // Monitor connection status
    let isConnected = true;
    
    // Update connection status
    function updateConnectionStatus(status) {
        const statusElement = document.getElementById('connection-status');
        const badge = statusElement.querySelector('.badge');
        
        switch(status) {
            case 'connected':
                badge.className = 'badge bg-success';
                badge.innerHTML = '<i class="fas fa-wifi"></i> Conectado';
                break;
            case 'disconnected':
                badge.className = 'badge bg-danger';
                badge.innerHTML = '<i class="fas fa-wifi"></i> Sin conexión';
                break;
            case 'reconnecting':
                badge.className = 'badge bg-warning text-dark';
                badge.innerHTML = '<i class="fas fa-sync fa-spin"></i> Reconectando...';
                break;
        }
    }

    // Monitor network connectivity
    window.addEventListener('online', () => {
        updateConnectionStatus('connected');
        // Restart polling if chat is open
        if (window.UnifiedChatFunctions.currentChatId) {
            window.UnifiedChatFunctions.chatService.startPolling(
                window.UnifiedChatFunctions.currentChatId,
                (newMessages) => window.UnifiedChatFunctions.displayNewMessages(newMessages)
            );
        }
    });

    window.addEventListener('offline', () => {
        updateConnectionStatus('disconnected');
        window.UnifiedChatFunctions.chatService.stopPolling();
    });

    // Add mark as read functionality
    window.UnifiedChatFunctions.markAsRead = async function() {
        if (!this.currentChatId) return;
        
        try {
            await this.chatService.markMessagesAsRead(this.currentChatId);
            console.log('Messages marked as read');
        } catch (error) {
            console.error('Error marking messages as read:', error);
        }
    };

    console.log('Enhanced unified chat initialized');
});
</script>

@endsection

<script>
let chatActivo = null;
let intervaloMensajes = null;
let ultimoMensajeId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Manejar clicks en amigos
    document.querySelectorAll('.amigo-item').forEach(item => {
        item.addEventListener('click', function() {
            const amigoId = this.dataset.amigoId;
            abrirChat(amigoId);
        });
    });
    
    // Manejar envío de mensajes
    document.getElementById('form-enviar-mensaje').addEventListener('submit', function(e) {
        e.preventDefault();
        enviarMensaje();
    });
    
    // Verificar si hay un amigo específico en la URL
    const urlParams = new URLSearchParams(window.location.search);
    const amigoId = urlParams.get('amigo');
    if (amigoId) {
        abrirChat(amigoId);
        // Limpiar la URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }
    
    // Detectar cuando el usuario está escribiendo para pausar las actualizaciones
    const mensajeInput = document.getElementById('mensaje-input');
    let escribiendo = false;
    let tiempoEscribiendo = null;
    
    mensajeInput.addEventListener('input', function() {
        escribiendo = true;
        clearTimeout(tiempoEscribiendo);
        tiempoEscribiendo = setTimeout(() => {
            escribiendo = false;
        }, 2000); // Considerar que dejó de escribir después de 2 segundos de inactividad
    });
    
    // Función para verificar si el usuario está escribiendo
    window.estaEscribiendo = () => escribiendo;
});

function abrirChat(amigoId) {
    if (chatActivo === amigoId) return;
    
    chatActivo = amigoId;
    ultimoMensajeId = null; // Reset al cambiar de chat
    
    // Limpiar intervalo anterior
    if (intervaloMensajes) {
        clearInterval(intervaloMensajes);
    }
    
    // Obtener información del amigo
    fetch(`/chat/amigo/${amigoId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarChat(data.amigo);
                cargarMensajes(amigoId);
                
                // Actualizar mensajes cada 8 segundos, pero solo si no está escribiendo
                intervaloMensajes = setInterval(() => {
                    if (!window.estaEscribiendo()) {
                        cargarMensajesSinInterruption(amigoId);
                    }
                }, 8000);
            }
        })
        .catch(error => console.error('Error:', error));
}

function mostrarChat(amigo) {
    document.getElementById('chat-placeholder').style.display = 'none';
    document.getElementById('chat-content').style.display = 'block';
    document.getElementById('receptor-id').value = amigo.id;
    
    // Mostrar información del amigo en el header
    const amigoInfo = document.getElementById('chat-amigo-info');
    let fotoHtml = '';
    
    if (amigo.foto_perfil && amigo.foto_perfil !== 'perfil/default.jpg') {
        fotoHtml = `<img src="/storage/${amigo.foto_perfil}" alt="Foto de perfil" class="rounded-circle me-2" width="35" height="35">`;
    } else {
        fotoHtml = `<div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">${amigo.nombre.charAt(0).toUpperCase()}</div>`;
    }
    
    amigoInfo.innerHTML = `
        ${fotoHtml}
        <div>
            <h6 class="mb-0">${amigo.nombre} ${amigo.apellido_paterno}</h6>
            <small class="text-muted">${amigo.correo}</small>
        </div>
    `;
}

function cargarMensajes(amigoId) {
    fetch(`/chat/mensajes/${amigoId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarMensajes(data.mensajes, true); // true = permite scroll automático
            }
        })
        .catch(error => console.error('Error:', error));
}

// Nueva función para cargar mensajes sin interrumpir la experiencia del usuario
function cargarMensajesSinInterruption(amigoId) {
    fetch(`/chat/mensajes/${amigoId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Solo actualizar si hay mensajes nuevos
                if (data.mensajes.length > 0) {
                    const ultimoMensaje = data.mensajes[data.mensajes.length - 1];
                    if (ultimoMensajeId !== ultimoMensaje.id) {
                        mostrarMensajes(data.mensajes, false); // false = no forzar scroll
                        ultimoMensajeId = ultimoMensaje.id;
                    }
                }
            }
        })
        .catch(error => console.error('Error:', error));
}

function mostrarMensajes(mensajes, permitirScroll = true) {
    const container = document.getElementById('mensajes-container');
    const estabaAlFinal = container.scrollTop + container.clientHeight >= container.scrollHeight - 10;
    
    // Guardar la posición actual del scroll si el usuario no está al final
    const scrollAnterior = container.scrollTop;
    
    container.innerHTML = '';
    
    mensajes.forEach(mensaje => {
        const esMio = mensaje.es_mio;
        const messageDiv = document.createElement('div');
        messageDiv.className = `mb-3 d-flex ${esMio ? 'justify-content-end' : 'justify-content-start'}`;
        
        messageDiv.innerHTML = `
            <div class="mensaje ${esMio ? 'mensaje-propio' : 'mensaje-amigo'}" style="max-width: 70%;">
                <div class="mensaje-contenido p-2 rounded">
                    ${mensaje.contenido}
                </div>
                <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                    ${new Date(mensaje.created_at).toLocaleString()}
                </small>
            </div>
        `;
        
        container.appendChild(messageDiv);
    });
    
    // Solo hacer scroll automático si:
    // 1. Se permite el scroll (primera carga o envío de mensaje)
    // 2. El usuario estaba al final antes de la actualización
    if (permitirScroll && estabaAlFinal) {
        container.scrollTop = container.scrollHeight;
    } else if (!permitirScroll && !estabaAlFinal) {
        // Mantener la posición anterior si no estaba al final
        container.scrollTop = scrollAnterior;
    }
    
    // Actualizar el ID del último mensaje
    if (mensajes.length > 0) {
        ultimoMensajeId = mensajes[mensajes.length - 1].id;
    }
}

function enviarMensaje() {
    const form = document.getElementById('form-enviar-mensaje');
    const formData = new FormData(form);
    
    fetch('/chat/enviar', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('mensaje-input').value = '';
            // Cargar mensajes inmediatamente después de enviar
            cargarMensajes(chatActivo);
        } else {
            alert('Error al enviar mensaje: ' + (data.error || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión al enviar mensaje');
    });
}

function cerrarChat() {
    chatActivo = null;
    
    if (intervaloMensajes) {
        clearInterval(intervaloMensajes);
        intervaloMensajes = null;
    }
    
    document.getElementById('chat-content').style.display = 'none';
    document.getElementById('chat-placeholder').style.display = 'block';
    document.getElementById('mensaje-input').value = '';
}
</script>

<style>
.amigo-item:hover {
    background-color: #f8f9fa;
}

.amigo-item.activo {
    background-color: #e3f2fd;
    border-left: 4px solid #2196f3;
}

.mensaje-propio .mensaje-contenido {
    background-color: #007bff;
    color: white;
}

.mensaje-amigo .mensaje-contenido {
    background-color: #f1f3f4;
    color: #333;
}

.chat-area {
    height: 600px;
}

#mensajes-container::-webkit-scrollbar {
    width: 6px;
}

#mensajes-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#mensajes-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

#mensajes-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>

@endsection
