<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    @vite(['resources\js\app.js'])
    <link rel="stylesheet" href="{{ asset('css/degradado.css') }}">
</head>

<body>
@session('Exito')
    <script>
        Swal.fire({
            title: "Respuesta del servidor ",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession
@session('Fallo')
    <script>
        Swal.fire({
            title: "Respuesta del servidor ",
            text: "{{$value}}",
            icon: "error"
        });
    </script>
@endsession
    @yield('Contenido')



</body>

</html>