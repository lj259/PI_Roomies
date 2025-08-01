@extends('layouts.Plantilla1')

@section('titulo', 'Chat con ' . $amigo->nombre)

@section('Contenido')

<link rel="stylesheet" href="{{ asset('css/amigos-chat.css') }}">
<style>
.chat-container {
    height: 70vh;
    display: flex;
    flex-direction: column;
}

.amigos-list {
    max-height: 70vh;
    overflow-y: auto;
}

.amigo-item {
    padding: 12px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: background-color 0.2s;
}

.amigo-item:hover {
    background-color: #f8f9fa;
}

.amigo-item.active {
    background-color: #e3f2fd;
    border-left: 4px solid #2196f3;
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
    background-color: #f8f9fa;
    max-height: 400px;
}

.mensaje {
    margin-bottom: 1rem;
}

.mensaje-propio {
    text-align: right;
}

.mensaje-ajeno {
    text-align: left;
}

.mensaje-contenido {
    display: inline-block;
    max-width: 70%;
    padding: 10px 15px;
    border-radius: 18px;
    word-wrap: break-word;
}

.mensaje-propio .mensaje-contenido {
    background-color: #2196f3;
    color: white;
}

.mensaje-ajeno .mensaje-contenido {
    background-color: white;
    color: #333;
    border: 1px solid #ddd;
}

.mensaje-tiempo {
    font-size: 0.75rem;
    color: #666;
    margin-top: 4px;
}

.chat-input-container {
    padding: 1rem;
    border-top: 1px solid #ddd;
    background-color: white;
}
</style>
@endsection

@section('Contenido')
<div class="container-fluid mt-4">
    <div class="row h-100">
        <!-- Lista de amigos -->
        <div class="col-md-4 col-lg-3">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-users"></i> Amigos</h6>
                    <a href="{{ route('amigos.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-user-plus"></i>
                    </a>
                </div>
                <div class="amigos-list">
                    @foreach($amigos as $amigoItem)
                        <div class="amigo-item {{ $amigoItem->id == $amigo->id ? 'active' : '' }}" 
                             onclick="location.href='{{ route('chat.conversacion', $amigoItem->id) }}'">
                            <div class="d-flex align-items-center">
                                @if($amigoItem->foto_perfil && $amigoItem->foto_perfil !== 'perfil/default.jpg')
                                    <img src="{{ asset('storage/' . $amigoItem->foto_perfil) }}" 
                                         alt="Foto de perfil" 
                                         class="rounded-circle me-3" 
                                         width="40" height="40">
                                @else
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                         style="width: 40px; height: 40px; font-size: 0.9rem;">
                                        {{ strtoupper(substr($amigoItem->nombre, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 small">{{ $amigoItem->nombre }} {{ $amigoItem->apellido_paterno }}</h6>
                                    <small class="text-muted">{{ $amigoItem->correo }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Área de chat -->
        <div class="col-md-8 col-lg-9">
            <div class="card h-100">
                <!-- Header del chat -->
                <div class="card-header d-flex align-items-center">
                    @if($amigo->foto_perfil && $amigo->foto_perfil !== 'perfil/default.jpg')
                        <img src="{{ asset('storage/' . $amigo->foto_perfil) }}" 
                             alt="Foto de perfil" 
                             class="rounded-circle me-3" 
                             width="40" height="40">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                             style="width: 40px; height: 40px;">
                            {{ strtoupper(substr($amigo->nombre, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h6 class="mb-0">{{ $amigo->nombre }} {{ $amigo->apellido_paterno }}</h6>
                        <small class="text-muted">{{ $amigo->correo }}</small>
                    </div>
                </div>

                <!-- Mensajes -->
                <div class="chat-messages" id="chatMessages">
                    @foreach($mensajes as $mensaje)
                        <div class="mensaje {{ $mensaje->emisor_id == Auth::id() ? 'mensaje-propio' : 'mensaje-ajeno' }}">
                            <div class="mensaje-contenido">
                                {{ $mensaje->contenido }}
                            </div>
                            <div class="mensaje-tiempo">
                                {{ $mensaje->created_at->format('H:i') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Input de mensaje -->
                <div class="chat-input-container">
                    <form id="chatForm">
                        @csrf
                        <div class="input-group">
                            <input type="text" 
                                   id="mensajeInput" 
                                   class="form-control chat-input" 
                                   placeholder="Escribe un mensaje..."
                                   maxlength="1000"
                                   required>
                            <button type="submit" class="btn btn-enviar">
                                <i class="fas fa-paper-plane"></i> Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const amigoId = {{ $amigo->id }};
    const authUserId = {{ Auth::id() }};
    
    // Enviar mensaje
    $('#chatForm').on('submit', function(e) {
        e.preventDefault();
        
        const contenido = $('#mensajeInput').val().trim();
        if (!contenido) return;
        
        $.ajax({
            url: '/chat/enviar-mensaje',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                receptor_id: amigoId,
                contenido: contenido
            },
            success: function(response) {
                if (response.success) {
                    $('#mensajeInput').val('');
                    cargarMensajes();
                }
            },
            error: function(xhr) {
                alert('Error al enviar el mensaje');
            }
        });
    });
    
    // Cargar mensajes
    function cargarMensajes() {
        $.ajax({
            url: '/chat/mensajes/' + amigoId,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const chatMessages = $('#chatMessages');
                    chatMessages.empty();
                    
                    response.mensajes.forEach(function(mensaje) {
                        const esPropio = mensaje.emisor_id == authUserId;
                        const claseEstilo = esPropio ? 'mensaje-propio' : 'mensaje-ajeno';
                        
                        const fecha = new Date(mensaje.created_at);
                        const tiempo = fecha.toLocaleTimeString('es-ES', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        
                        const mensajeHtml = `
                            <div class="mensaje ${claseEstilo}">
                                <div class="mensaje-contenido">
                                    ${mensaje.contenido}
                                </div>
                                <div class="mensaje-tiempo">
                                    ${tiempo}
                                </div>
                            </div>
                        `;
                        
                        chatMessages.append(mensajeHtml);
                    });
                    
                    // Scroll al final
                    chatMessages.scrollTop(chatMessages[0].scrollHeight);
                }
            }
        });
    }
    
    // Cargar mensajes cada 3 segundos
    setInterval(cargarMensajes, 3000);
    
    // Scroll inicial al final
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
    
    // Focus en el input de mensaje
    $('#mensajeInput').focus();
});
</script>

@endsection
