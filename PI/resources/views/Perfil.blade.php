@extends('layouts.Plantilla1')
@section('titulo','Perfil')
@section('Contenido')
<style>
        .header {
            background-color: #a72828;
            height: 60px;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
            font-size: 18px;
        }
        .profile-container {
            display: flex;
            align-items: flex-start;
            padding: 20px;
        }
        .profile-image {
            width: 120px;
            height: auto;
            margin-right: 20px;
        }
        .edit-icon {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 16px;
            color: white;
            cursor: pointer;
        }
        .house-image {
            width: 80px;
            position: absolute;
            bottom: 30px;
            right: 20px;
        }
        .footer-buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }
</style>

    <!-- Barra superior -->
    <div class="header">
        <div>Perfil de Usuario</div>
        <div class="edit-icon">✏️ Editar perfil usuario</div>
    </div>

    <!-- Contenedor de perfil -->
    <div class="container mt-4">
        <div class="row profile-container">
            <!-- Imagen del perfil -->
            <div class="col-md-3 text-center">
                <img src="perfil.png" alt="Perfil" class="img-fluid profile-image rounded">
                <p class="mt-2 font-weight-bold">NOMBRE: POLI UPQ</p>
            </div>
            
            <!-- Información del usuario -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">NOMBRE: POLI UPQ</h5>
                        <p class="card-text">
                            <strong>Género:</strong> Información del género del usuario.<br>
                            <strong>Edad:</strong> Mostrar la edad.<br>
                            <strong>Teléfono:</strong> Mostrar el número de contacto.<br>
                            <strong>Correo Electrónico:</strong> Mostrar el correo vinculado.<br>
                            <strong>Gustos y Preferencias:</strong> Sección que muestre los gustos y preferencias actuales del usuario.
                        </p>
                        <button class="btn btn-primary btn-sm">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Imagen de casa -->
    <img src="casa.png" alt="Casa" class="house-image">

    <!-- Botones de navegación -->
    <div class="footer-buttons mt-4">
        <a href="#" class="btn btn-info btn-lg">PÁGINA PRINCIPAL</a>
        <a href="#" class="btn btn-info btn-lg">BUSCA UN ROOMIES</a>
    </div>

@endsection