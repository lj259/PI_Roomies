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

                {{-- Foto de perfil --}}
                <div class="text-center position-relative mb-4">
                    <div class="avatar-upload">
                        <div class="avatar-edit">
                            <input type="file" id="imageUpload" name="foto_perfil" accept=".png, .jpg, .jpeg" />
                            <label for="imageUpload"><i class="fas fa-camera"></i></label>
                        </div>
                        <div class="avatar-preview">
                            <div id="imagePreview"></div>
                        </div>
                    </div>
                    <p class="text-muted small mt-2">Foto de perfil (opcional)</p>
                </div>

                <div class="card-body p-4">
                    <form action="{{route('Registrar_Usuario')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nombre" class="form-label fw-bold">Nombre</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ingresa tu nombre"
                                    value="{{old('nombre')}}">
                                <small class="text-danger fst-italic">{{$errors->first('nombre')}}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="apellido_paterno" class="form-label fw-bold">Apellido paterno</label>
                                <x-input placeholder="Apellido paterno" nombre="apellido_paterno"></x-input>
                                <small class="text-danger fst-italic">{{$errors->first('apellido_paterno')}}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="apellido_materno" class="form-label fw-bold">Apellido materno</label>
                                <x-input placeholder="Apellido materno" nombre="apellido_materno"></x-input>
                                <small class="text-danger fst-italic">{{$errors->first('apellido_materno')}}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="genero" class="form-label fw-bold">Género</label>
                                <select name="genero" id="genero" class="form-select">
                                    <option value="">Selecciona una opción</option>
                                    <option value="masculino" {{old('genero') == 'hombre' ? 'selected' : ''}}>Hombre</option>
                                    <option value="femenino" {{old('genero') == 'mujer' ? 'selected' : ''}}>Mujer</option>
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
                                <label for="correo" class="form-label fw-bold">Correo Institucional</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" name="correo" placeholder="Ingresa tu correo institucional"
                                        value="{{old('correo')}}">
                                </div>
                                <small class="text-danger fst-italic">{{$errors->first('correo')}}</small>
                            </div>

                            {{-- Contraseña --}}
                            <div class="col-md-12 mb-3">
                                <label for="contraseña" class="form-label fw-bold">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="contraseña" placeholder="Ingresa una contraseña segura">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <small class="text-danger fst-italic">{{$errors->first('contraseña')}}</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="contraseña_confirmation" class="form-label fw-bold">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password_confirmation" name="contraseña_confirmation" placeholder="Confirma tu contraseña">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <small id="passwordMatchMessage" class="fst-italic"></small>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitButton" disabled>
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
    document.getElementById("imagePreview").style.backgroundImage = "url('{{ asset('images/default.jpg') }}')";
    document.getElementById('imageUpload').addEventListener('change', function() {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('imagePreview').style.backgroundImage = `url(${e.target.result})`;
        }
        
        reader.readAsDataURL(this.files[0]);
    });

    // Alternar visibilidad de la contraseña
    document.getElementById("togglePassword").addEventListener("click", function() {
        const passwordInput = document.getElementById("password");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
    });

    document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
        const confirmPasswordInput = document.getElementById("password_confirmation");
        confirmPasswordInput.type = confirmPasswordInput.type === "password" ? "text" : "password";
    });

    // Evitar copiar y pegar en la confirmación de contraseña
    document.getElementById("password_confirmation").addEventListener("paste", function(event) {
        event.preventDefault();
        alert("No puedes pegar la contraseña por seguridad.");
    });

    document.getElementById("password").addEventListener("copy", function(event) {
        event.preventDefault();
        alert("No puedes copiar la contraseña.");
    });

    document.getElementById("password").addEventListener("cut", function(event) {
        event.preventDefault();
        alert("No puedes cortar la contraseña.");
    });
    document.getElementById("password_confirmation").addEventListener("copy", function(event) {
        event.preventDefault();
        alert("No puedes copiar la contraseña.");
    });

    document.getElementById("password_confirmation").addEventListener("cut", function(event) {
        event.preventDefault();
        alert("No puedes cortar la contraseña.");
    });

    // Validar que las contraseñas coincidan
    function checkPasswordMatch() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const messageElement = document.getElementById('passwordMatchMessage');
        const submitButton = document.getElementById('submitButton');

        if (password === '' || confirmPassword === '') {
            messageElement.textContent = '';
            submitButton.disabled = true;
            return;
        }

        if (password === confirmPassword) {
            messageElement.textContent = 'Las contraseñas coinciden';
            messageElement.className = 'text-success';
            submitButton.disabled = false;
        } else {
            messageElement.textContent = 'Las contraseñas no coinciden';
            messageElement.className = 'text-danger';
            submitButton.disabled = true;
        }
    }

    document.getElementById('password').addEventListener('keyup', checkPasswordMatch);
    document.getElementById('password_confirmation').addEventListener('keyup', checkPasswordMatch);
    
</script>

@endsection
