@extends('layouts.Plantilla1')
@section('titulo', 'Inicio')
@section('Contenido')

@if ($errors->has('general'))
    <div class="alert alert-danger">
        {{ $errors->first('general') }}
    </div>
@endif

<div class="container d-flex flex-wrap justify-content-between my-4 gap-3 min-vh-100">

    <div class="bg-light p-4 rounded col-md-8" style="background-color: #d9e4ff;">
        <div class="d-flex align-items-center mb-4">
            <img src="user-profile.png" alt="Perfil Usuario" class="rounded-circle" 
                style="width: 70px; height: 70px; object-fit: cover; border: 2px solid #007bff;">
            <h5 class="ml-3 mb-0 font-weight-bold text-primary">REPORTAR A USUARIO</h5>
        </div>

        <h5 class="font-weight-bold mb-3 text-secondary">Razones de Reporte</h5>
        <form method="POST" action="/ValidarReportes">
            @csrf
            <div class="form-group">
                <label class="d-block"><input type="checkbox" name="chbox1" class="mr-2"> 1. Contenido inapropiado:
                    Publicación de contenido ofensivo, inapropiado, difamatorio o amenazante.</label>
                <label class="d-block"><input type="checkbox" name="chbox2" class="mr-2"> 2. Acoso: Enviar mensajes de odio,
                    acoso o intimidación a otros usuarios.</label>
                <label class="d-block"><input type="checkbox" name="chbox3" class="mr-2"> 3. Fraude o engaño: Difusión de
                    rumores, enlaces con malware o intentos de estafa.</label>
                <label class="d-block"><input type="checkbox" name="chbox4" class="mr-2"> 4. Suplantación de identidad:
                    Hacerse pasar por otra persona sin su consentimiento.</label>
                <label class="d-block"><input type="checkbox" name="chbox5" class="mr-2"> 5. Spam: Enviar mensajes no
                    solicitados de manera masiva.</label>
            </div>

            <div class="d-flex align-items-center mt-3">
                <label for="other" class="mb-0 mr-2 font-weight-bold">Otro:</label>
                <input type="text" name="other" class="form-control" style="max-width: 250px;">
            </div>
    </div>

    <div class="col-md-4 position-relative">
        <img src="{{asset('images/Polo3.png')}}" alt="Polo" class="position-absolute"
            style="width: 350px; bottom: 0; right: -150px; z-index: 1; opacity: 0.9; object-fit: cover;">

        <div class="bg-white border rounded p-4 text-center"
            style="width: 250px; bottom: 100px; right: 20px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); font-size: 14px; z-index: 2;">
            <p class="mb-3 font-weight-bold text-dark">HOLA CARDENAL</p>
            <p class="mb-3 text-secondary">Lamentamos los inconvenientes. Genera tu Reporte</p>
            <button type="submit" class="btn btn-primary btn-sm mt-2 w-100">Enviar</button>
        </div>
    </div>
    </form>
</div>
@endsection

