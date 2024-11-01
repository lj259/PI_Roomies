@extends('layouts.Plantilla1')
@section('titulo','Test')
@section('Contenido')
<style>
        .container {
            margin-top: 20px;
        }
        .test-table {
            width: 100%;
        }
        .mascota-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .buttons-container {
            text-align: center;
            margin-top: 20px;
        }
        .table-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .mascota {
            width: 300px;
            max-width: 100%;
        }
</style>

    <div class="container">
        <div class="table-section">
            <!-- Tabla de Test -->
            <div class="table-responsive col-md-7">
                <table class="table test-table">
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
                        <!-- Agrega más preguntas según sea necesario -->
                    </tbody>
                </table>
            </div>
            <!-- Imagen de Mascota -->
            <div class="col-md-4 mascota-container">
                <img src="mascota.png" alt="Mascota" class="mascota">
            </div>
        </div>
        <!-- Botones -->
        <div class="buttons-container">
            <button class="btn btn-success m-2">ENVIAR RESPUESTAS</button>
            <button class="btn btn-primary m-2">REGRESAR PÁGINA INICIO</button>
        </div>
    </div>

@endsection