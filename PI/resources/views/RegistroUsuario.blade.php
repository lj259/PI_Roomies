@extends('layouts.footer_degradado')
@section('titulo', 'Registro')
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
<!-- Imagenes -->
<!-- <div class="container mt-4 p-4 border bg-white">
    <div class="d-flex justify-content-around align-items-center mt-3">
        <img src="{{asset('images/Casa.png')}}" alt="Casa" class="img-fluid" style="width: 200px;">
        <img src="{{asset('images/Poli1.png')}}" alt="Poli" class="img-fluid" style="width: 200px;">
    </div> -->
<!-- Imagenes -->
 <body>
     <div class="mx-auto mt-3 p-4 bg-light rounded shadow" style="max-width: 400px; text-align: center;">
         <h4>Registrar Usuario</h4>
        <form action="{{route('ValidasUsuario')}}" method="POST">
            @csrf
            <div class="form-group text-left mt-3">
                <label for="nombre" class="font-weight-bold">Nombre:</label>
                <input type="text" class="form-control" name="nombre" placeholder="Ingresa tu nombre completo"
                    value="{{old('nombre')}}">
                    <small class="text-danger fst-italic">{{$errors->first('nombre')}}</small>
                </div>

                <div class="form-group text-left mt-3">
                <label for="ap_reg">Apellido paterno</label>
                <x-input placeholder="Apellido paterno" nombre="ap_reg"></x-input>
                <small class="text-danger fst-italic">{{$errors->first('ap_reg')}}</small>
            </div>
            
            <div class="form-group text-left mt-3">
                <label for="am_reg">Apellido materno</label>
                <x-input placeholder="Apellido paterno" nombre="am_reg"></x-input>
                <small class="text-danger fst-italic">{{$errors->first('am_reg')}}</small>
            </div>

            <div class="form-group text-left mt-3">
                <label for="">Fecha de Nacimiento</label>
                <input type="date">
            </div>
            
            <div>
                <div class="form-check mt-3 form-check-inline">
                    <label class="form-check mt-3 form-check-inline" for="">Genero</label>
                    <select name="radio_gen" id="">
                        <option value="">Selecciona un tipo</option>
                        <option value="h">Hombre</option>
                        <option value="m">Mujer</option>
                        <option value="o">Otro</option>
                    </select>
                </div>
                
                <br>
                <small class="text-danger fst-italic">{{$errors->first('radio_gen')}}</small>
                
            </div>
            
            <div class="form-group text-left mt-3">
                <label for="telefono" class="font-weight-bold">Teléfono:</label>
                <input type="tel" class="form-control" name="telefono" placeholder="Ingresa tu teléfono"
                    value="{{old('telefono')}}">
                <small class="text-danger fst-italic">{{$errors->first('telefono')}}</small>

            </div>
            <div class="form-group text-left mt-3">
                <label for="email" class="font-weight-bold">Correo Institucional:</label>
                <input type="email" class="form-control" name="email" placeholder="Ingresa tu correo institucional"
                    value="{{old('email')}}">
                <small class="text-danger fst-italic">{{$errors->first('email')}}</small>
            </div>
            <div class="form-group text-left mt-3">
                <label for="password" class="font-weight-bold">Contraseña:</label>
                <input type="password" class="form-control" name="password" placeholder="Ingresa una contraseña segura"
                    value="{{old('password')}}">
                <small class="text-danger fst-italic">{{$errors->first('password')}}</small>
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-3">Registrar</button>
        </form>
        <small class="text-danger fst-italic">{{$errors->first('id_rol')}}</small>
    </div>

</div>
<footer class="degradado mt-5"></footer>
@endsection