@extends('layouts.Plantilla1')
@section('titulo','Inicio')
@section('Contenido')

<section class="vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 text-center mb-4 mb-md-0">
                <img src="{{ asset('images/logoPi.jpg')}}" class="img-fluid" alt="Logo">
            </div>
            
            <div class="col-12 col-md-8 col-lg-6 col-xl-4 offset-xl-1 border p-4 rounded">
                <form>
                    <div class="text-center">
                        <h1 class="mb-3 mt-3">Inicia sesión como administrador</h1>
                    </div>
                    
                    <div class="form-outline mb-4">
                        <label class="form-label" for="correoAdm">Correo Electrónico</label>
                        <input type="email" name="correoAdm" class="form-control form-control-lg" placeholder="Ingresa un correo" />
                    </div>
                    
                    <div class="form-outline mb-3">
                        <label class="form-label" for="pwdAdm">Contraseña</label>
                        <input type="password" name="pwdAdm" class="form-control form-control-lg" placeholder="Ingresa tu contraseña" />
                    </div>
                    
                    <div class="text-center mt-4 pt-2">
                        <button type="submit" class="btn btn-primary btn-lg px-4">Continuar</button>
                        <p class="small fw-bold mt-2 mb-0">¿No tienes una cuenta? <a href="/" class="link-danger">Volver al inicio</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection