@extends('layouts.footer_degradado')
@section('titulo', 'Registro')
@section('Contenido')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-3">
                    <div class="d-flex justify-content-center mb-3">
                        <img src="{{asset('images/Poli1.png')}}" alt="Logo" height="50" class="me-2">
                    </div>
                    <h4 class="fw-bold mb-0">Registro de Usuario</h4>
                </div>
                <div class="text-center position-relative mb-4">
                    <div class="avatar-upload">
                        <div class="avatar-edit">
                            <input type="file" id="imageUpload" name="foto_perfil" accept=".png, .jpg, .jpeg" />
                            <label for="imageUpload"><i class="fas fa-camera"></i></label>
                        </div>
                        <div class="avatar-preview">
                            <div id="imagePreview" style="background-image: url('{{asset('images/default-avatar.png')}}');"></div>
                        </div>
                    </div>
                    <p class="text-muted small mt-2">Foto de perfil (opcional)</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{route('ValidasUsuario')}}" method="POST" enctype="multipart/form-data"> <!-- Proper Encoding type for file upload--> 
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nombre" class="form-label fw-bold">Nombre</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ingresa tu nombre"
                                    value="{{old('nombre')}}">
                                <small class="text-danger fst-italic">{{$errors->first('nombre')}}</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="ap_reg" class="form-label fw-bold">Apellido paterno</label>
                                <x-input placeholder="Apellido paterno" nombre="ap_reg"></x-input>
                                <small class="text-danger fst-italic">{{$errors->first('ap_reg')}}</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="am_reg" class="form-label fw-bold">Apellido materno</label>
                                <x-input placeholder="Apellido materno" nombre="am_reg"></x-input>
                                <small class="text-danger fst-italic">{{$errors->first('am_reg')}}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_nac" class="form-label fw-bold">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nac" value="{{old('fecha_nac')}}">
                                <small class="text-danger fst-italic">{{$errors->first('fecha_nac')}}</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="genero" class="form-label fw-bold">Género</label>
                                <select name="genero" id="genero" class="form-select">
                                    <option value="">Selecciona una opción</option>
                                    <option value="hombre" {{old('genero') == 'hombre' ? 'selected' : ''}}>Hombre</option>
                                    <option value="mujer" {{old('genero') == 'mujer' ? 'selected' : ''}}>Mujer</option>
                                    <option value="otro" {{old('genero') == 'otro' ? 'selected' : ''}}>Otro</option>
                                </select>
                                <small class="text-danger fst-italic">{{$errors->first('genero')}}</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label fw-bold">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" class="form-control" name="telefono" placeholder="Ingresa tu teléfono"
                                        value="{{old('telefono')}}">
                                </div>
                                <small class="text-danger fst-italic">{{$errors->first('telefono')}}</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Correo Institucional</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" placeholder="Ingresa tu correo institucional"
                                        value="{{old('email')}}">
                                </div>
                                <small class="text-danger fst-italic">{{$errors->first('email')}}</small>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="password" class="form-label fw-bold">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa una contraseña segura"
                                        value="{{old('password')}}">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <small class="text-danger fst-italic">{{$errors->first('password')}}</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" 
                                        placeholder="Confirma tu contraseña" value="{{old('password_confirmation')}}">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <small id="passwordMatchMessage" class="fst-italic"></small>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Registrar
                            </button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <p>¿Ya tienes cuenta? <a href="/login">Iniciar sesión</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Password toggle visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
    
    // Confirmation password toggle visibility
    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password_confirmation');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
    
    // Password match validation
    function checkPasswordMatch() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const messageElement = document.getElementById('passwordMatchMessage');
        
        if (password === '' || confirmPassword === '') {
            messageElement.textContent = '';
            messageElement.className = 'fst-italic';
            return;
        }
        
        if (password === confirmPassword) {
            messageElement.textContent = 'Las contraseñas coinciden';
            messageElement.className = 'text-success fst-italic';
        } else {
            messageElement.textContent = 'Las contraseñas no coinciden';
            messageElement.className = 'text-danger fst-italic';
        }
    }
    
    document.getElementById('password').addEventListener('keyup', checkPasswordMatch);
    document.getElementById('password_confirmation').addEventListener('keyup', checkPasswordMatch);
    
    // Image preview
    document.getElementById('imageUpload').addEventListener('change', function() {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('imagePreview').style.backgroundImage = `url(${e.target.result})`;
        }
        
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endsection