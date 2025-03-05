@extends('layouts.footer_degradado')
@section('titulo', 'Nueva Contrseña')
@section('Contenido')


@session('succes')
    <script>
        Swal.fire({
            title: "Código enviado",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession
@session('error')
    <script>
        Swal.fire({
            title: "Código enviado",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession

<div class="bg-danger text-white d-flex align-items-center px-3" style="height: 50px; font-size: 14px;">
    <span class="mr-2" style="font-size: 20px;">⚠️</span> HOLA CARDENAL ¿OLVIDASTE TU CONTRASEÑA? NO PIERDAS EL ACCESO
    RECUPERA TU CUENTA AHORA NUEVA
</div>

<main class="min-vh-100">
    <div class="container text-justify bg-dark bg-gradient my-5">
        <div class="row row-cols-2">
            <div class="container col-md-4 align-items-center justify-content-center mt-4">
                <div class="bg-light p-3 rounded mr-4" style="max-width: 200px; font-size: 12px;">
                    <p class="mb-2">HOLA CARDENAL<br>¿OLVIDASTE TU CONTRASEÑA? NO PIERDAS EL ACCESO RECUPERA TU CUENTA AHORA</p>
                    <img src="cardenal.png" alt="Cardenal" class="img-fluid mt-2" style="width: 120px;">
                </div>
                <p class="text-primary">Aqui ira una imagen</p>
            </div>
            <div class="bg-secondary">
                <form method="POST" action="{{ route('Recuperacion_pssw') }}">
                    @csrf
                    <div class="text-center" style="max-width: 300px; width: 100%;">
                        <h1 class="text-primary font-weight-bold" style="font-size: 32px;">Recupera tu correo institucional</h1>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-0">👤</span>
                            </div>
                            <input type="email" class="form-control" placeholder="Matricula@upq.edu.mx" aria-label="Matricula" name="correorec">
            
                        </div>
            
                        <div class="mt-3 mb-3">
                            <small class="fst-italic"><strong>{{$errors->first('correorec')}}</strong></small>
                        </div>
            
                        <p class="text-muted">Introduce tu nueva contraseña  </p>
            
                        <input type="password" class="form-control mb-3" placeholder="Introduce tu última contraseña" name="pwdrecu">
                        <small class="fst-italic"><strong>{{$errors->first('pwdrecu')}}</strong></small>
                    </div>
                    <br>
                    
                    <div class="container d-flex align-items-center justify-content-center mt-4 mb-4">
                        <button type="submit" class="btn btn-outline-primary">Envíar código de recuperación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        
    </main>
    <footer class="degradado_2 mt-5">s</footer>
@endsection