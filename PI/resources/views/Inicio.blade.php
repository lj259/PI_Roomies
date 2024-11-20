<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    @vite(['resources\js\app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="{{asset('css/inicio.css')}}">
</head>

<body>

    <div class="position-relative vh-100 text-center text-white">



        <div class="d-flex flex-column align-items-center justify-content-center h-100">

            <h1 class="intro-title">POLI ROOMIES</h1>


            <div class="d-flex gap-3 mt-3">
                <a href="{{route('login')}}" class="btn btn-outline-light">INICIA</a>
                <a href="{{route('RutaRegsitroUsuario')}}" class="btn btn-outline-light">REGÍSTRATE</a>
            </div>
        </div>

        <a href="#" class="position-absolute text-dark font-weight-bold" style="bottom: 10px; right: 20px;">¿Quiénes
            somos?</a>
    </div>
    <x-footer />
</body>

</html>