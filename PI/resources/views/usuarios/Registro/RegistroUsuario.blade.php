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
@session('Fallo')
        <script>
            Swal.fire({
                title: "Respuesta del servidor",
                text: "{{$value}}",
                icon: "error"
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
        <form action="{{route('Registrar_Usuario')}}" method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario()">
            @csrf
            <div class="form-group text-left mt-3">
                <label for="nombre" class="font-weight-bold">Nombre:</label>
                <input type="text" class="form-control" name="nombre" placeholder="Ingresa tu nombre/s"
                    value="{{old('nombre')}}" required>
                <small class="text-danger fst-italic">{{$errors->first('nombre')}}</small>
            </div>
            <div class="form-group text-left mt-3">
                <label for="apellido_paterno" class="font-weight-bold">Apellido paterno:</label>
                <input type="text" class="form-control" name="apellido_paterno" placeholder="Ingresa tu apellido paterno"
                    value="{{old('apellido_paterno')}}" required>
                <small class="text-danger fst-italic">{{$errors->first('apellido_paterno')}}</small>
            </div>
            <div class="form-group text-left mt-3">
                <label for="apellido_materno" class="font-weight-bold">Apellido materno:</label>
                <input type="text" class="form-control" name="apellido_materno" placeholder="Ingresa tu apellido materno"
                    value="{{old('apellido_materno')}}" required>
                <small class="text-danger fst-italic">{{$errors->first('apellido_materno')}}</small>
            </div>
            
            <div>
                <div class="form-check mt-3 form-check-inline">
                    <label class="form-check mt-3 form-check-inline" for="">Genero</label>
                    <select name="genero">
                        <option value="">Selecciona un tipo</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                
                <br>
                <small class="text-danger fst-italic">{{$errors->first('genero')}}</small>
                
            </div>
            
            <div class="form-group text-left mt-3">
                <label for="telefono" class="font-weight-bold">Teléfono:</label>
                <input type="text" class="form-control" name="telefono" placeholder="Ingresa tu teléfono"
                    value="{{old('telefono')}}" required>
                <small class="text-danger fst-italic">{{$errors->first('telefono')}}</small>
            </div>

            <div class="form-group text-left mt-3">
                <label for="email" class="font-weight-bold">Correo Institucional:</label>
                <input type="email" class="form-control" name="correo" placeholder="Ingresa tu correo institucional"
                    value="{{old('correo')}}" required>
                <small class="text-danger fst-italic">{{$errors->first('correo')}}</small>
            </div>

            <div class="form-group text-left mt-3">
                <label for="password" class="font-weight-bold">Contraseña:</label>
                <input type="password" class="form-control" name="contraseña" id="contraseña" placeholder="Ingresa una contraseña segura"
                    value="{{old('contraseña')}}" required onkeyup="verificarCoincidencia()">
                <small class="text-danger fst-italic">{{$errors->first('contraseña')}}</small>
            </div>

            <div class="form-group text-left mt-3">
                <label for="password" class="font-weight-bold">Repita la contraseña:</label>
                <input type="password" class="form-control" name="contraseña_confirmation" id="contraseña_confirmation" placeholder="Ingresa una contraseña segura"
                    value="{{old('contraseña_confirmation')}}" required onkeyup="verificarCoincidencia()">
                <small class="text-danger fst-italic">{{$errors->first('contraseña_confirmation')}}</small>
            </div>

            <p id="mensaje-error" style="color: red; display: none;">⚠️ Las contraseñas no coinciden</p>


            <div class="form-group text-left mt-3">
                <label for="foto_perfil" class="">Suba su foto</label>
                <input type="file" name="foto_perfil" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-3" id="boton-enviar" disabled>Registrar</button>
        </form>
        <script>
            function verificarCoincidencia() {
                let pass = document.getElementById("contraseña").value;
                let confirmPass = document.getElementById("contraseña_confirmation").value;
                let mensajeError = document.getElementById("mensaje-error");
                let botonEnviar = document.getElementById("boton-enviar");

                if (pass.length >= 6 && confirmPass.length >= 6) {
                    if (pass === confirmPass) {
                        mensajeError.style.display = "none";
                        botonEnviar.removeAttribute("disabled");
                    } else {
                        mensajeError.style.display = "block";
                        botonEnviar.setAttribute("disabled","true");
                    }
                } else {
                    mensajeError.style.display = "none";
                    botonEnviar.disabled = true;
                }
            }

            function validarFormulario() {
                let pass = document.getElementById("contraseña").value;
                let confirmPass = document.getElementById("contraseña_confirmation").value;

                if (pass !== confirmPass) {
                    alert("Las contraseñas no coinciden");
                    return false;
                }

                return true;
            }
        </script>
    </div>

</div>
<footer class="degradado mt-5"></footer>


@endsection