<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>

    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    @session('Exito')
    <script>
        Swal.fire({
            title: "Respuesta del servidor",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
    @endsession
    @session('Fallo')
    <script>
        Swal.fire({
            title: "Respuesta del servidor",
            text: "{{$value}}",
            icon: "error"
        });
    </script>
    @endsession

    <main class="position-relative vh-100 text-center text-white">
        <div class="d-flex flex-column align-items-center justify-content-center h-100">
            <h1 class="intro-title">POLI ROOMIES</h1>

            <img src="\images\Polo-Poli.png" alt="foto logo" class="img-fluid">

            <div class="d-grid gap-2 col-md-6 mx-auto mt-4">
                <a class="btn btn-outline-primary text-white" href="{{ route('login') }}" aria-label="Inicia sesión">INICIAR SESIÓN</a>
                <a class="btn btn-outline-primary text-white" href="{{ route('RutaRegistroUsuario') }}" aria-label="Regístrate como usuario">REGÍSTRATE</a>
            </div>
        </div>

        <div class="position-absolute bottom-0 start-0 mb-3 ms-3">
            <a href="#" class="text-white font-weight-bold" aria-label="Politicas de Privacidad">
                Politicas de Privacidad
            </a>
        </div>
        <div class="position-absolute bottom-0 end-0 mb-3 me-3">
            <a href="#" class="text-white font-weight-bold" aria-label="Conoce quiénes somos">
                ¿Quiénes somos?
            </a>
        </div>
    </main>

    <x-footer />
</body>

</html>