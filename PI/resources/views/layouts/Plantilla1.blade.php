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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    <style>
        .modern-navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
        }
        
        .navbar-brand-modern {
            font-weight: 800;
            font-size: 1.8rem;
            color: white !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .navbar-brand-modern:hover {
            color: #ffd700 !important;
            transform: scale(1.05);
        }
        
        .brand-icon {
            margin-right: 0.5rem;
            font-size: 2rem;
        }
        
        .nav-link-modern {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 600;
            padding: 0.75rem 1.5rem !important;
            border-radius: 25px;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            position: relative;
        }
        
        .nav-link-modern:hover {
            color: white !important;
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }
        
        .nav-link-modern.active-route {
            color: #ffd700 !important;
            background: rgba(255,255,255,0.2);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .nav-icon {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white !important;
            border: none;
            padding: 0.75rem 1.5rem !important;
            border-radius: 25px;
            font-weight: 600;
            margin-left: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .logout-btn:hover {
            background: linear-gradient(135deg, #ff5252, #c62828);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
            color: white !important;
        }
        
        .navbar-toggler-modern {
            border: none;
            padding: 0.5rem;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
        }
        
        .navbar-toggler-modern:focus {
            box-shadow: none;
        }
        
        .navbar-nav-modern {
            align-items: center;
        }
        
        @media (max-width: 991px) {
            .navbar-nav-modern {
                margin-top: 1rem;
            }
            
            .logout-btn {
                margin-left: 0;
                margin-top: 1rem;
                width: fit-content;
            }
            
            .nav-link-modern {
                margin: 0.25rem 0;
            }
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg modern-navbar">
        <div class="container-fluid">
            <a class="navbar-brand-modern" href="{{ route('RutaInicio') }}">
                <i class="fas fa-home brand-icon"></i>
                {{__('Poli-Roomies')}}
            </a>
            
            <button class="navbar-toggler navbar-toggler-modern" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars text-white"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav navbar-nav-modern ms-auto">
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('RutaBusqueda') ? 'active-route' : '' }}" 
                            href="{{ route('RutaBusqueda') }}">
                            <i class="fas fa-search nav-icon"></i>
                            {{__('Búsqueda')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('RutaPerfil') ? 'active-route' : '' }}" 
                            href="{{ route('RutaPerfil') }}">
                            <i class="fas fa-user nav-icon"></i>
                            {{__('Perfil')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('amigos.*') ? 'active-route' : '' }}" 
                            href="{{ route('amigos.index') }}">
                            <i class="fas fa-users nav-icon"></i>
                            {{__('Amigos')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('chat.*') ? 'active-route' : '' }}" 
                            href="{{ route('chat.index') }}">
                            <i class="fas fa-comments nav-icon"></i>
                            {{__('Chat')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('RutaReportes') ? 'active-route' : '' }}" 
                            href="{{ route('RutaReportes') }}">
                            <i class="fas fa-flag nav-icon"></i>
                            {{__('Reportes')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('RutaSugerencias') ? 'active-route' : '' }}" 
                            href="{{ route('RutaSugerencias') }}">
                            <i class="fas fa-flag nav-icon"></i>
                            {{__('Sugerencias')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="logout-btn" href="/logout">
                            <i class="fas fa-sign-out-alt nav-icon"></i>
                            Cerrar sesión
                        </a>
                    </li>
                </ul>

            </div>
            
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

    <!-- Floating Chatbot Icon 
    <div class="chatbot-container">
        <button type="button" class="chatbot-btn" data-bs-toggle="modal" data-bs-target="#miChat" title="Abrir Chat">
            <i class="fas fa-comments"></i>
            <span class="chat-notification">💬</span>
        </button>
    </div> -->

    <style>
        .chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .chatbot-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .chatbot-btn:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }
        
        .chatbot-btn:active {
            transform: translateY(-1px) scale(1.05);
        }
        
        .chat-notification {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ff4757;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }
        
        /* Mobile responsive */
        @media (max-width: 768px) {
            .chatbot-container {
                bottom: 15px;
                right: 15px;
            }
            
            .chatbot-btn {
                width: 55px;
                height: 55px;
                font-size: 1.3rem;
            }
        }
    </style>

    <x-chat id="miChat"></x-chat>
    <x-footer />
    <script>
    if (performance.navigation.type === 2) { 
        location.reload();
    }
    
    </script>
</body>

</html>