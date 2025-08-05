@extends('layouts.plantilla_admins')
@section('titulo','Registrar Usuario')
@section('Contenido')

<style>
    .registration-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: none;
    }
    
    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .form-header h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .form-header p {
        opacity: 0.9;
        margin-bottom: 0;
    }
    
    .form-body {
        padding: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    
    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }
    
    .form-control:focus {
        border-color: #667eea;
        background-color: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }
    
    .form-select:focus {
        border-color: #667eea;
        background-color: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .input-group {
        position: relative;
    }
    
    .input-group-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        z-index: 5;
    }
    
    .input-group .form-control {
        padding-left: 3rem;
    }
    
    .btn-register {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
    }
    
    .btn-register:hover {
        background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(72, 187, 120, 0.4);
        color: white;
    }
    
    .btn-cancel {
        background: #e2e8f0;
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        color: #64748b;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #cbd5e0;
        color: #475569;
        transform: translateY(-2px);
    }
    
    .error-text {
        color: #e53e3e;
        font-size: 0.85rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }
    
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .form-section:last-child {
        border-bottom: none;
    }
    
    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 0.5rem;
        color: #667eea;
    }
    
    .required {
        color: #e53e3e;
        margin-left: 0.25rem;
    }
    
    .form-help {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 0.25rem;
    }
    
    @media (max-width: 768px) {
        .form-header h2 {
            font-size: 1.5rem;
        }
        
        .form-body {
            padding: 1.5rem;
        }
        
        .btn-register,
        .btn-cancel {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>

@session('Exito')
    <script>
        Swal.fire({
            title: "¡Usuario Registrado!",
            text: '{{$value}}',
            icon: "success",
            confirmButtonColor: "#667eea"
        });
    </script>
@endsession

<div class="registration-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="form-card">
                    <div class="form-header">
                        <h2><i class="bi bi-person-plus-fill me-2"></i>Registrar Nuevo Usuario</h2>
                        <p>Completa la información para crear una nueva cuenta</p>
                    </div>
                    
                    <div class="form-body">
                        <form action="{{ route('EnvioRegistroUsuario') }}" method="POST" id="registrationForm">
                            @csrf
                            
                            <!-- Información Personal -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="bi bi-person-circle"></i>
                                    Información Personal
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre" class="form-label">
                                                Nombre <span class="required">*</span>
                                            </label>
                                            <div class="input-group">
                                                <i class="bi bi-person input-group-icon"></i>
                                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                                       placeholder="Ingrese el nombre" value="{{ old('nombre') }}" required>
                                            </div>
                                            @error('nombre')
                                                <div class="error-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                                            <div class="input-group">
                                                <i class="bi bi-person input-group-icon"></i>
                                                <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" 
                                                       placeholder="Apellido paterno" value="{{ old('apellido_paterno') }}">
                                            </div>
                                            @error('apellido_paterno')
                                                <div class="error-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apellido_materno" class="form-label">Apellido Materno</label>
                                            <div class="input-group">
                                                <i class="bi bi-person input-group-icon"></i>
                                                <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" 
                                                       placeholder="Apellido materno" value="{{ old('apellido_materno') }}">
                                            </div>
                                            @error('apellido_materno')
                                                <div class="error-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="genero" class="form-label">Género</label>
                                            <select class="form-select" id="genero" name="genero">
                                                <option value="">Seleccionar género</option>
                                                <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                                <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                                <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                                            </select>
                                            @error('genero')
                                                <div class="error-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Información de Contacto -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="bi bi-envelope-at"></i>
                                    Información de Contacto
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="correo" class="form-label">
                                                Correo Electrónico <span class="required">*</span>
                                            </label>
                                            <div class="input-group">
                                                <i class="bi bi-envelope input-group-icon"></i>
                                                <input type="email" class="form-control" id="correo" name="correo" 
                                                       placeholder="usuario@ejemplo.com" value="{{ old('correo') }}" required>
                                            </div>
                                            <div class="form-help">Este será su nombre de usuario para iniciar sesión</div>
                                            @error('correo')
                                                <div class="error-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <div class="input-group">
                                                <i class="bi bi-telephone input-group-icon"></i>
                                                <input type="tel" class="form-control" id="telefono" name="telefono" 
                                                       placeholder="123-456-7890" value="{{ old('telefono') }}">
                                            </div>
                                            @error('telefono')
                                                <div class="error-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Configuración de Cuenta -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="bi bi-shield-check"></i>
                                    Configuración de Cuenta
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contraseña" class="form-label">
                                                Contraseña <span class="required">*</span>
                                            </label>
                                            <div class="input-group">
                                                <i class="bi bi-lock input-group-icon"></i>
                                                <input type="password" class="form-control" id="contraseña" name="contraseña" 
                                                       placeholder="Mínimo 8 caracteres" required>
                                            </div>
                                            <div class="form-help">La contraseña debe tener al menos 8 caracteres</div>
                                            @error('contraseña')
                                                <div class="error-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rol" class="form-label">
                                                Rol del Usuario <span class="required">*</span>
                                            </label>
                                            <select class="form-select" id="rol" name="rol" required>
                                                <option value="">Seleccionar rol</option>
                                                <option value="usuario" {{ old('rol') == 'usuario' ? 'selected' : '' }}>Usuario</option>
                                                <option value="propietario" {{ old('rol') == 'propietario' ? 'selected' : '' }}>Propietario</option>
                                                <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                            </select>
                                            <div class="form-help">Define los permisos del usuario en el sistema</div>
                                            @error('rol')
                                                <div class="error-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botones de Acción -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <button type="submit" class="btn btn-register w-100">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Registrar Usuario
                                    </button>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('RutaAdminUsers') }}" class="btn btn-cancel w-100">
                                        <i class="bi bi-x-circle me-2"></i>
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        const form = document.getElementById('registrationForm');
        const requiredFields = form.querySelectorAll('[required]');
        
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    title: 'Campos Requeridos',
                    text: 'Por favor completa todos los campos obligatorios',
                    icon: 'warning',
                    confirmButtonColor: '#667eea'
                });
            }
        });
        
        // Real-time validation
        requiredFields.forEach(field => {
            field.addEventListener('blur', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
        
        // Email validation
        const emailField = document.getElementById('correo');
        emailField.addEventListener('blur', function() {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailPattern.test(this.value)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        // Password strength indicator
        const passwordField = document.getElementById('contraseña');
        passwordField.addEventListener('input', function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);
            
            // Remove any existing strength indicators
            const existingIndicator = this.parentNode.parentNode.querySelector('.password-strength');
            if (existingIndicator) {
                existingIndicator.remove();
            }
            
            if (password.length > 0) {
                const indicator = document.createElement('div');
                indicator.className = `password-strength strength-${strength.level}`;
                indicator.innerHTML = `<small>Seguridad: ${strength.text}</small>`;
                this.parentNode.parentNode.appendChild(indicator);
            }
        });
        
        function calculatePasswordStrength(password) {
            let score = 0;
            
            if (password.length >= 8) score++;
            if (/[a-z]/.test(password)) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;
            
            const levels = [
                { level: 'weak', text: 'Débil', color: '#e53e3e' },
                { level: 'fair', text: 'Regular', color: '#dd6b20' },
                { level: 'good', text: 'Buena', color: '#38a169' },
                { level: 'strong', text: 'Fuerte', color: '#2f855a' }
            ];
            
            return levels[Math.min(score - 1, 3)] || levels[0];
        }
    });
</script>

<style>
    .is-invalid {
        border-color: #e53e3e !important;
        background-color: #fed7d7 !important;
    }
    
    .password-strength {
        margin-top: 0.5rem;
    }
    
    .strength-weak { color: #e53e3e; }
    .strength-fair { color: #dd6b20; }
    .strength-good { color: #38a169; }
    .strength-strong { color: #2f855a; }
</style>

@endsection
