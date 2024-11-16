@extends('layouts.Plantilla1')
@section('titulo','Login User')
@section('Contenido')

<section class="vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 text-center mb-4 mb-md-0">
                <img src="{{ asset('images/logoPi.jpg')}}" class="img-fluid" alt="Logo">
            </div>
            
            <div class="col-12 col-md-8 col-lg-6 col-xl-4 offset-xl-1 border p-4 rounded">
                <form method="POST" action="/ValidarUsrLogin">
                    @csrf
                    <div class="text-center">
                        <h1 class="mb-3 mt-3">Inicia sesión como Usuario</h1>
                    </div>
                    
                    <div class="form-outline mb-4">
                        <label class="form-label" for="correousr">Correo Electrónico</label>
                        <input type="text" name="correousr" class="form-control form-control-lg" placeholder="Ingresa un correo" />
                        <small class="text-danger fst-italic">{{$errors->first('correousr')}}</small>
                    </div>
                    
                    <div class="form-outline mb-3">
                        <label class="form-label" for="pwdusr">Contraseña</label>
                        <input type="password" name="pwdusr" class="form-control form-control-lg" placeholder="Ingresa tu contraseña" />
                        <small class="text-danger fst-italic">{{$errors->first('pwdusr')}}</small>
                    </div>
                    
                    <div class="text-center mt-4 pt-2">
                        <button type="submit" class="btn btn-primary btn-lg px-4">Continuar</button>
                        <p class="small fw-bold mt-2 mb-0">¿No tienes una cuenta? <a href="{{route('RutaRegsitroUsuario')}}" class="link-danger">Crear una cuenta</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection