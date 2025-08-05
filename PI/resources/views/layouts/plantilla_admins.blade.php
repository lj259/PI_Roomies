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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        html, body {
            height: 100%;
            margin: 0;
            background-color: #f8fafc;
        }
        
        .contenido_espacio {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .espacio_contenedor {
            flex: 1;
        }
        
        /* Modern Navigation Styles */
        .modern-navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            border: none;
            padding: 0.5rem 0;
        }
        
        .modern-navbar .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        .modern-navbar .navbar-nav {
            align-items: center;
        }
        
        .modern-navbar .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            margin: 0 0.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .modern-navbar .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }
        
        .modern-navbar .nav-link.text-info {
            background-color: rgba(255, 255, 255, 0.2);
            color: white !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .modern-navbar .nav-link i {
            margin-right: 0.5rem;
        }
        
        /* Logout button special styling */
        .modern-navbar .nav-link[href="/logout"] {
            background-color: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        
        .modern-navbar .nav-link[href="/logout"]:hover {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 991px) {
            .modern-navbar .navbar-nav {
                background-color: rgba(0, 0, 0, 0.1);
                border-radius: 10px;
                padding: 1rem;
                margin-top: 1rem;
            }
            
            .modern-navbar .nav-link {
                margin: 0.2rem 0;
                border-radius: 8px;
                padding: 0.75rem 1rem !important;
            }
        }
        
        /* Notification and alert improvements */
        .swal2-popup {
            font-family: 'Inter', sans-serif !important;
            border-radius: 15px !important;
        }
        
        /* Content area styling */
        .admin-content {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: calc(100vh - 80px);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
    </style>
</head>

<body>
@session('Exito')
    <script>
        Swal.fire({
            title: "¡Éxito!",
            text: "{{$value}}",
            icon: "success",
            confirmButtonColor: "#667eea",
            timer: 3000,
            timerProgressBar: true
        });
    </script>
@endsession

@session('Fallo')
    <script>
        Swal.fire({
            title: "Error",
            text: "{{$value}}",
            icon: "error",
            confirmButtonColor: "#dc3545",
            timer: 3000,
            timerProgressBar: true
        });
    </script>
@endsession

<div class="contenido_espacio">
    <nav class="navbar navbar-expand-lg modern-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('RutaInicio') }}">
                <i class="bi bi-house-heart-fill me-2"></i>
                {{__('Poli-Roomies Admin')}}
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list text-white" style="font-size: 1.5rem;"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('RutaPanelAdmin') ? 'text-info' : '' }}" 
                           href="{{ route('RutaPanelAdmin',['id'=> request()->route('id')]) }}">
                            <i class="bi bi-speedometer2"></i>
                            {{__('Panel')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('RutaRoles') ? 'text-info' : '' }}"
                           href="{{ route('RutaRoles') }}">
                            <i class="bi bi-person-gear"></i>
                            {{__('Roles')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('RutaRegistroActividad') ? 'text-info' : '' }}" 
                           href="{{ route('RutaRegistroActividad') }}">
                            <i class="bi bi-activity"></i>
                            {{__('Actividad')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('RutaAdminUsers') ? 'text-info' : '' }}" 
                           href="{{ route('RutaAdminUsers',['id'=> request()->route('id')])  }}">
                            <i class="bi bi-people"></i>
                            {{__('Usuarios')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('Ruta_gestion_depas') ? 'text-info' : '' }}" 
                           href="{{ route('Ruta_gestion_depas') }}">
                            <i class="bi bi-building"></i>
                            {{__('Departamentos')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('propietarios.index') ? 'text-info' : '' }}" 
                           href="{{ route('propietarios.index') }}">
                            <i class="bi bi-person-badge"></i>
                            {{__('Propietarios')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">
                            <i class="bi bi-box-arrow-right"></i>
                            Cerrar sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="admin-content espacio_contenedor">
        @yield('Contenido')
    </div>
    
    <x-footer />
</div>

<script>
    if (performance.navigation.type === 2) { 
        location.reload();
    }
    
    // Enhanced navigation interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Add ripple effect to nav links
        const navLinks = document.querySelectorAll('.modern-navbar .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    left: ${x}px;
                    top: ${y}px;
                    transform: scale(0);
                    animation: ripple 0.6s ease-out;
                    pointer-events: none;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });
    });
</script>

<style>
    @keyframes ripple {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
</style>

</body>
</html>