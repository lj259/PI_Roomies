@extends('layouts.Plantilla1')
@section('titulo','Test')
@section('Contenido')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="table-responsive col-md-7">
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
                    </tr>
                    <tr>
                        <td>¿Te consideras una persona ordenada?</td>
                        <td><input type="radio" name="q2" value="si"></td>
                        <td><input type="radio" name="q2" value="no"></td>
                    </tr>
                    <tr>
                        <td>¿Te molesta el ruido por la noche?</td>
                        <td><input type="radio" name="q3" value="si"></td>
                        <td><input type="radio" name="q3" value="no"></td>
                    </tr>
                    <tr>
                        <td>¿Tienes alguna mascota?</td>
                        <td><input type="radio" name="q4" value="si"></td>
                        <td><input type="radio" name="q4" value="no"></td>
                    </tr>
                    <tr>
                        <td>¿Fumas dentro de casa?</td>
                        <td><input type="radio" name="q5" value="si"></td>
                        <td><input type="radio" name="q5" value="no"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-4 d-flex justify-content-center align-items-center">
            <img src="{{asset('images/Polo2.png')}}" alt="¨Polo" class="img-fluid" style="max-width: 300px;">
        </div>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-success m-2">ENVIAR RESPUESTAS</button>
        <button class="btn btn-primary m-2">REGRESAR PÁGINA INICIO</button>
    </div>
</div>

@endsection
