<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    @vite(['resources\js\app.js'])
    <link rel="stylesheet" href="{{ asset('css/degradado.css') }}">
    <!-- Add Font Awesome for better icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- SweetAlert notifications -->
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

    <div class="main-content">
        @yield('Contenido')
    </div>

    <footer class="degradado mt-5 py-3 text-center">
        <div class="container">
            <p class="mb-0">&copy; 2025 Roomies. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>