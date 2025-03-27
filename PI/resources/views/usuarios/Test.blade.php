@extends('layouts.plantilla_simple')
@section('titulo', 'Test')
@section('Contenido')
@session('Exito')
    <script>
        Swal.fire({
            title: "Respuesta del Servidor!",
            text: '{{$value}}',
            icon: "success"
        });
    </script>
@endsession
<style>
    /* Remueve el borde solo en las celdas de error */
    table td.error-cell {
        border: none;
        color: red;
    }
</style>
<div class="container mt-4 min-vh-100">
    <div class="d-flex justify-content-between align-items-center">
        <div class="table-responsive col-md-7">
            <form action="{{route('ValidarTest')}}" method="POST">
                @csrf
                <table class="table">
                    <thead>
                        <tr>
                            <th>TEST HÁBITOS</th>
                            <th>SI</th>
                            <th>NO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>¿Te levantas temprano por las mañanas?</td>
                            <td><input type="radio" name="q1" value="si"></td>
                            <td><input type="radio" name="q1" value="no"></td>
                            <td class="error-cell" ><small>{{$errors->first('q1')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Te consideras una persona ordenada?</td>
                            <td><input type="radio" name="q2" value="si"></td>
                            <td><input type="radio" name="q2" value="no"></td>
                            <td class="error-cell"><small>{{$errors->first('q2')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Te molesta el ruido por la noche?</td>
                            <td><input type="radio" name="q3" value="si"></td>
                            <td><input type="radio" name="q3" value="no"></td>
                            <td class="error-cell"><small>{{$errors->first('q3')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Tienes alguna mascota?</td>
                            <td><input type="radio" name="q4" value="si"></td>
                            <td><input type="radio" name="q4" value="no"></td>
                            <td class="error-cell"><small>{{$errors->first('q4')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Fumas dentro de casa?</td>
                            <td><input type="radio" name="q5" value="si"></td>
                            <td><input type="radio" name="q5" value="no"></td>
                            <td class="error-cell"><small>{{$errors->first('q5')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Te gusta compartir tus cosas personales (como utensilios de cocina, electrodomésticos, etc)?</td>
                            <td><input type="radio" name="q7" value="si"></td>
                            <td><input type="radio" name="q7" value="no"></td>
                            <td class="error-cell"><small>{{$errors->first('q7')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Te gusta compartir tus cosas personales (como utensilios de cocina, electrodomésticos, etc)?</td>
                            <td><input type="radio" name="q7" value="si"></td>
                            <td><input type="radio" name="q7" value="no"></td>
                            <td class="error-cell"><small>{{$errors->first('q7')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Te gusta tener invitados frecuentemente?</td>
                            <td><input type="radio" name="q9" value="si"></td>
                            <td><input type="radio" name="q9" value="no"></td>
                            <td class="error-cell"><small>{{$errors->first('q9')}}</small></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center mt-4">
                    <button class="btn btn-success m-2">Enviar respuestas</button>
                    <a href="{{route('RutaInicio')}}" class="btn btn-primary m-2">Regresar al inicio</a>
                </div>
            </form>

        </div>

        <div class="col-md-4 d-flex justify-content-center align-items-center">
            <img src="{{asset('images/Polo2.png')}}" alt="¨Polo" class="img-fluid" style="max-width: 300px;">
        </div>
    </div>


</div>

@endsection