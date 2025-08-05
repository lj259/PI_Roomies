<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Propietario - Poli-Roomies</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('css/perfil.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        
        .registration-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .registration-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 800px;
            width: 100%;
        }
        
        .registration-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        
        .registration-header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .registration-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .registration-body {
            padding: 40px;
        }
        
        .form-floating {
            margin-bottom: 1rem;
        }
        
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
            color: #764ba2;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <div class="registration-card">
            <div class="registration-header">
                <h1><i class="fas fa-building me-3"></i>Registro de Propietario</h1>
                <p>Únete a Poli-Roomies y comienza a publicar tus propiedades</p>
            </div>
            
            <div class="registration-body">
                @if(session('Exito'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('Exito') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('propietario.register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Profile Picture Upload -->
                    <div class="mb-4 text-center">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type="file" id="imageUpload" name="foto_perfil" accept=".png, .jpg, .jpeg" />
                                <label for="imageUpload"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url('{{ asset('images/default.jpg') }}')"></div>
                            </div>
                        </div>
                        <p class="text-muted small mt-2">Sube tu foto de perfil (opcional)</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="{{ old('nombre') }}" required>
                                <label for="nombre">Nombre</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" 
                                       value="{{ old('apellido_paterno') }}" required>
                                <label for="apellido_paterno">Apellido Paterno</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" 
                                       value="{{ old('apellido_materno') }}">
                                <label for="apellido_materno">Apellido Materno</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="genero" name="genero" required>
                                    <option value="">Selecciona tu género</option>
                                    <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                <label for="genero">Género</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="correo" name="correo" 
                                       value="{{ old('correo') }}" required>
                                <label for="correo">Correo Electrónico</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control" id="telefono" name="telefono" 
                                       value="{{ old('telefono') }}" required>
                                <label for="telefono">Teléfono</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
                                <label for="contraseña">Contraseña</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="contraseña_confirmation" 
                                       name="contraseña_confirmation" required>
                                <label for="contraseña_confirmation">Confirmar Contraseña</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-register">
                        <i class="fas fa-user-plus me-2"></i>Registrarme como Propietario
                    </button>
                </form>

                <div class="login-link">
                    <p>¿Ya tienes una cuenta? <a href="{{ route('propietario.login') }}">Inicia sesión aquí</a></p>
                    <p><a href="{{ route('RutaInicio') }}">Volver al inicio</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle profile picture upload preview
        document.getElementById('imageUpload').addEventListener('change', function() {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('imagePreview').style.backgroundImage = `url(${e.target.result})`;
            }
            
            reader.readAsDataURL(this.files[0]);
        });
    </script>
</body>
</html>
