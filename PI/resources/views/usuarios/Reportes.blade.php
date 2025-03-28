@extends('layouts.Plantilla1')
@section('titulo', 'Inicio')
@section('Contenido')

    <link rel="stylesheet" href="{{asset('css/reportes.css')}}">

    @if ($errors->has('general'))
        <div class="alert alert-danger">
            {{ $errors->first('general') }}
        </div>
    @endif

    <div class="container d-flex flex-wrap justify-content-between my-4 gap-3">

        <div class="bg-light p-4 rounded col-md-8" style="background-color: #d9e4ff;">
            <div class="d-flex align-items-center mb-4">
                <!--<img src="user-profile.png" alt="Perfil Usuario" class="rounded-circle" 
                    style="width: 70px; height: 70px; object-fit: cover; border: 2px solid #007bff;">-->
                <h4 class="ml-3 mb-0 font-weight-bold text-primary">REPORTAR UN USUARIO</h4>
            </div>

            <h5 class="font-weight-bold mb-3 text-secondary">Razones de Reporte</h5>
            <form method="POST" action="/ValidarReportes">
                @csrf
                <div class="form-group">
                    <p>
                        <label class="d-block"><input type="checkbox" name="chbox1" class="mr-2"> <strong>1. Contenido
                                inapropiado:</strong>
                            Publicación de contenido ofensivo, inapropiado, difamatorio o amenazante.</label>
                        <label class="d-block"><input type="checkbox" name="chbox2" class="mr-2"> <strong>2. Acoso:</strong>
                            Enviar mensajes de odio,
                            acoso o intimidación a otros usuarios.</label>
                        <label class="d-block"><input type="checkbox" name="chbox3" class="mr-2"> <strong>3. Fraude o
                                engaño:</strong> Difusión de
                            rumores, enlaces con malware o intentos de estafa.</label>
                        <label class="d-block"><input type="checkbox" name="chbox4" class="mr-2"> <strong>4. Suplantación de
                                identidad:</strong>
                            Hacerse pasar por otra persona sin su consentimiento.</label>
                        <label class="d-block"><input type="checkbox" name="chbox5" class="mr-2"> <strong>5. Spam:</strong>
                            Enviar mensajes no
                            solicitados de manera masiva.</label>
                    </p>
                </div>

                <div class="d-flex align-items-center mt-3">
                    <label for="other" class="mb-0 mr-2 font-weight-bold"><strong>Otro:</strong></label>
                    <input type="text-area" name="other" class="form-control" style="max-width: 250px;">
                </div>
                <button type="submit" class="btn btn-primary btn-sm mt-2 w-25 mt-3">Enviar</button>
        </div>
        </form>
    </div>
@endsection