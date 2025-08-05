@extends('layouts.plantilla_admins')
@section('titulo', 'Gestión de Roles y Permisos')
@section('Contenido')

<style>
    .roles-dashboard {
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
    
    .roles-table-container {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border: none;
    }
    
    .modern-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }
    
    .modern-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .modern-table thead th {
        padding: 1.25rem 1rem;
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }
    
    .modern-table tbody tr {
        background: white;
        transition: all 0.3s ease;
    }
    
    .modern-table tbody tr:hover {
        background: #f8fafc;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .modern-table tbody td {
        padding: 1rem;
        border-top: 1px solid #e2e8f0;
        border-bottom: none;
        vertical-align: middle;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 0.75rem;
    }
    
    .user-info {
        display: flex;
        align-items: center;
    }
    
    .user-name {
        font-weight: 600;
        color: #2d3748;
        font-size: 1rem;
    }
    
    .role-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .role-admin {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .role-usuario {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .role-propietario {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }
    
    .btn-edit-role {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(237, 137, 54, 0.3);
    }
    
    .btn-edit-role:hover {
        background: linear-gradient(135deg, #dd6b20 0%, #c05621 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(237, 137, 54, 0.4);
        color: white;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #64748b;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .stat-admin .stat-number {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .stat-usuarios .stat-number {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .stat-propietarios .stat-number {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Modal Improvements */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        border-bottom: none;
        padding: 1.5rem 2rem;
    }
    
    .modal-title {
        font-weight: 600;
        font-size: 1.3rem;
    }
    
    .modal-body {
        padding: 2rem;
    }
    
    .modal-footer {
        border-top: 1px solid #e2e8f0;
        padding: 1.5rem 2rem;
    }
    
    .btn-close {
        filter: brightness(0) invert(1);
    }
    
    .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .btn-save {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        border: none;
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
    }
    
    .btn-save:hover {
        background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
        color: white;
    }
    
    .btn-cancel {
        background: #e2e8f0;
        border: none;
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        color: #64748b;
        font-weight: 600;
    }
    
    .btn-cancel:hover {
        background: #cbd5e0;
        color: #475569;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .modern-table {
            font-size: 0.85rem;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

<div class="roles-dashboard">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title">
                        <i class="bi bi-person-gear me-2"></i>
                        Gestión de Roles y Permisos
                    </h1>
                    <p class="page-subtitle">Administra los roles y permisos de todos los usuarios del sistema</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('RutaAdminUsers') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Volver a Usuarios
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card stat-admin">
                <div class="stat-number">{{ $usuarios->where('rol', 'admin')->count() }}</div>
                <div class="stat-label">Administradores</div>
            </div>
            <div class="stat-card stat-usuarios">
                <div class="stat-number">{{ $usuarios->where('rol', 'usuario')->count() }}</div>
                <div class="stat-label">Usuarios</div>
            </div>
            <div class="stat-card stat-propietarios">
                <div class="stat-number">{{ $usuarios->where('rol', 'propietario')->count() }}</div>
                <div class="stat-label">Propietarios</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $usuarios->count() }}</div>
                <div class="stat-label">Total de Usuarios</div>
            </div>
        </div>
        
        <!-- Users Table -->
        <div class="roles-table-container">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Rol Actual</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $u)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($u->nombre, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="user-name">{{ $u->nombre }}</div>
                                            <small class="text-muted">ID: {{ $u->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $u->apellido_paterno ?? '-' }}</td>
                                <td>{{ $u->apellido_materno ?? '-' }}</td>
                                <td>
                                    <span class="role-badge role-{{ $u->rol }}">
                                        @if($u->rol == 'admin')
                                            <i class="bi bi-shield-check me-1"></i>Administrador
                                        @elseif($u->rol == 'propietario')
                                            <i class="bi bi-house-door me-1"></i>Propietario
                                        @else
                                            <i class="bi bi-person me-1"></i>Usuario
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-edit-role" data-bs-toggle="modal"
                                        data-bs-target="#editarRolModal" data-user-id="{{ $u->id }}"
                                        data-user-name="{{ $u->nombre }} {{ $u->apellido_paterno }} {{ $u->apellido_materno }}"
                                        data-user-rol="{{ $u->rol }}">
                                        <i class="bi bi-pencil me-1"></i>Editar Rol
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Modal -->
<div class="modal fade" id="editarRolModal" tabindex="-1" aria-labelledby="editarRolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="editarRolModalLabel">
                    <i class="bi bi-person-gear me-2"></i>
                    Editar Rol de Usuario
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarRol" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="modalUserId">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted">Usuario Seleccionado:</label>
                        <div class="p-3 bg-light rounded-3">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    <span id="modalUserInitial"></span>
                                </div>
                                <div>
                                    <div class="fw-bold" id="modalUserName"></div>
                                    <small class="text-muted">Cambiar permisos de acceso</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modalUserRol" class="form-label fw-bold">
                            <i class="bi bi-shield-check me-2"></i>
                            Nuevo Rol:
                        </label>
                        <select class="form-select" name="nuevo_rol" id="modalUserRol">
                            <option value="admin">
                                <i class="bi bi-shield-check"></i> Administrador - Acceso completo al sistema
                            </option>
                            <option value="usuario">
                                <i class="bi bi-person"></i> Usuario - Acceso limitado a funciones básicas
                            </option>
                            <option value="propietario">
                                <i class="bi bi-house-door"></i> Propietario - Gestión de propiedades
                            </option>
                        </select>
                        <div class="form-text">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Los cambios se aplicarán inmediatamente después de guardar.
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-save">
                        <i class="bi bi-check-circle me-2"></i>
                        Guardar Cambios
                    </button>
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editarRolModal = document.getElementById('editarRolModal');

        editarRolModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            const userRol = button.getAttribute('data-user-rol');

            // Actualizar el modal
            document.getElementById('modalUserName').textContent = userName;
            document.getElementById('modalUserInitial').textContent = userName.charAt(0).toUpperCase();
            document.getElementById('modalUserRol').value = userRol;
            document.getElementById('modalUserId').value = userId;

            // Actualizar el action del formulario
            const form = document.getElementById('formEditarRol');
            const editRoute = "{{ route('RolesEdit', ['usuario' => '--ID--']) }}".replace('--ID--', userId);
            form.action = editRoute;
        });
        
        // Form submission with confirmation
        document.getElementById('formEditarRol').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const userName = document.getElementById('modalUserName').textContent;
            const newRole = document.getElementById('modalUserRol').value;
            
            Swal.fire({
                title: '¿Confirmar cambio de rol?',
                html: `¿Estás seguro de cambiar el rol de <strong>${userName}</strong> a <strong>${newRole}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Sí, cambiar rol',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>

@endsection