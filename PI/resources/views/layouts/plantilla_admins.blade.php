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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{asset('css/plantilla_admins.css')}}">
    <style>
        html,body{
            height: 100%;
            margin: 0;
        }
        .contenido_espacio{
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .espacio_contenedor{
            flex: 1;
        }
    </style>
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
    <div class="contenido_espacio">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-custom bg_nav">
                <div class="container-fluid">
                    <a class="navbar-brand text-light" href="{{ route('RutaInicio') }}">{{__('Poli-Roomies')}}</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
        
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
        
                            <li>
                                <a class="nav-link active {{ request()->routeIs('RutaPanelAdmin') ? "text-info" : "text-light" }} "
                                    href="{{ route('RutaPanelAdmin',['id'=> request()->route('id')]) }}">{{__('Panel')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active {{ request()->routeIs('RutaRoles') ? "text-info" : "text-light" }}"
                                    aria-current="page" href="{{ route('RutaRoles') }}">{{__('Roles')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active {{ request()->routeIs('RutaRegistroActividad') ? "text-info" : "text-light" }} "
                                    href="{{ route('RutaRegistroActividad') }}">{{__('Actividad')}}</a>
                            </li>
                            <li>
                                <a class="nav-link active {{ request()->routeIs('RutaAdminUsers') ? "text-info" : "text-light" }} "
                                    href="{{ route('RutaAdminUsers',['id'=> request()->route('id')])  }}">{{__('Usuarios')}}</a>
                            </li>
                            <li>
                                <a class="nav-link active {{ request()->routeIs('RutaRegDeparta') ? "text-info" : "text-light" }} "
                                    href="{{ route('RutaRegDeparta') }}">{{__('Departamentos')}}</a>
                            </li>
                            <li>
                                <a class="nav-link active {{ request()->routeIs('RutaRegistroAvisos') ? "text-info" : "text-light" }} "
                                    href="{{ route('RutaRegistroAvisos') }}">{{__('Avisos')}}</a>
                            </li>
                            <li>
                                <a class="nav-link active {{ request()->routeIs('propietarios.index') ? "text-info" : "text-light" }} "
                                    href="{{ route('propietarios.index') }}">{{__('Propietarios')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
 
        @yield('Contenido')
        <x-footer />
    </div>

    <script>
    if (performance.navigation.type === 2) { 
        location.reload();
    }
    </script>
</body>

</html>