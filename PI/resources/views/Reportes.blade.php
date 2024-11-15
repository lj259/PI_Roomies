@extends('layouts.Plantilla1')
@section('titulo','Inicio')
@section('Contenido')

<div class="bg-danger text-white font-weight-bold py-2 px-3">
    REPORTAR USUARIO
</div>

<div class="container d-flex my-4 gap-3">
    <div class="bg-light p-4 rounded col-md-8" style="background-color: #d9e4ff;">
        <div class="d-flex align-items-center mb-3">
            <img src="user-profile.png" alt="Perfil Usuario" class="rounded-circle" style="width: 50px; height: 50px;">
            <h5 class="ml-3 mb-0 font-weight-bold">REPORTAR A USUARIO</h5>
        </div>

        <h5 class="font-weight-bold mb-3">Razones de Reporte</h5>
        <label class="d-block"><input type="checkbox" class="mr-2"> 1. Contenido inapropiado: Publicación de contenido ofensivo, inapropiado, difamatorio o amenazante.</label>
        <label class="d-block"><input type="checkbox" class="mr-2"> 2. Acoso: Enviar mensajes de odio, acoso o intimidación a otros usuarios.</label>
        <label class="d-block"><input type="checkbox" class="mr-2"> 3. Fraude o engaño: Difusión de rumores, enlaces con malware o intentos de estafa.</label>
        <label class="d-block"><input type="checkbox" class="mr-2"> 4. Suplantación de identidad: Hacerse pasar por otra persona sin su consentimiento.</label>
        <label class="d-block"><input type="checkbox" class="mr-2"> 5. Spam: Enviar mensajes no solicitados de manera masiva.</label>

        <div class="d-flex align-items-center mt-3">
            <label for="other" class="mb-0 mr-2">Otro:</label>
            <input type="text" id="other" class="form-control" style="max-width: 200px;">
        </div>
    </div>
    
    <div class="col-md-4 position-relative">
        <img src="{{asset('images/Polo3.png')}}" alt="Polo" class="position-absolute" style="width: 250px; bottom: 0; right: 0; z-index: 1;">
        
        <div class="bg-white border rounded p-3" style="width: 200px; bottom: 70px; right: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); font-size: 12px; z-index: 2;">
            HOLA CARDENAL Lamentamos los inconvenientes Genera tu Reporte
            <button class="btn btn-primary btn-sm mt-2 w-100">Enviar</button>
        </div>
    </div>
</div>

@endsection
