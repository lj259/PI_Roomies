@extends('layouts.Plantilla1')
@section('titulo','Registro')
@section('Contenido')
@session('Exito')
    <script>
        Swal.fire({
        title: "Registro correcto",
        text: '{{$value}}',
        icon: "success"
        });
    </script>
@endsession
<div class="container mt-4 p-4 border bg-white">
    <div class="d-flex justify-content-around align-items-center mt-3">
        <img src="{{asset('images/Casa.png')}}" alt="Casa" class="img-fluid" style="width: 200px;">
        <img src="{{asset('images/Poli1.png')}}" alt="Poli" class="img-fluid" style="width: 200px;">
    </div>
    
    <div class="mx-auto mt-3 p-4 bg-light rounded shadow" style="max-width: 400px; text-align: center;">
        <h4>Registrar Usuario</h4>
        <form action="{{route('ValidasUsuario')}}" method="POST">
        @csrf
            <div class="form-group text-left">
                <label for="nombre" class="font-weight-bold">Nombre:</label>
                <input type="text" class="form-control" name="nombre" placeholder="Ingresa tu nombre completo" value="{{old('nombre')}}">
                <small class="text-danger fst-italic">{{$errors->first('nombre')}}</small>
      
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
                <input type="number" class="form-control" name="edad" placeholder="Ingresa tu edad" value="{{old('edad')}}">
                <small class="text-danger fst-italic">{{$errors->first('edad')}}</small>
      
            </div>
            <div class="form-group text-left">
                <label for="telefono" class="font-weight-bold">Teléfono:</label>
                <input type="tel" class="form-control" name="telefono" placeholder="Ingresa tu teléfono" value="{{old('telefono')}}">
                <small class="text-danger fst-italic">{{$errors->first('telefono')}}</small>
      
            </div>
            <div class="form-group text-left">
                <label for="correo" class="font-weight-bold">Correo Institucional:</label>
                <input type="email" class="form-control" name="correo" placeholder="Ingresa tu correo institucional" value="{{old('correo')}}">
                <small class="text-danger fst-italic">{{$errors->first('correo')}}</small>
            </div>
            <div class="form-group text-left">
                <label for="password" class="font-weight-bold">Contraseña:</label>
                <input type="password" class="form-control" name="password" placeholder="Ingresa una contraseña segura" value="{{old('password')}}">
                <small class="text-danger fst-italic">{{$errors->first('password')}}</small>
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-3">Registrar</button>
        </form>
    </div>
    
    <div class="d-flex justify-content-center mt-3">
        <img src="{{asset('images/Polo1.png')}}" alt="Polo" class="img-fluid" style="width: 200px;">
    </div>
</div>

@endsection