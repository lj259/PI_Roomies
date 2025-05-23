@extends('layouts.Plantilla1')
@section('titulo', 'Mejoras')
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
        <h4 class="ml-3 mb-0 font-weight-bold text-primary">Envíar una sugerencia</h4>
    </div>

    <form method="POST" action="/Sugerencias">
        @csrf

        <div class="d-flex mt-3">
            <!-- Razón de la sugerencia -->
            <div class="me-4 pr-2">
                <label for="other" class="font-weight-bold"><strong>Razón de su sugerencia:</strong></label>
                <input type="text" name="other" class="form-control mt-1" style="max-width: 250px;">
            </div>

            <!-- Departamento -->
            <div class="pl-2">
                <label for="departamento" class="font-weight-bold"><strong>Seleccione el área de su sugerencia: </strong></label>
                <select name="departamento" class="form-control mt-1" style="max-width: 200px;">
                    <option value="">Seleccione</option>
                    <option value="perfil">Perfil</option>
                    <option value="busqueda">Búsqueda</option>
                    <option value="interfaz">Interfaz</option>
                    <option value="interfaz">Departamentos</option>
                </select>
            </div>
        </div>

        <div class="mt-3">
            <label for="sugerencia" class="font-weight-bold"><strong>Desarrollo de la sugerencia:</strong></label>
            <textarea class="form-control mt-1" name="sugerencia" id="sugerencia" rows="4" placeholder="Escribe aquí tu sugerencia..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-sm mt-3 w-25">Enviar</button>
    </form>
</div>

    </div>


@endsection