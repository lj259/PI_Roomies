@extends('layouts.Plantilla1')
@section('titulo','Registro')
@section('Contenido')

<div class="container mt-4 p-4 border bg-white">
    <div class="d-flex justify-content-around align-items-center mt-3">
        <img src="{{asset('images/Casa.png')}}" alt="Casa" class="img-fluid" style="width: 200px;">
        <img src="{{asset('images/Poli1.png')}}" alt="Poli" class="img-fluid" style="width: 200px;">
    </div>
    
    <div class="mx-auto mt-3 p-4 bg-light rounded shadow" style="max-width: 400px; text-align: center;">
        <h4>Registrar Usuario</h4>
        <form>
            <div class="form-group text-left">
                <label for="nombre" class="font-weight-bold">Nombre:</label>
                <input type="text" class="form-control" id="nombre" placeholder="Ingresa tu nombre completo">
            </div>
            <div class="form-group text-left">
                <label class="font-weight-bold">Género:</label><br>
                <div class="btn-group" role="group" aria-label="Género">
                    <button type="button" class="btn btn-success">F</button>
                    <button type="button" class="btn btn-primary">M</button>
                </div>
            </div>
            <div class="form-group text-left">
                <label for="edad" class="font-weight-bold">Edad:</label>
                <input type="number" class="form-control" id="edad" placeholder="Ingresa tu edad">
            </div>
            <div class="form-group text-left">
                <label for="telefono" class="font-weight-bold">Teléfono:</label>
                <input type="tel" class="form-control" id="telefono" placeholder="Ingresa tu teléfono">
            </div>
            <div class="form-group text-left">
                <label for="correo" class="font-weight-bold">Correo Institucional:</label>
                <input type="email" class="form-control" id="correo" placeholder="Ingresa tu correo institucional">
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-3">Registrar</button>
        </form>
    </div>
    
    <div class="d-flex justify-content-center mt-3">
        <img src="{{asset('images/Polo1.png')}}" alt="Polo" class="img-fluid" style="width: 200px;">
    </div>
</div>

@endsection
