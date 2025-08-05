@extends('layouts.Plantilla1')

@section('titulo', 'Buscar Amigos')

@section('Contenido')

    <link rel="stylesheet" href="{{ asset('css/amigos-chat.css') }}">
    <main class="d-flex flex-column min-vh-100">
        <div class="container mt-4">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="fas fa-search"></i> Buscar Amigos</h2>
                        <a href="{{ route('amigos.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver a Mis Amigos
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Formulario de búsqueda -->
                    <div class="search-container">
                        <form method="GET" action="{{ route('amigos.buscar') }}">
                            <div class="input-group">
                                <input type="text" name="busqueda" class="form-control search-input"
                                    placeholder="Buscar por nombre, apellido o correo..." value="{{ $busqueda ?? '' }}">
                                <button type="submit" class="btn btn-search">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Resultados de búsqueda -->
                    @if(isset($usuarios))
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-users"></i>
                                    Resultados de búsqueda
                                    @if($busqueda)
                                        para "{{ $busqueda }}"
                                    @endif
                                    ({{ $usuarios->count() }} encontrados)
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($usuarios->count() > 0)
                                    <div class="row">
                                        @foreach($usuarios as $usuario)
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div class="card usuario-card h-100">
                                                    <div class="card-body text-center">
                                                        @if($usuario->foto_perfil && $usuario->foto_perfil !== 'perfil/default.jpg')
                                                            <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Foto de perfil"
                                                                class="rounded-circle mb-3" width="80" height="80">
                                                        @else
                                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                                                                style="width: 80px; height: 80px; font-size: 1.5rem;">
                                                                {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                        <h6 class="card-title">{{ $usuario->nombre }} {{ $usuario->apellido_paterno }}
                                                        </h6>
                                                        <p class="card-text text-muted small">{{ $usuario->correo }}</p>

                                                        @if($usuario->es_amigo)
                                                            <span class="badge badge-status bg-success mb-2">
                                                                <i class="fas fa-check"></i> Ya son amigos
                                                            </span>
                                                            <br>
                                                            <a href="{{ route('chat.index') }}" class="btn btn-primary btn-sm"
                                                                onclick="abrirChatAmigo({{ $usuario->id }}); return false;">
                                                                <i class="fas fa-comment"></i> Chatear
                                                            </a>
                                                        @elseif($usuario->solicitud_pendiente)
                                                            <span class="badge badge-status bg-warning">
                                                                <i class="fas fa-clock"></i> Solicitud enviada
                                                            </span>
                                                        @else
                                                            <form method="POST" action="{{ route('amigos.enviar-solicitud') }}">
                                                                @csrf
                                                                <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">
                                                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                                                    <i class="fas fa-user-plus"></i> Agregar Amigo
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No se encontraron usuarios</h5>
                                        @if($busqueda)
                                            <p class="text-muted">No hay usuarios que coincidan con "{{ $busqueda }}"</p>
                                        @else
                                            <p class="text-muted">Ingresa un término de búsqueda para encontrar usuarios</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Mensaje inicial cuando no hay búsqueda -->
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Buscar Nuevos Amigos</h5>
                                <p class="text-muted">Utiliza el formulario de arriba para buscar usuarios por nombre, apellido
                                    o correo electrónico.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <script>
        function abrirChatAmigo(amigoId) {
            // Redirigir al chat y abrir la conversación específica
            window.location.href = '/chat?amigo=' + amigoId;
        }
    </script>

@endsection