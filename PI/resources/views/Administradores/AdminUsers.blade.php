@extends('layouts.plantilla_admins')
@section('titulo', 'Gestión de Usuarios')
@section('Contenido')

<style>
    .users-dashboard {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .page-header {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border: none;
    }
    
    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .page-subtitle {
        color: #718096;
        font-size: 1.1rem;
        margin-bottom: 0;
    }
    
    .search-section {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }
    
    .search-container .input-group {
        border-radius: 50px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: none;
    }
    
    .search-container .form-control {
        border: none;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        background-color: #f8fafc;
    }
    
    .search-container .form-control:focus {
        box-shadow: none;
        background-color: white;
        border-color: transparent;
    }
    
    .search-container .input-group-text {
        background-color: #f8fafc;
        border: none;
        padding: 1rem;
    }
    
    .search-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 1rem 1.5rem;
        color: white;
        font-weight: 600;
    }
    
    .search-btn:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .clear-btn {
        background: #e2e8f0;
        border: none;
        color: #64748b;
    }
    
    .clear-btn:hover {
        background: #cbd5e0;
        color: #475569;
    }
    
    .add-user-btn {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        border: none;
        border-radius: 50px;
        padding: 1rem 2rem;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
        transition: all 0.3s ease;
    }
    
    .add-user-btn:hover {
        background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(72, 187, 120, 0.4);
        color: white;
        text-decoration: none;
    }
    
    .user-card {
        background: white;
        border-radius: 15px;
        border: none;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }
    
    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .user-card .card-body {
        padding: 1.5rem;
    }
    
    .profile-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    
    .avatar-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
    }
    
    .user-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.25rem;
    }
    
    .user-role {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .contact-info {
        font-size: 0.9rem;
        color: #64748b;
    }
    
    .contact-info i {
        width: 16px;
        text-align: center;
        margin-right: 0.5rem;
    }
    
    .action-buttons .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        border: none;
        color: white;
    }
    
    .btn-edit:hover {
        background: linear-gradient(135deg, #dd6b20 0%, #c05621 100%);
        transform: translateY(-1px);
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        border: none;
        color: white;
    }
    
    .btn-delete:hover {
        background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
        transform: translateY(-1px);
        color: white;
    }
    
    .alert-modern {
        border: none;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-weight: 500;
    }
    
    .alert-info-modern {
        background: linear-gradient(135deg, #63b3ed 0%, #4299e1 100%);
        color: white;
    }
    
    .alert-warning-modern {
        background: linear-gradient(135deg, #fbb036 0%, #f6ad55 100%);
        color: white;
    }
    
    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }
    
    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .stats-label {
        color: #64748b;
        font-weight: 500;
        margin-top: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .user-card .row > div {
            margin-bottom: 1rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .action-buttons .btn {
            flex: 1;
            font-size: 0.8rem;
        }
    }
</style>

@session('Exito')
    <script>
        Swal.fire({
            title: "¡Éxito!",
            text: '{{$value}}',
            icon: "success",
            confirmButtonColor: "#667eea"
        });
    </script>
@endsession

<div class="users-dashboard">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="page-title">
                        <i class="bi bi-people-fill me-2"></i>
                        Gestión de Usuarios
                    </h1>
                    <p class="page-subtitle">Administra todas las cuentas de usuario del sistema</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="stats-card d-inline-block">
                        <div class="stats-number">{{ count($consulta) }}</div>
                        <div class="stats-label">{{ count($consulta) == 1 ? 'Usuario' : 'Usuarios' }} {{ request('search') ? 'encontrado' . (count($consulta) == 1 ? '' : 's') : 'registrado' . (count($consulta) == 1 ? '' : 's') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Search Section -->
        <div class="search-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <form method="GET" action="{{ route('RutaAdminUsers') }}" id="searchForm">
                        <div class="input-group search-container">
                            <span class="input-group-text">
                                <i class="bi bi-search text-primary"></i>
                            </span>
                            <input type="text" id="searchInput" name="search" class="form-control" 
                                   placeholder="Buscar por nombre, correo o teléfono..." 
                                   value="{{ request('search') }}">
                            <button class="btn clear-btn" type="button" id="clearSearch">
                                <i class="bi bi-x-circle"></i>
                            </button>
                            <button class="btn search-btn" type="submit">
                                <i class="bi bi-search me-1"></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{route('RutaRegistroUsuario')}}" class="add-user-btn text-decoration-none">
                        <i class="bi bi-person-plus-fill me-2"></i>
                        Nuevo Usuario
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Results Info -->
        @if(request('search'))
            <div class="alert alert-info-modern alert-modern">
                <i class="bi bi-info-circle me-2"></i>
                Mostrando resultados para: "<strong>{{ request('search') }}</strong>"
                <a href="{{ route('RutaAdminUsers') }}" class="btn btn-sm btn-light ms-2 text-decoration-none" style="border-radius: 20px;">
                    <i class="bi bi-x"></i> Limpiar búsqueda
                </a>
            </div>
        @endif

        <!-- No Results Message -->
        @if(count($consulta) == 0)
            <div class="alert alert-warning-modern alert-modern text-center">
                <i class="bi bi-exclamation-triangle me-2"></i>
                @if(request('search'))
                    No se encontraron usuarios que coincidan con "{{ request('search') }}".
                @else
                    No hay usuarios registrados en el sistema.
                @endif
            </div>
        @endif

        <!-- Users List -->
        <div class="row">
            @foreach ($consulta as $usuario)        
            <div class="col-12">
                <div class="card user-card" 
                     data-name="{{strtolower($usuario->nombre . ' ' . ($usuario->apellido_paterno ?? '') . ' ' . ($usuario->apellido_materno ?? ''))}}" 
                     data-email="{{strtolower($usuario->correo)}}" 
                     data-phone="{{$usuario->telefono}}">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <!-- User Avatar and Name -->
                            <div class="col-md-5">
                                <div class="d-flex align-items-center">
                                    @if($usuario->foto_perfil)
                                        <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" 
                                             alt="Foto de perfil" 
                                             class="profile-avatar me-3">
                                    @else
                                        <div class="avatar-placeholder me-3">
                                            {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="user-name">
                                            {{$usuario->nombre}} 
                                            @if($usuario->apellido_paterno)
                                                {{ $usuario->apellido_paterno }}
                                            @endif
                                            @if($usuario->apellido_materno)
                                                {{ $usuario->apellido_materno }}
                                            @endif
                                        </div>
                                        <span class="user-role">
                                            <i class="bi bi-shield-check me-1"></i>
                                            {{ ucfirst($usuario->rol) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Contact Information -->
                            <div class="col-md-5">
                                <div class="contact-info">
                                    <div class="mb-2">
                                        <i class="bi bi-envelope-fill text-primary"></i>
                                        <span class="text-truncate">{{$usuario->correo}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <i class="bi bi-telephone-fill text-success"></i>
                                        <span>{{$usuario->telefono ?? 'No especificado'}}</span>
                                    </div>
                                    @if($usuario->genero)
                                        <div>
                                            <i class="bi bi-person-fill text-info"></i>
                                            <span>{{ ucfirst($usuario->genero) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="col-md-2">
                                <div class="action-buttons d-flex flex-column gap-2">
                                    <a href="{{route('usuarioEditar',['id'=>$usuario->id])}}" class="btn btn-edit btn-sm">
                                        <i class="bi bi-pencil-fill me-1"></i> Editar
                                    </a>
                                    <form action="{{ route('EliminacionUsuario', ['id' => $usuario->id]) }}" method="post" class="deleteUserForm" data-user-id="{{$usuario->id}}">
                                        @csrf
                                        <button type="submit" class="btn btn-delete btn-sm w-100">
                                            <i class="bi bi-trash-fill me-1"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Clear search functionality
        document.getElementById('clearSearch').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.getElementById('searchForm').submit();
        });
        
        // Enhanced delete confirmation
        document.querySelectorAll('.deleteUserForm').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e53e3e',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    background: 'white',
                    borderRadius: '15px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
        
        // Real-time search filtering (optional enhancement)
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const userCards = document.querySelectorAll('.user-card');
            
            userCards.forEach(card => {
                const name = card.getAttribute('data-name');
                const email = card.getAttribute('data-email');
                const phone = card.getAttribute('data-phone') || '';
                
                if (name.includes(searchTerm) || email.includes(searchTerm) || phone.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>

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