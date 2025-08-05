@extends('layouts.plantilla_admins')
@section('titulo', 'Registro de Actividad')
@section('Contenido')

<style>
    .activity-dashboard {
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
    
    .activity-table-container {
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
        border-bottom: 1px solid #e2e8f0;
    }
    
    .modern-table tbody tr:hover {
        background: #f8fafc;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .modern-table tbody tr.selected {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-left: 4px solid #667eea;
    }
    
    .modern-table tbody td {
        padding: 1rem;
        border: none;
        vertical-align: middle;
    }
    
    .activity-type-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .activity-login {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .activity-create {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }
    
    .activity-edit {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }
    
    .activity-delete {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .user-info {
        display: flex;
        align-items: center;
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
        font-size: 0.9rem;
    }
    
    .user-details {
        flex: 1;
    }
    
    .user-email {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.9rem;
    }
    
    .user-role {
        font-size: 0.8rem;
        color: #64748b;
    }
    
    .activity-description {
        color: #4a5568;
        line-height: 1.5;
        font-size: 0.9rem;
    }
    
    .activity-timestamp {
        font-size: 0.8rem;
        color: #64748b;
        display: block;
        margin-top: 0.25rem;
    }
    
    .btn-edit-activity {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(237, 137, 54, 0.3);
    }
    
    .btn-edit-activity:hover {
        background: linear-gradient(135deg, #dd6b20 0%, #c05621 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(237, 137, 54, 0.4);
        color: white;
    }
    
    .action-buttons {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        margin-top: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        text-align: center;
    }
    
    .btn-delete-selected {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        margin-right: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(245, 101, 101, 0.3);
    }
    
    .btn-delete-selected:hover {
        background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 101, 101, 0.4);
        color: white;
    }
    
    .btn-save-changes {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
    }
    
    .btn-save-changes:hover {
        background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(72, 187, 120, 0.4);
        color: white;
    }
    
    .selection-info {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 1px solid rgba(102, 126, 234, 0.2);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        display: none;
    }
    
    .selection-info.show {
        display: block;
    }
    
    .stats-row {
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .stat-label {
        color: #64748b;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .modern-table {
            font-size: 0.85rem;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 0.75rem 0.5rem;
        }
        
        .btn-delete-selected,
        .btn-save-changes {
            width: 100%;
            margin: 0.5rem 0;
        }
    }
</style>

@session('eliminar')
    <script>
        Swal.fire({
            title: "¡Actividad Eliminada!",
            text: "{{$value}}",
            icon: "success",
            confirmButtonColor: "#667eea"
        });
    </script>
@endsession

@session('guardado')
    <script>
        Swal.fire({
            title: "¡Cambios Guardados!",
            text: "{{$value}}",
            icon: "success",
            confirmButtonColor: "#667eea"
        });
    </script>
@endsession

<div class="activity-dashboard">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title">
                        <i class="bi bi-activity me-2"></i>
                        Registro de Actividad
                    </h1>
                    <p class="page-subtitle">Monitorea y gestiona todas las actividades del sistema</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" onclick="exportActivities()">
                            <i class="bi bi-download me-2"></i>
                            Exportar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-number">247</div>
                <div class="stat-label">Actividades Hoy</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">1,523</div>
                <div class="stat-label">Total del Mes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">89</div>
                <div class="stat-label">Usuarios Activos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">12</div>
                <div class="stat-label">Errores Detectados</div>
            </div>
        </div>
        
        <!-- Search Section -->
        <div class="search-section">
            <form method="POST" action="/ValidarRegActividad" id="activityForm">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="input-group search-container">
                            <span class="input-group-text">
                                <i class="bi bi-search text-primary"></i>
                            </span>
                            <input type="text" name="bucarActividad" class="form-control" 
                                   placeholder="Buscar actividades por usuario, tipo o descripción..." 
                                   value="{{ old('bucarActividad') }}">
                            <button class="btn search-btn" type="submit">
                                <i class="bi bi-search me-1"></i> Buscar
                            </button>
                        </div>
                        @error('bucarActividad')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="d-flex justify-content-end gap-2">
                            <select class="form-select" style="width: auto;" id="filterType">
                                <option value="">Todos los tipos</option>
                                <option value="login">Inicios de sesión</option>
                                <option value="create">Creaciones</option>
                                <option value="edit">Ediciones</option>
                                <option value="delete">Eliminaciones</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Selection Info -->
        <div class="selection-info" id="selectionInfo">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <i class="bi bi-info-circle me-2"></i>
                    <span id="selectedCount">0</span> actividades seleccionadas
                </div>
                <button class="btn btn-sm btn-outline-secondary" onclick="clearSelection()">
                    <i class="bi bi-x"></i> Limpiar selección
                </button>
            </div>
        </div>
        
        <!-- Activities Table -->
        <div class="activity-table-container">
            <div class="table-responsive">
                <table class="modern-table" id="activitiesTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>Usuario</th>
                            <th>Tipo de Actividad</th>
                            <th>Descripción</th>
                            <th>Fecha/Hora</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input activity-checkbox" value="1">
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">A</div>
                                    <div class="user-details">
                                        <div class="user-email">admin@ejemplo.com</div>
                                        <div class="user-role">Administrador</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="activity-type-badge activity-login">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>
                                    Inicio de sesión
                                </span>
                            </td>
                            <td>
                                <div class="activity-description">
                                    Usuario admin inició sesión desde IP 192.168.1.100
                                    <span class="activity-timestamp">Hace 2 minutos</span>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    05/08/2025
                                    <br>
                                    <i class="bi bi-clock me-1"></i>
                                    14:32:15
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-edit-activity btn-sm" onclick="editActivity(1)">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input activity-checkbox" value="2">
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">A</div>
                                    <div class="user-details">
                                        <div class="user-email">admin@ejemplo.com</div>
                                        <div class="user-role">Administrador</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="activity-type-badge activity-create">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Creación de usuario
                                </span>
                            </td>
                            <td>
                                <div class="activity-description">
                                    Se creó el usuario Juan Pérez con rol de propietario
                                    <span class="activity-timestamp">Hace 15 minutos</span>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    05/08/2025
                                    <br>
                                    <i class="bi bi-clock me-1"></i>
                                    14:17:43
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-edit-activity btn-sm" onclick="editActivity(2)">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input activity-checkbox" value="3">
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">A</div>
                                    <div class="user-details">
                                        <div class="user-email">admin@ejemplo.com</div>
                                        <div class="user-role">Administrador</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="activity-type-badge activity-edit">
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Edición de departamento
                                </span>
                            </td>
                            <td>
                                <div class="activity-description">
                                    Se editaron los datos del departamento "Apartamento Centro" - Cambios en precio y disponibilidad
                                    <span class="activity-timestamp">Hace 1 hora</span>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    05/08/2025
                                    <br>
                                    <i class="bi bi-clock me-1"></i>
                                    13:25:12
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-edit-activity btn-sm" onclick="editActivity(3)">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons">
            <button type="button" name="accion" value="eliminar" class="btn btn-delete-selected" onclick="deleteSelected()">
                <i class="bi bi-trash me-2"></i>
                Eliminar Seleccionadas
            </button>
            <button type="button" name="accion" value="guardar" class="btn btn-save-changes" onclick="saveChanges()">
                <i class="bi bi-save me-2"></i>
                Guardar Cambios
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all checkbox functionality
        const selectAllCheckbox = document.getElementById('selectAll');
        const activityCheckboxes = document.querySelectorAll('.activity-checkbox');
        const selectionInfo = document.getElementById('selectionInfo');
        const selectedCount = document.getElementById('selectedCount');
        
        selectAllCheckbox.addEventListener('change', function() {
            activityCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                updateRowSelection(checkbox);
            });
            updateSelectionInfo();
        });
        
        activityCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateRowSelection(this);
                updateSelectAllState();
                updateSelectionInfo();
            });
        });
        
        function updateRowSelection(checkbox) {
            const row = checkbox.closest('tr');
            if (checkbox.checked) {
                row.classList.add('selected');
            } else {
                row.classList.remove('selected');
            }
        }
        
        function updateSelectAllState() {
            const checkedCount = document.querySelectorAll('.activity-checkbox:checked').length;
            const totalCount = activityCheckboxes.length;
            
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
            selectAllCheckbox.checked = checkedCount === totalCount;
        }
        
        function updateSelectionInfo() {
            const checkedCount = document.querySelectorAll('.activity-checkbox:checked').length;
            selectedCount.textContent = checkedCount;
            
            if (checkedCount > 0) {
                selectionInfo.classList.add('show');
            } else {
                selectionInfo.classList.remove('show');
            }
        }
        
        // Global functions
        window.clearSelection = function() {
            activityCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
                updateRowSelection(checkbox);
            });
            selectAllCheckbox.checked = false;
            updateSelectionInfo();
        };
        
        window.deleteSelected = function() {
            const selectedActivities = document.querySelectorAll('.activity-checkbox:checked');
            
            if (selectedActivities.length === 0) {
                Swal.fire({
                    title: 'Selección requerida',
                    text: 'Por favor selecciona al menos una actividad para eliminar',
                    icon: 'warning',
                    confirmButtonColor: '#667eea'
                });
                return;
            }
            
            Swal.fire({
                title: '¿Confirmar eliminación?',
                text: `¿Estás seguro de eliminar ${selectedActivities.length} actividad${selectedActivities.length > 1 ? 'es' : ''}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e53e3e',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form with delete action
                    const form = document.getElementById('activityForm');
                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'accion';
                    actionInput.value = 'eliminar';
                    form.appendChild(actionInput);
                    form.submit();
                }
            });
        };
        
        window.saveChanges = function() {
            Swal.fire({
                title: '¿Guardar cambios?',
                text: 'Se guardarán todos los cambios realizados',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#38a169',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form with save action
                    const form = document.getElementById('activityForm');
                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'accion';
                    actionInput.value = 'guardar';
                    form.appendChild(actionInput);
                    form.submit();
                }
            });
        };
        
        window.editActivity = function(id) {
            Swal.fire({
                title: 'Editar Actividad',
                html: `
                    <div class="text-start">
                        <div class="mb-3">
                            <label class="form-label">Descripción:</label>
                            <textarea class="form-control" id="activityDescription" rows="3" placeholder="Descripción de la actividad..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo:</label>
                            <select class="form-select" id="activityType">
                                <option value="login">Inicio de sesión</option>
                                <option value="create">Creación</option>
                                <option value="edit">Edición</option>
                                <option value="delete">Eliminación</option>
                            </select>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonColor: '#38a169',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const description = document.getElementById('activityDescription').value;
                    const type = document.getElementById('activityType').value;
                    
                    if (!description.trim()) {
                        Swal.showValidationMessage('La descripción es requerida');
                        return false;
                    }
                    
                    return { description, type };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: '¡Actividad actualizada!',
                        text: 'Los cambios se han guardado correctamente',
                        icon: 'success',
                        confirmButtonColor: '#667eea'
                    });
                }
            });
        };
        
        window.exportActivities = function() {
            Swal.fire({
                title: 'Exportar Actividades',
                text: 'Se descargará un archivo con todas las actividades del sistema',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Descargar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Here you would implement the actual export functionality
                    Swal.fire({
                        title: '¡Exportación iniciada!',
                        text: 'La descarga comenzará en breve',
                        icon: 'success',
                        confirmButtonColor: '#667eea'
                    });
                }
            });
        };
        
        // Filter functionality
        document.getElementById('filterType').addEventListener('change', function() {
            const filterValue = this.value;
            const rows = document.querySelectorAll('#activitiesTable tbody tr');
            
            rows.forEach(row => {
                if (filterValue === '') {
                    row.style.display = '';
                } else {
                    const badge = row.querySelector('.activity-type-badge');
                    if (badge && badge.classList.contains(`activity-${filterValue}`)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    });
</script>

@endsection