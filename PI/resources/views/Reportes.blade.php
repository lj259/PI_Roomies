@extends('layouts.Plantilla1')
@section('titulo','Inicio')
@section('Contenido')
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #a72828;
            color: white;
            padding: 10px 20px;
            font-weight: bold;
        }
        .container {
            display: flex;
            margin: 20px;
            gap: 20px;
        }
        .report-box {
            background-color: #d9e4ff;
            padding: 20px;
            border-radius: 8px;
            width: 60%;
        }
        .report-box h5 {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .report-box label {
            font-weight: normal;
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .report-box input[type="checkbox"] {
            margin-right: 10px;
        }
        .other-input {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        .profile-section {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        .character-section {
            position: relative;
            width: 40%;
        }
        .character-img {
            width: 100px;
            position: absolute;
            bottom: 0;
            right: 0;
        }
        .dialog-box {
            position: absolute;
            bottom: 50px;
            right: 10px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            width: 200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 12px;
        }
        .dialog-box button {
            margin-top: 10px;
            width: 100%;
        }
</style>
    <!-- Encabezado -->
    <div class="header">REPORTAR USUARIO</div>

    <!-- Contenido principal -->
    <div class="container">
        <!-- Sección de reporte -->
        <div class="report-box">
            <div class="profile-section">
                <img src="user-profile.png" alt="Perfil Usuario" class="profile-img">
                <div>
                    <h5>REPORTAR A USUARIO</h5>
                </div>
            </div>
            
            <h5>Razones de Reporte</h5>
            <label><input type="checkbox"> 1. Contenido inapropiado: Publicación de contenido ofensivo, inapropiado, difamatorio o amenazante.</label>
            <label><input type="checkbox"> 2. Acoso: Enviar mensajes de odio, acoso o intimidación a otros usuarios.</label>
            <label><input type="checkbox"> 3. Fraude o engaño: Difusión de rumores, enlaces con malware o intentos de estafa.</label>
            <label><input type="checkbox"> 4. Suplantación de identidad: Hacerse pasar por otra persona sin su consentimiento.</label>
            <label><input type="checkbox"> 5. Spam: Enviar mensajes no solicitados de manera masiva.</label>

            <div class="other-input">
                <label for="other">Otro:</label>
                <input type="text" id="other" class="form-control" style="max-width: 200px;">
            </div>
        </div>

        <!-- Sección de personaje y diálogo -->
        <div class="character-section">
            <img src="character.png" alt="Character" class="character-img">
            
            <!-- Caja de diálogo -->
            <div class="dialog-box">
                HOLA CARDENAL Lamentamos los inconvenientes Genera tu Reporte
                <button class="btn btn-primary btn-sm">Enviar</button>
            </div>
        </div>
    </div>
@endsection