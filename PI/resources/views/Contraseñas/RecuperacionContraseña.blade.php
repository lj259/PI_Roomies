@extends('layouts.footer_degradado')
@section('titulo', 'Recuperacion')
@section('Contenido')


@session('enviado')
    <script>
        Swal.fire({
            title: "Código enviado",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession
<div class="bg-warning bg-opacity-75 text-dark d-flex align-items-center px-4 py-3 rounded-3 shadow-sm mb-4">
    <i class="fas fa-exclamation-circle me-2 fs-5"></i> 
    <span>Hola Cardenal, si has olvidado tu contraseña no te preocupes, recupera tu cuenta aquí</span>
</div>

<main class="min-vh-100">
    <div class="container my-5">
        <div class="row shadow rounded-4 overflow-hidden" style="max-width: 1100px; margin: auto;">
            <div class="col-md-4 bg-danger bg-gradient d-flex align-items-center justify-content-center p-4 text-white">
                <div class="p-3 text-center">
                    <h3 class="fw-bold mb-3">HOLA CARDENAL</h3>
                    <p class="mb-4">Tranquilo(a), introduce tus datos para recuperar tu cuenta.</p>
                    <img src="/images/Polo3.png" class="img-fluid mt-3 mx-auto d-block" style="width: 180px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));">
                </div>
            </div>
            <div class="col-md-8 p-4 p-lg-5 bg-white">
                <form method="POST" action="/ValidarRecuperacion" class="px-md-3">
                    @csrf
                    <div class="text-center mx-auto" style="max-width: 400px;">
                        <h2 class="text-primary fw-bold mb-4">Recupera tu cuenta institucional</h2>
                        
                        <div class="form-floating mb-4">
                            <input type="email" class="form-control border-0 border-bottom rounded-0" id="emailInput" placeholder="TuMatricula@upq.edu.mx" name="correorec">
                            <label for="emailInput">Correo institucional</label>
                            @if($errors->has('correorec'))
                                <div class="text-danger mt-1 small">{{$errors->first('correorec')}}</div>
                            @endif
                        </div>
                        
                        <p class="text-muted small mb-2">Introduce tu última contraseña que recuerdes haber usado</p>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control border-0 border-bottom rounded-0" id="pwdInput" placeholder="Contraseña" name="pwdrecu">
                            <label for="pwdInput">Última contraseña</label>
                            @if($errors->has('pwdrecu'))
                                <div class="text-danger mt-1 small">{{$errors->first('pwdrecu')}}</div>
                            @endif
                        </div>
                        
                        <button type="submit" class="btn btn-primary px-4 py-2 mt-4 d-block mx-auto">
                            <i class="fas fa-paper-plane me-2"></i> Enviar código de recuperación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection