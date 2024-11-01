@extends('layouts.Plantilla1')
@section('titulo','Busqueda')
@section('Contenido')
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #a72828;
            padding: 10px 20px;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }
        .logo {
            width: 80px;
            position: absolute;
            top: 10px;
            left: 10px;
        }
        .welcome-box {
            background-color: #dfffe2;
            border-radius: 8px;
            padding: 15px;
            margin: 20px;
            text-align: center;
            font-size: 16px;
            color: #333;
        }
        .choices-title {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            margin: 20px 0;
        }
        .choices-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }
        .choice-card {
            width: 200px;
            text-align: center;
            font-weight: bold;
        }
        .choice-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid transparent;
        }
        .choice1 img {
            background-color: #ff007f;
        }
        .choice2 img {
            background-color: #007bff;
        }
        .choice3 img {
            background-color: #00ff84;
        }
        .choice-title {
            margin-top: 10px;
            font-size: 18px;
        }
        .choice-description {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
</style>
    <!-- Encabezado -->
    <div class="header">
        REPORTAR USUARIO
    </div>
    
    <!-- Logotipo -->
    <img src="logo.png" alt="Logo" class="logo">
    
    <!-- Caja de bienvenida -->
    <div class="welcome-box">
        ¡¡¡Hey Hola Cardenal UPQ!!! Conoce Poli Roomies, una página donde podrás conocer a más compañeros que, como tú, buscan un dormitorio/apartamento adecuado para su estancia en la universidad. Podrás conocer personas con gustos similares a los tuyos y, lo mejor, ¡poder compartir! BIENVENIDO!!
    </div>
    
    <!-- Título de las opciones -->
    <div class="choices-title">¿CON QUIÉN BUSCAS RENTAR UN DORMITORIO/APARTAMENTO?</div>
    
    <!-- Contenedor de opciones -->
    <div class="choices-container">
        <!-- Opción Poli-Amigas -->
        <div class="choice-card choice1">
            <img src="character1.png" alt="Poli Amigas">
            <div class="choice-title">POLI - AMIGAS</div>
            <div class="choice-description">
                En este apartado es para buscar compartir dormitorio solo con Roomies mujeres.
            </div>
        </div>
        
        <!-- Opción Polo-Amigos -->
        <div class="choice-card choice2">
            <img src="character2.png" alt="Polo Amigos">
            <div class="choice-title">POLO - AMIGOS</div>
            <div class="choice-description">
                En este apartado es para buscar compartir dormitorio solo con Roomies hombres.
            </div>
        </div>
        
        <!-- Opción Mix Cardenal -->
        <div class="choice-card choice3">
            <img src="character3.png" alt="Mix Cardenal">
            <div class="choice-title">MIX CARDENAL</div>
            <div class="choice-description">
                En este apartado es para buscar compartir dormitorio solo con Roomies de ambos géneros.
            </div>
        </div>
    </div>
@endsection