@extends('layouts.Plantilla1')

@section('titulo', 'Chat')

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
                    @if($amigos->count() > 0)
                        @foreach($amigos as $amigo)
                            <div class="amigo-item" onclick="location.href='{{ route('chat.conversacion', $amigo->id) }}'">
                                <div class="d-flex align-items-center">
                                    @if($amigo->foto_perfil && $amigo->foto_perfil !== 'perfil/default.jpg')
                                        <img src="{{ asset('storage/' . $amigo->foto_perfil) }}" 
                                             alt="Foto de perfil" 
                                             class="rounded-circle me-3" 
                                             width="40" height="40">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                             style="width: 40px; height: 40px; font-size: 0.9rem;">
                                            {{ strtoupper(substr($amigo->nombre, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 small">{{ $amigo->nombre }} {{ $amigo->apellido_paterno }}</h6>
                                        <small class="text-muted">{{ $amigo->correo }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-3 text-center">
                            <i class="fas fa-user-friends fa-2x text-muted mb-2"></i>
                            <p class="text-muted small mb-2">No tienes amigos aún</p>
                            <a href="{{ route('amigos.index') }}" class="btn btn-primary btn-sm mt-2">
                                Agregar Amigos
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Área de bienvenida -->
        <div class="col-md-8 col-lg-9 d-flex align-items-center justify-content-center">
            <div class="text-center">
                <i class="fas fa-comments fa-4x text-muted mb-4"></i>
                <h3 class="text-muted">Bienvenido al Chat</h3>
                <p class="text-muted mb-4">Selecciona un amigo de la lista para comenzar a chatear</p>
                @if($amigos->count() == 0)
                    <a href="{{ route('amigos.index') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Agregar Amigos
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
