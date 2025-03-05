<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    
    @vite(['resources/js/app.js'])
    <!-- Vite for JS and CSS -->
    
    <!-- External Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
</head>

<body>

    <main class="position-relative vh-100 text-center text-white">
        <div class="d-flex flex-column align-items-center justify-content-center h-100">
            <h1 class="intro-title">POLI ROOMIES</h1>

            <img src="" alt="foto logo">

                <a class="btn-tamaño" href="{{ route('login') }}" class="btn btn-outline-light" aria-label="Inicia sesión">INICIA</a>

                <a class="btn-tamaño" href="{{ route('RutaRegistroUsuario') }}" class="btn btn-outline-light" aria-label="Regístrate como usuario">REGÍSTRATE</a>

        </div>

        <a href="#" class="position-absolute text-white font-weight-bold" style="bottom: 10px; left: 20px;" aria-label="Politicas de Privacidad">
        Politicas de Privacidad
        </a>
        <a href="#" class="position-absolute text-white font-weight-bold" style="bottom: 10px; right: 20px;" aria-label="Conoce quiénes somos">
            ¿Quiénes somos?
        </a>
    </main>

    <x-footer />
</body>

</html>
