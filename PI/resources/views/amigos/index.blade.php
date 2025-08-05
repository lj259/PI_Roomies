@extends('layouts.Plantilla1')

@section('titulo', 'Mis Amigos')

@section('Contenido')

    <link rel="stylesheet" href="{{ asset('css/amigos-chat.css') }}">


<!-- Ensure Bootstrap JS is loaded -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <main class="d-flex flex-column min-vh-100">
        <div class="container mt-4">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="fas fa-users"></i> Mis Amigos</h2>
                        <a href="{{ route('amigos.buscar') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Buscar Amigos
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

                    <!-- Solicitudes Pendientes -->
                    @if($solicitudesPendientes && $solicitudesPendientes->count() > 0)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-bell"></i> Solicitudes de Amistad</h5>
                            </div>
                            <div class="card-body">
                                @foreach($solicitudesPendientes as $solicitud)
                                    <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                                        <div class="d-flex align-items-center">
                                            @if($solicitud->usuario1->foto_perfil && $solicitud->usuario1->foto_perfil !== 'perfil/default.jpg')
                                                <img src="{{ asset('storage/' . $solicitud->usuario1->foto_perfil) }}"
                                                    alt="Foto de perfil" class="rounded-circle me-3" width="50" height="50">
                                            @else
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                                    style="width: 50px; height: 50px;">
                                                    {{ strtoupper(substr($solicitud->usuario1->nombre, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $solicitud->usuario1->nombre }}
                                                    {{ $solicitud->usuario1->apellido_paterno }}</h6>
                                                <small class="text-muted">{{ $solicitud->usuario1->correo }}</small>
                                            </div>
                                        </div>
                                        <div>
                                            <form method="POST" action="{{ route('amigos.responder') }}" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">
                                                <input type="hidden" name="accion" value="aceptar">
                                                <button type="submit" class="btn btn-success btn-sm me-2">
                                                    <i class="fas fa-check"></i> Aceptar
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('amigos.responder') }}" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">
                                                <input type="hidden" name="accion" value="rechazar">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i> Rechazar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Lista de Amigos -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-users"></i> Mis Amigos ({{ $amigos ? $amigos->count() : 0 }})
                            </h5>
                            <a href="{{ route('chat.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-comments"></i> Ir al Chat
                            </a>
                        </div>
                        <div class="card-body">
                            @if($amigos && $amigos->count() > 0)
                                <div class="row">
                                    @foreach($amigos as $amigo)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card amigo-card h-100">
                                                <div class="card-body text-center">
                                                    <div class="avatar-status">
                                                        @if($amigo->foto_perfil && $amigo->foto_perfil !== 'perfil/default.jpg')
                                                            <img src="{{ asset('storage/' . $amigo->foto_perfil) }}"
                                                                alt="Foto de perfil" class="rounded-circle mb-3" width="80" height="80">
                                                        @else
                                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                                                                style="width: 80px; height: 80px; font-size: 1.5rem;">
                                                                {{ strtoupper(substr($amigo->nombre, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                @endif
                                            </div>
                                            <h6 class="card-title">{{ $amigo->nombre }} {{ $amigo->apellido_paterno }}</h6>
                                            <p class="card-text text-muted small">{{ $amigo->correo }}</p>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('chat.index') }}" 
                                                   class="btn btn-primary btn-sm"
                                                   onclick="abrirChatAmigo({{ $amigo->id }}); return false;">
                                                    <i class="fas fa-comment"></i> Chat
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-outline-danger btn-sm"
                                                        onclick="eliminarAmigoDirecto({{ $amigo->id }}, '{{ $amigo->nombre }} {{ $amigo->apellido_paterno }}')">
                                                    <i class="fas fa-user-minus"></i> Eliminar
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No tienes amigos aún</h5>
                                    <p class="text-muted">¡Busca personas y envía solicitudes de amistad!</p>
                                    <a href="{{ route('amigos.buscar') }}" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Buscar Amigos
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>




<script>
function eliminarAmigoDirecto(amigoId, nombreAmigo) {
    // Use SweetAlert2 for confirmation
    Swal.fire({
        title: '¿Eliminar amigo?',
        text: `¿Estás seguro que deseas eliminar a ${nombreAmigo} de tu lista de amigos? Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading message
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Eliminando...';
            button.disabled = true;
            
            // Make the AJAX request
            fetch(`/amigos/${amigoId}/eliminar`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success message with SweetAlert2
                    Swal.fire({
                        title: '¡Eliminado!',
                        text: data.message || `${nombreAmigo} ha sido eliminado de tu lista de amigos.`,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    
                    // Remove the friend card from the DOM
                    const friendCard = button.closest('.col-md-6');
                    if (friendCard) {
                        // Add fade out animation
                        friendCard.style.transition = 'all 0.3s ease';
                        friendCard.style.opacity = '0';
                        friendCard.style.transform = 'scale(0.8)';
                        
                        setTimeout(() => {
                            friendCard.remove();
                            
                            // Update the counter in the header
                            const counterElement = document.querySelector('.card-header h5');
                            if (counterElement) {
                                const currentText = counterElement.textContent;
                                const currentCount = parseInt(currentText.match(/\((\d+)\)/)[1]);
                                const newCount = currentCount - 1;
                                counterElement.innerHTML = `<i class="fas fa-users"></i> Mis Amigos (${newCount})`;
                                
                                // If no friends left, show the empty state
                                if (newCount === 0) {
                                    const cardBody = document.querySelector('.card-body .row');
                                    if (cardBody) {
                                        cardBody.innerHTML = `
                                            <div class="text-center py-5">
                                                <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No tienes amigos aún</h5>
                                                <p class="text-muted">¡Busca personas y envía solicitudes de amistad!</p>
                                                <a href="/amigos/buscar" class="btn btn-primary">
                                                    <i class="fas fa-search"></i> Buscar Amigos
                                                </a>
                                            </div>
                                        `;
                                    }
                                }
                            }
                        }, 300);
                    }
                } else {
                    // Reset button state
                    button.innerHTML = originalText;
                    button.disabled = false;
                    
                    // Show error message with SweetAlert2
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al eliminar amigo: ' + (data.message || 'Error desconocido'),
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                }
            })
            .catch(error => {
                // Reset button state
                button.innerHTML = originalText;
                button.disabled = false;
                
                console.error('Error:', error);
                
                // Show connection error with SweetAlert2
                Swal.fire({
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor. Por favor, intenta nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'Reintentar'
                });
            });
        }
    });
}

function abrirChatAmigo(amigoId) {
    // Redirect to chat and open specific conversation
    window.location.href = '/chat?amigo=' + amigoId;
}
</script>

        <!-- Modal de confirmación para eliminar amigo 
        <div class="modal fade" id="confirmarEliminacionModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que quieres eliminar a <strong id="nombreAmigo"></strong> de tus amigos?</p>
                        <p class="text-muted small">Esta acción no se puede deshacer.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form id="formEliminarAmigo" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar Amigo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function confirmarEliminacion(amigoId, nombreAmigo) {
            document.getElementById('nombreAmigo').textContent = nombreAmigo;
            document.getElementById('formEliminarAmigo').action = '/amigos/' + amigoId + '/eliminar';

            var modal = new bootstrap.Modal(document.getElementById('confirmarEliminacionModal'));
            modal.show();
        }

        function abrirChatAmigo(amigoId) {
            // Redirigir al chat y abrir la conversación específica
            window.location.href = '/chat?amigo=' + amigoId;
        }
    </script> -->


@endsection