@extends('layouts.plantilla_admins')
@section('titulo', 'Gestión de Usuarios')
@section('Contenido')

<style>
    .user-card {
        transition: all 0.3s ease;
    }
    
    .user-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15) !important;
    }
    
    .search-container .input-group {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .search-container .form-control:focus {
        box-shadow: none;
        border-color: transparent;
    }
    
    .btn-hover-effect {
        transition: all 0.3s ease;
    }
    
    .btn-hover-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .profile-avatar {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .user-card .card-body {
        padding: 1rem !important;
    }
    
    .user-card .btn {
        font-size: 0.8rem;
        padding: 0.375rem 0.75rem;
    }
    
    @media (max-width: 768px) {
        .user-card .row > div {
            margin-bottom: 0.5rem;
        }
        
        .user-card .col-md-2 .d-flex {
            flex-direction: row !important;
            gap: 0.5rem !important;
        }
        
        .user-card .col-md-2 .btn {
            flex: 1;
        }
    }
</style>

@session('Exito')
    <script>
        Swal.fire({
            title: "Registro correcto",
            text: '{{$value}}',
            icon: "success"
        });
    </script>
@endsession
<main class="container-fluid vh-100 p-0">

        <!-- Contenido principal -->
        <div class="container-fluid p-4" style="background-color: #f8f9fa;">
            <h3 class="text-center mb-4 text-dark">Gestión de Usuarios</h3>
            
            <!-- Barra de búsqueda -->
            <div class="row mb-4">
                <div class="col-md-8 mx-auto search-container">
                    <form method="GET" action="{{ route('RutaAdminUsers') }}" id="searchForm">
                        <div class="input-group" style="border-radius: 25px; overflow: hidden;">
                            <span class="input-group-text bg-white border-0"><i class="bi bi-search text-primary"></i></span>
                            <input type="text" id="searchInput" name="search" class="form-control border-0" 
                                   placeholder="Buscar por nombre completo, correo o teléfono..." 
                                   value="{{ request('search') }}"
                                   style="box-shadow: none;">
                            <button class="btn btn-outline-secondary border-0 bg-white" type="button" id="clearSearch">
                                <i class="bi bi-x-circle text-muted"></i>
                            </button>
                            <button class="btn btn-primary border-0 btn-hover-effect" type="submit" style="border-radius: 0 25px 25px 0;">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <a href="{{route('RutaRegistroUsuario')}}" class="btn btn-success shadow-sm w-100 py-3 mb-4 btn-hover-effect" style="border-radius: 15px; font-weight: 600;">
                        <i class="bi bi-person-plus-fill"></i> Registrar Nuevo Usuario
                    </a>
                </div>
            </div>

            @if(request('search'))
                <div class="alert alert-info shadow-sm" style="border-radius: 15px; border: none;">
                    <i class="bi bi-info-circle"></i>
                    Mostrando resultados para: "<strong>{{ request('search') }}</strong>"
                    <a href="{{ route('RutaAdminUsers') }}" class="btn btn-sm btn-outline-info ms-2" style="border-radius: 20px;">
                        <i class="bi bi-x"></i> Limpiar búsqueda
                    </a>
                </div>
            @endif

            @if(count($consulta) == 0)
                <div class="alert alert-warning text-center shadow-sm" style="border-radius: 15px; border: none;">
                    <i class="bi bi-exclamation-triangle"></i>
                    @if(request('search'))
                        No se encontraron usuarios que coincidan con "{{ request('search') }}".
                    @else
                        No hay usuarios registrados en el sistema.
                    @endif
                </div>
            @endif

            @foreach ($consulta as $usuario)        
            <div class="card shadow-sm mb-3 user-card" data-name="{{strtolower($usuario->nombre . ' ' . ($usuario->apellido_paterno ?? '') . ' ' . ($usuario->apellido_materno ?? ''))}}" data-email="{{strtolower($usuario->correo)}}" data-phone="{{$usuario->telefono}}" style="border-radius: 12px; border: none;">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <!-- Avatar y nombre -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                @if($usuario->foto_perfil)
                                    <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" 
                                         alt="Foto de perfil" 
                                         class="rounded-circle me-3 profile-avatar" 
                                         style="width: 45px; height: 45px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle me-3 d-flex align-items-center justify-content-center profile-avatar" 
                                         style="width: 45px; height: 45px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: bold; font-size: 16px;">
                                        {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-primary fw-bold">
                                        {{$usuario->nombre}} 
                                        @if($usuario->apellido_paterno)
                                            {{ $usuario->apellido_paterno }}
                                        @endif
                                        @if($usuario->apellido_materno)
                                            {{ $usuario->apellido_materno }}
                                        @endif
                                    </h6>
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="bi bi-shield-check me-1"></i>
                                        {{ ucfirst($usuario->rol) }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información de contacto -->
                        <div class="col-md-4">
                            <div class="small">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="bi bi-envelope-fill text-primary me-2" style="font-size: 0.8rem;"></i>
                                    <span class="text-truncate">{{$usuario->correo}}</span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="bi bi-telephone-fill text-success me-2" style="font-size: 0.8rem;"></i>
                                    <span>{{$usuario->telefono ?? 'No especificado'}}</span>
                                </div>
                                @if($usuario->genero)
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-fill text-info me-2" style="font-size: 0.8rem;"></i>
                                        <span class="text-muted">{{ ucfirst($usuario->genero) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="col-md-2">
                            <div class="d-flex flex-column gap-1">
                                <a href="{{route('usuarioEditar',['id'=>$usuario->id])}}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>
                                <form action="{{ route('EliminacionUsuario', ['id' => $usuario->id]) }}" method="post" class="deleteUserForm" data-user-id="{{$usuario->id}}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="bi bi-trash-fill"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Mensaje cuando no hay resultados -->
        <div id="noResults" class="text-center mt-4" style="display: none;">
            <div class="alert alert-info shadow-sm" style="border-radius: 15px; border: none;">
                <i class="bi bi-search"></i>
                <p class="mb-0">No se encontraron usuarios que coincidan con tu búsqueda.</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <a href="{{ route('RutaHomeAdmin') }}" class="btn btn-secondary shadow-sm w-100 py-3 btn-hover-effect" style="border-radius: 15px; font-weight: 600;">
                    <i class="bi bi-arrow-left"></i> Volver al Panel de Administración
                </a>
            </div>
        </div>
            </div>
        </div>
  
</main>
<script>
    // Funcionalidad de búsqueda en tiempo real (cliente)
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        const userCards = document.querySelectorAll('.user-card');
        const noResults = document.getElementById('noResults');
        let visibleCards = 0;

        userCards.forEach(function(card) {
            const name = card.getAttribute('data-name');
            const email = card.getAttribute('data-email');
            const phone = card.getAttribute('data-phone');
            
            // Buscar en nombre, email o teléfono
            if (name.includes(searchTerm) || email.includes(searchTerm) || phone.includes(searchTerm)) {
                card.style.display = 'block';
                visibleCards++;
            } else {
                card.style.display = 'none';
            }
        });

        // Mostrar mensaje de "no resultados" si no hay tarjetas visibles
        if (visibleCards === 0 && searchTerm !== '') {
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
        }
    });

    // Limpiar búsqueda
    document.getElementById('clearSearch').addEventListener('click', function() {
        document.getElementById('searchInput').value = '';
        const userCards = document.querySelectorAll('.user-card');
        const noResults = document.getElementById('noResults');
        
        userCards.forEach(function(card) {
            card.style.display = 'block';
        });
        
        noResults.style.display = 'none';
        
        // Redirigir a la página sin parámetros de búsqueda
        window.location.href = "{{ route('RutaAdminUsers') }}";
    });

    // Función para confirmar eliminación para todos los formularios
    document.addEventListener('DOMContentLoaded', function() {
        const deleteUserForms = document.querySelectorAll('.deleteUserForm');
        
        deleteUserForms.forEach(function(form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Previene el envío inmediato del formulario

                Swal.fire({
                    title: '¿Seguro que desea eliminar el registro?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: '¡Sí, eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Envía el formulario si se confirma
                    }
                });
            });
        });
    });
</script>

@endsection