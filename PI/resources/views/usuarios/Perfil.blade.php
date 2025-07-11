@extends('layouts.Plantilla1')
@section('titulo', 'Perfil')
@section('Contenido')

<link rel="stylesheet" href="{{asset('css/perfil.css')}}">

<main class="min-vh-100 bg-light">
    <div class="container py-5">
        <!-- Success/Error Messages -->
        @if(session('Exito'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('Exito') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('Fallo'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('Fallo') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <h2 class="text-dark mb-0">
                        <i class="fas fa-user-circle me-2"></i>Mi Perfil
                    </h2>
                </div>
            </div>
        </div>

        <div class="row align-items-start g-4">
            <!-- Profile Picture Section -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center p-4">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ Storage::url($usuario->foto_perfil) }}" 
                                 alt="Foto de perfil" 
                                 class="avatar-circular border border-3 border-white shadow">
                            <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2">
                                <i class="fas fa-check text-white" style="font-size: 0.8rem;"></i>
                            </span>
                        </div>
                        <h5 class="mb-1">{{ $usuario->nombre ?? 'Usuario' }}</h5>
                        <p class="text-muted mb-0">
                            <i class="fas fa-clock me-1"></i>
                            Miembro desde {{ $usuario->created_at ? $usuario->created_at->format('M Y') : '?    ' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Profile Information Section -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                Información Personal
                            </h4>
                            <div class="btn-group" role="group">
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editarPerfilModal">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </button>
                                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-sign-out-alt me-1"></i>Cerrar sesión
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <i class="fas fa-user text-primary me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Nombre completo</small>
                                        <strong>{{ $usuario->nombre ?? 'No disponible'}} 
                                        {{ $usuario->apellido_paterno ?? ''}} 
                                        {{ $usuario->apellido_materno ?? ''}}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <i class="fas fa-venus-mars text-primary me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Género</small>
                                        <strong>
                                            @if($usuario->genero == 'masculino')
                                                Masculino
                                            @elseif($usuario->genero == 'femenino')
                                                Femenino
                                            @elseif($usuario->genero == 'otro')
                                                Otro
                                            @else
                                                No especificado
                                            @endif
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <i class="fas fa-phone text-primary me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Teléfono</small>
                                        <strong>{{ $usuario->telefono ?? 'No disponible' }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <i class="fas fa-envelope text-primary me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Correo electrónico</small>
                                        <strong>{{ $usuario->correo }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="editarPerfilModal" tabindex="-1" aria-labelledby="editarPerfilModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarPerfilModalLabel">Editar Perfil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal -->
                        <form action="{{ route('RutaActualizarPerfil') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="col-form-label">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $usuario->nombre }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido_paterno" class="col-form-label">Apellido Paterno:</label>
                                <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="{{ $usuario->apellido_paterno }}">
                            </div>
                            <div class="mb-3">
                                <label for="apellido_materno" class="col-form-label">Apellido Materno:</label>
                                <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" value="{{ $usuario->apellido_materno }}">
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="col-form-label">Correo:</label>
                                <input type="email" class="form-control" id="correo" name="correo" value="{{ $usuario->correo }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="col-form-label">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $usuario->telefono }}">
                            </div>
                            <div class="mb-3">
                                <label for="genero" class="col-form-label">Género:</label>
                                <select class="form-select" id="genero" name="genero">
                                    <option value="">Selecciona tu género</option>
                                    <option value="masculino" {{ $usuario->genero == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ $usuario->genero == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="otro" {{ $usuario->genero == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-outline-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        </div>

    </main>

    <!-- JavaScript to close modal on successful submission -->
    <script>
        // Close modal when page loads with success message
        @if(session('Exito'))
            document.addEventListener('DOMContentLoaded', function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById('editarPerfilModal'));
                if (modal) {
                    modal.hide();
                }
            });
        @endif
    </script>

    <!-- Importante para que no se aparesca el mensaje de bienvenida cada vez -->
    

@endsection