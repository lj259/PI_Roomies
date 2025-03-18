<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources\js\app.js'])
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <title>Panel Administrativo</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('admin.home') }}">Admin Panel</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.logout') }}">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>



 
