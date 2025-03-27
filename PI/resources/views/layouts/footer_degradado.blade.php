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
    
    <style>
        /* Avatar upload styles */
        .avatar-upload {
            position: relative;
            max-width: 125px;
            margin: 0 auto;
        }
        
        .avatar-edit {
            position: absolute;
            right: 0;
            bottom: 0;
            z-index: 1;
        }
        
        .avatar-edit input {
            display: none;
        }
        
        .avatar-edit label {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #4e73df;
            border: 1px solid transparent;
            color: white;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease-in-out;
        }
        
        .avatar-edit label:hover {
            background: #3a5bc7;
        }
        
        .avatar-preview {
            width: 125px;
            height: 125px;
            position: relative;
            border-radius: 50%;
            border: 3px solid #4e73df;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .avatar-preview > div {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
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