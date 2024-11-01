@extends('layouts.Plantilla1')
@section('titulo','Recuperacion')
@section('Contenido')
 <style>
        body {
            background-color: #ffffff;
        }
        .header {
            background-color: #a72828;
            color: white;
            height: 50px;
            display: flex;
            align-items: center;
            padding-left: 20px;
            font-size: 14px;
        }
        .warning-icon {
            font-size: 20px;
            margin-right: 10px;
        }
        .main-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        .side-info {
            max-width: 200px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 8px;
            margin-right: 20px;
            font-size: 12px;
            text-align: left;
        }
        .cardenal-image {
            width: 120px;
            margin-top: 10px;
        }
        .title {
            font-size: 32px;
            font-weight: bold;
            color: #00a2ff;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .input-container {
            max-width: 300px;
            width: 100%;
            text-align: center;
        }
        .input-group-text {
            background-color: transparent;
            border: none;
        }
</style>

    <!-- Barra de advertencia superior -->
    <div class="header">
        <span class="warning-icon">⚠️</span> HOLA CARDENAL ¿OLVIDASTE TU CONTRASEÑA? NO PIERDAS EL ACCESO RECUPERA TU CUENTA AHORA
    </div>

    <!-- Contenedor principal -->
    <div class="container main-container">
        <!-- Información adicional y personaje -->
        <div class="side-info">
            <p>HOLA CARDENAL<br>¿OLVIDASTE TU CONTRASEÑA? NO PIERDAS EL ACCESO RECUPERA TU CUENTA AHORA</p>
            <img src="cardenal.png" alt="Cardenal" class="cardenal-image">
        </div>
        
        <!-- Formulario de recuperación de cuenta -->
        <div class="input-container">
            <h1 class="title">POLI ROOMS</h1>
            
            <!-- Campo de correo o matrícula -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">👤</span>
                </div>
                <input type="email" class="form-control" placeholder="Matricula@upq.edu.mx" aria-label="Matricula" aria-describedby="basic-addon1">
            </div>

            <!-- Texto de instrucción -->
            <p class="text-muted">Introduce tu última contraseña que recuerdes haber usado en esta cuenta</p>
            
            <!-- Campo de contraseña -->
            <input type="password" class="form-control mb-3" placeholder="Introduce tu última contraseña">
        </div>
    </div>

@endsection