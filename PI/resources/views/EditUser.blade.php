@extends('layouts.plantilla_admins')
@section('titulo', 'Editar Usuario')
@section('Contenido')

<style>
    .edit-form-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .form-section {
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-hover-effect {
        transition: all 0.3s ease;
    }
    
    .btn-hover-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .profile-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .avatar-upload {
        position: relative;
        display: inline-block;
    }
    
    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255,255,255,0.3);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .avatar-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: bold;
        border: 4px solid rgba(255,255,255,0.3);
    }
</style>

@session('exito')
    <script>
        Swal.fire({
            title: "Edición exitosa",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession

@session('Fallo')
    <script>
        Swal.fire({
            title: "Error",
            text: "{{$value}}",
            icon: "error"
        });
    </script>
@endsession

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6><i class="bi bi-exclamation-triangle"></i> Errores de validación:</h6>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<main class="container-fluid p-0" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="container py-5">
        @foreach($registro as $datos)
        <div class="edit-form-container">
            <!-- Header Section with Profile -->
            <div class="profile-section p-4 text-center">
                <div class="avatar-upload mb-3">
                    @if($datos->foto_perfil && $datos->foto_perfil !== 'perfil/default.jpg')
                        <img src="{{ asset('storage/' . $datos->foto_perfil) }}" 
                             alt="Foto de perfil" 
                             class="avatar-preview">
                    @else
                        <div class="avatar-placeholder">
                            {{ strtoupper(substr($datos->nombre, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <h3 class="mb-1">{{ $datos->nombre }} {{ $datos->apellido_paterno }}</h3>
                <p class="mb-0 opacity-75">{{ $datos->correo }}</p>
                <small class="opacity-75">ID: {{ $datos->id }}</small>
            </div>

            <!-- Form Section -->
            <div class="p-4">
                <h4 class="mb-4 text-primary">
                    <i class="bi bi-person-gear"></i> Editar Información del Usuario
                </h4>

                <form method="POST" action="{{route('EnvioActualizarUsuario',[$datos->id])}}" id="Edicion_registro" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Personal Information Section -->
                        <div class="col-md-6">
                            <div class="form-section mb-4">
                                <h5 class="text-secondary mb-3">
                                    <i class="bi bi-person-badge"></i> Información Personal
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">
                                        <i class="bi bi-person-fill text-primary"></i> Nombre
                                    </label>
                                    <input type="text" class="form-control" name="nombre" id="nombre"
                                           placeholder="Ingresa el nombre completo"
                                           value="{{$datos->nombre}}" required>
                                    <small class="text-danger">{{$errors->first('nombre')}}</small>
                                </div>

                                <div class="mb-3">
                                    <label for="apellido_p" class="form-label">
                                        <i class="bi bi-person-fill text-primary"></i> Apellido Paterno
                                    </label>
                                    <input type="text" class="form-control" name="apellido_p" id="apellido_p"
                                           placeholder="Ingresa el apellido paterno"
                                           value="{{$datos->apellido_paterno}}" required>
                                    <small class="text-danger">{{$errors->first('apellido_p')}}</small>
                                </div>

                                <div class="mb-3">
                                    <label for="apellido_m" class="form-label">
                                        <i class="bi bi-person-fill text-primary"></i> Apellido Materno
                                    </label>
                                    <input type="text" class="form-control" name="apellido_m" id="apellido_m"
                                           placeholder="Ingresa el apellido materno"
                                           value="{{$datos->apellido_materno}}" required>
                                    <small class="text-danger">{{$errors->first('apellido_m')}}</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-gender-ambiguous text-primary"></i> Género
                                    </label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="genero" value="masculino" id="masculino"
                                                   {{ $datos->genero == 'masculino' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="masculino">
                                                <i class="bi bi-person-standing"></i> Masculino
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="genero" value="femenino" id="femenino"
                                                   {{ $datos->genero == 'femenino' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="femenino">
                                                <i class="bi bi-person-standing-dress"></i> Femenino
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="genero" value="otro" id="otro"
                                                   {{ $datos->genero == 'otro' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="otro">
                                                <i class="bi bi-person"></i> Otro
                                            </label>
                                        </div>
                                    </div>
                                    <small class="text-danger">{{$errors->first('genero')}}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Contact & Account Information Section -->
                        <div class="col-md-6">
                            <div class="form-section mb-4">
                                <h5 class="text-secondary mb-3">
                                    <i class="bi bi-telephone"></i> Información de Contacto
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="correo" class="form-label">
                                        <i class="bi bi-envelope-fill text-primary"></i> Correo Electrónico
                                    </label>
                                    <input type="email" class="form-control" name="correo" id="correo"
                                           value="{{$datos->correo}}" readonly style="background-color: #f8f9fa;">
                                    <small class="text-muted">El correo no se puede modificar</small>
                                </div>

                                <div class="mb-3">
                                    <label for="telefono" class="form-label">
                                        <i class="bi bi-telephone-fill text-primary"></i> Teléfono
                                    </label>
                                    <input type="tel" class="form-control" name="telefono" id="telefono"
                                           placeholder="Ingresa el número de teléfono"
                                           value="{{$datos->telefono}}">
                                    <small class="text-danger">{{$errors->first('telefono')}}</small>
                                </div>
                            </div>

                            <div class="form-section mb-4">
                                <h5 class="text-secondary mb-3">
                                    <i class="bi bi-shield-check"></i> Configuración de Cuenta
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="rol" class="form-label">
                                        <i class="bi bi-person-badge-fill text-primary"></i> Rol del Usuario
                                    </label>
                                    <select name="rol" id="rol" class="form-select">
                                        <option value="usuario" {{ $datos->rol == 'usuario' ? 'selected' : '' }}>
                                            <i class="bi bi-person"></i> Usuario
                                        </option>
                                        <option value="admin" {{ $datos->rol == 'admin' ? 'selected' : '' }}>
                                            <i class="bi bi-shield-check"></i> Administrador
                                        </option>
                                    </select>
                                    <small class="text-danger">{{$errors->first('rol')}}</small>
                                </div>

                                <div class="mb-3">
                                    <label for="foto_perfil" class="form-label">
                                        <i class="bi bi-camera-fill text-primary"></i> Foto de Perfil
                                    </label>
                                    <input type="file" class="form-control" name="foto_perfil" id="foto_perfil"
                                           accept="image/*">
                                    <small class="text-muted">Formatos permitidos: JPG, PNG, GIF. Máximo 2MB.</small>
                                    <small class="text-danger">{{$errors->first('foto_perfil')}}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="border-top pt-4 mt-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('RutaAdminUsers') }}" class="btn btn-secondary w-100 py-3 btn-hover-effect" style="border-radius: 15px;">
                                    <i class="bi bi-arrow-left"></i> Cancelar y Volver
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <button type="submit" id="Edicion" class="btn btn-success w-100 py-3 btn-hover-effect" style="border-radius: 15px;">
                                    <i class="bi bi-check-circle-fill"></i> Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" name="email" value="{{$datos->correo}}">
                </form>
            </div>
        </div>
        @endforeach
    </div>
</main>

<script>
    // Preview uploaded image
    document.getElementById('foto_perfil').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.querySelector('.avatar-preview, .avatar-placeholder');
                if (preview) {
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        // Replace placeholder div with img
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'avatar-preview';
                        img.alt = 'Vista previa';
                        preview.parentNode.replaceChild(img, preview);
                    }
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Form submission confirmation
    document.getElementById('Edicion').addEventListener('click', function(event) {
        event.preventDefault(); 
        
        // Debug: Log form data
        const formData = new FormData(document.getElementById('Edicion_registro'));
        console.log('Form data being sent:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        
        Swal.fire({
            title: '¿Confirmar actualización?',
            text: 'Los cambios se guardarán en el sistema.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            cancelButtonText: 'Cancelar',
            confirmButtonText: '<i class="bi bi-check-circle"></i> Sí, actualizar',
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Actualizando...',
                    text: 'Por favor espera mientras se guardan los cambios.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                document.getElementById('Edicion_registro').submit(); 
            }
        });
    });
</script>

@endsection