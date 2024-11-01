@extends('layouts.Plantilla1')
@section('titulo','Inicio')
@section('Contenido')
<style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }
        .container {
            position: relative;
            text-align: center;
            color: white;
            height: 100vh;
            width: 100vw;
        }
        .background-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
        }
        .title {
            font-size: 48px;
            font-weight: bold;
            color: #00a2ff;
            margin-top: 20px;
            font-family: 'Arial', sans-serif;
            z-index: 1;
        }
        .upq-logo {
            width: 300px;
            margin-top: 30px;
            z-index: 1;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            z-index: 1;
        }
        .btn-custom {
            padding: 10px 20px;
            background-color: #00c2ff;
            color: black;
            border-radius: 12px;
            font-weight: bold;
        }
        .character-left {
            position: absolute;
            bottom: 20px;
            left: 10px;
            width: 120px;
            z-index: 1;
        }
        .character-right {
            position: absolute;
            bottom: 20px;
            right: 10px;
            width: 120px;
            z-index: 1;
        }
        .footer-link {
            position: absolute;
            bottom: 10px;
            right: 20px;
            color: black;
            font-weight: bold;
            text-decoration: none;
            z-index: 1;
        }
</style>

    <!-- Contenedor principal -->
    <img src="{{asset('images\Fondo_uni.jpg')}}" alt="Fondo" class="background-image">
    <div class="container">
        <!-- Imagen de fondo -->

        <!-- Título principal -->
        <div class="title">POLI ROOMS</div>

        <!-- Logo UPQ -->
        <img src="upq.png" alt="UPQ Logo" class="upq-logo">

        <!-- Botones de acción -->
        <div class="button-container">
            <button class="btn btn-custom">INICIA</button>
            <button class="btn btn-custom">REGÍSTRATE</button>
        </div>

        <!-- Personajes a los lados -->
        <img src="personaje1.png" alt="Personaje Izquierda" class="character-left">
        <img src="personaje2.png" alt="Personaje Derecha" class="character-right">

        <!-- Enlace de "¿Quiénes somos?" -->
        <a href="#" class="footer-link">¿Quiénes somos?</a>
    </div>



@endsection