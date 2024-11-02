@extends('layouts.Plantilla1')
@section('titulo','Registro de Avisos')
@section('Contenido')

<div class="container-fluid p-0">
    <div class="bg-danger text-white d-flex align-items-center justify-content-between px-4 py-2">
        <h4 class="mb-0 font-weight-bold">Registro de Avisos</h4>
        <div class="d-flex gap-3">
            <button class="btn btn-outline-light">
                <i class="bi bi-person-circle"></i> ADMI
            </button>
            <button class="btn btn-outline-light">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>

    <div class="d-flex">
        <div class="bg-light border-end p-3 vh-100" style="width: 150px; border-right: 2px solid #ccc;">
            <ul class="nav flex-column gap-3">
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark d-flex align-items-center">
                        <i class="bi bi-bell-fill"></i> NOTIFICACIÓN
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill"></i> REPORTES
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark d-flex align-items-center">
                        <i class="bi bi-gear-fill"></i> AJUSTES
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark d-flex align-items-center">
                        <i class="bi bi-envelope-fill"></i> EMAIL
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark d-flex align-items-center">
                        <i class="bi bi-lock-fill"></i> PERMISOS
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="container-fluid bg-info p-4">
            <div class="input-group mb-4">
                <input type="text" class="form-control" placeholder="Buscar aviso">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>id</th>
                            <th>Título</th>
                            <th>Contenido</th>
                            <th>Fecha Creación</th>
                            <th>Fecha Modificación</th>
                            <th>Activo</th>
                            <th>Usuario Creador</th>
                            <th>Categoría</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mantenimiento Programado</td>
                            <td>Se realizará mantenimiento el 15/11</td>
                            <td>2024-11-01 09:00:00</td>
                            <td>2024-11-01 09:00:00</td>
                            <td>true</td>
                            <td>3</td>
                            <td>Notificaciones</td>
                        </tr>
                        <tr class="table-primary">
                            <td>2</td>
                            <td>Nueva Política de Uso</td>
                            <td>Actualización en las políticas del sistema.</td>
                            <td>2024-11-02 10:00:00</td>
                            <td>2024-11-02 10:00:00</td>
                            <td>true</td>
                            <td>2</td>
                            <td>Avisos Administrativos</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="bg-light p-3 rounded mb-4 mt-4" style="max-width: 200px;">
                <h6 class="text-center font-weight-bold">ELIGE A QUÉ USUARIOS SE ENVÍA</h6>
                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            <i class="bi bi-people-fill"></i> TODOS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            <i class="bi bi-person-fill"></i> SOLO UN GRUPO
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            <i class="bi bi-person-badge-fill"></i> LIMITADOS
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="d-flex gap-3">
                <button class="btn btn-info">
                    <i class="bi bi-trash"></i> ELIMINAR
                </button>
                <button class="btn btn-success">
                    <i class="bi bi-send"></i> ENVIAR
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
