@extends('layouts.footer_degradado')
@section('titulo','Inicio de Sesión')
@section('Contenido')

    @session('Exito')
        <script>
            Swal.fire({
                title: "Respuesta del servidor",
                text: "{{$value}}",
                icon: "success"
            });
        </script>
    @endsession
    @session('Fallo')
        <script>
            Swal.fire({
                title: "Respuesta del servidor",
                text: "{{$value}}",
                icon: "error"
            });
        </script>
    @endsession

    <div class="containe mt-5">
        <div class="row justify-content-center align-items-center h-100 min-vh-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 text-center mb-4 mb-md-0">
                <img src="{{ asset('images/logoPI.jpg')}}" class="img-fluid" alt="Logo">
            </div>
            <div class="col-12 col-md-8 col-lg-6 col-xl-4 offset-xl-1 border p-4 rounded">
                <form method="POST" action="{{route('ValidarUsrLogin')}}">
                    @csrf
                    <div class="text-center">
                        <h1 class="mb-3 mt-3">Inicia sesión</h1>
                    </div>
                    
                    <div class="form-outline mb-4">
                        <label class="form-label" for="correo">Correo Electrónico</label>
                        <input type="text" name="correo" class="form-control form-control-lg" placeholder="Ingresa un correo" value="{{old('correo')}}"/>
                        <small class="text-danger fst-italic">{{$errors->first('correo')}}</small>
                    </div>
                    
                    <div class="form-outline mb-3">
                        <label class="form-label" for="contraseña">Contraseña</label>
                        <input type="password" name="contraseña" class="form-control form-control-lg" placeholder="Ingresa tu contraseña" />
                        <small class="text-danger fst-italic">{{$errors->first('contraseña')}}</small>
                    </div>
                    
                    <div class="text-center mt-4 pt-2">
                        <button type="submit" class="btn btn-primary btn-lg px-4">Continuar</button>
                        <p class="small fw-bold mt-2 mb-0">¿No tienes una cuenta? <a href="{{route('RutaRegistroUsuario')}}" class="link-danger">Crear una cuenta</a></p>
                        <p class="small fw-bold mt-2 mb-0">¿Olvidaste tu contraseña?<a href="{{route('RutaRecuperacion')}}" class="link-danger">Recupera tu contraseña</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="degradado_2 mt-1">
        s
    </footer>
@endsection
