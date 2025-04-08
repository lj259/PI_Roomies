<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    @vite(['resources\js\app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/plantilla1.css')}}">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg_nav">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="{{ route('RutaInicio') }}">{{__('Poli-Roomies')}}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active {{ request()->routeIs('RutaBusqueda') ? 'text-info' : 'text-light' }} "
                            href="{{ route('RutaBusqueda') }}">{{__('Búsqueda')}}</a>
                    </li>
                    <li>
                        <a class="nav-link active {{ request()->routeIs('RutaPerfil') ? 'text-info' : 'text-light' }} "
                            href="{{ route('RutaPerfil') }}">{{__('Perfil')}}</a>
                    </li>
                    <li>
                        <a class="nav-link active {{ request()->routeIs('RutaReportes') ? 'text-info' : 'text-light' }} "
                            href="{{ route('RutaReportes') }}">{{__('Reportes')}}</a>
                    </li>
                </ul>
                <li>
                    <a class="nav-link active {{ request()->routeIs('logout') ? "text-info" : "text-light" }} "
                    href="/logout">Cerrar sesión</a>
                </li>
            </div>
        </div>
    </nav>
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

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miChat">Abrir Chat</button>
    <x-chat id="miChat"></x-chat>
    <x-footer />
    <script>
    if (performance.navigation.type === 2) { 
        location.reload();
    }
    
    </script>
</body>

</html>