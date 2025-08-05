@extends('layouts.plantilla_admins')
@section('titulo', 'Panel Administrativo')
@section('Contenido')

<style>
    .admin-dashboard {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .dashboard-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        border: none;
    }
    
    .dashboard-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .dashboard-card .card-body {
        padding: 2rem;
        text-align: center;
    }
    
    .card-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .card-users .card-icon {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
    }
    
    .card-departments .card-icon {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
    }
    
    .card-owners .card-icon {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        box-shadow: 0 5px 15px rgba(67, 233, 123, 0.4);
    }
    
    .card-notices .card-icon {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        box-shadow: 0 5px 15px rgba(250, 112, 154, 0.4);
    }
    
    .card-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .card-description {
        color: #718096;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }
    
    .card-link {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .card-link:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        text-decoration: none;
    }
    
    .card-link i {
        margin-right: 0.5rem;
    }
    
    .dashboard-header {
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .dashboard-title {
        font-size: 3rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .dashboard-subtitle {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 300;
    }
    
    .stats-row {
        margin-top: 3rem;
    }
    
    .stat-item {
        text-align: center;
        color: white;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        display: block;
    }
    
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    @media (max-width: 768px) {
        .dashboard-title {
            font-size: 2rem;
        }
        
        .dashboard-card {
            margin-bottom: 1.5rem;
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
    }
</style>

<div class="admin-dashboard">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">Panel Administrativo</h1>
            <p class="dashboard-subtitle">Gestiona todos los aspectos de Poli-Roomies desde aquí</p>
        </div>
        
        <!-- Management Cards -->
        <div class="row g-4">
            <!-- Users Management -->
            <div class="col-lg-6 col-md-6">
                <div class="card dashboard-card card-users h-100">
                    <div class="card-body">
                        <div class="card-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3 class="card-title">Gestión de Usuarios</h3>
                        <p class="card-description">
                            Administra cuentas de usuarios, roles y permisos. Crea, edita y elimina perfiles de usuario.
                        </p>
                        <a href="{{ route('RutaAdminUsers')}}" class="card-link">
                            <i class="bi bi-arrow-right-circle"></i>
                            Acceder
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Departments Management -->
            <div class="col-lg-6 col-md-6">
                <div class="card dashboard-card card-departments h-100">
                    <div class="card-body">
                        <div class="card-icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <h3 class="card-title">Consulta de Departamentos</h3>
                        <p class="card-description">
                            Consulta, supervisa y elimina departamentos registrados en la plataforma. Solo lectura y eliminación.
                        </p>
                        <a href="{{ route('Ruta_gestion_depas') }}" class="card-link">
                            <i class="bi bi-arrow-right-circle"></i>
                            Acceder
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Owners Management -->
            <div class="col-lg-6 col-md-6">
                <div class="card dashboard-card card-owners h-100">
                    <div class="card-body">
                        <div class="card-icon">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <h3 class="card-title">Gestión de Propietarios</h3>
                        <p class="card-description">
                            Administra cuentas de propietarios y supervisa sus propiedades registradas.
                        </p>
                        <a href="{{ route('propietarios.index') }}" class="card-link">
                            <i class="bi bi-arrow-right-circle"></i>
                            Acceder
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Notices Management -->
            <div class="col-lg-6 col-md-6">
                <div class="card dashboard-card card-notices h-100">
                    <div class="card-body">
                        <div class="card-icon">
                            <i class="bi bi-bell-fill"></i>
                        </div>
                        <h3 class="card-title">Gestión de Avisos</h3>
                        <p class="card-description">
                            Crea, edita y gestiona avisos y notificaciones para los usuarios de la plataforma.
                        </p>
                        <a href="{{ route('RutaRegistroAvisos') }}" class="card-link">
                            <i class="bi bi-arrow-right-circle"></i>
                            Acceder
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats Row -->
        <div class="row stats-row">
            <div class="col-md-3">
                <div class="stat-item">
                    <span class="stat-number">{{ \App\Models\Usuario::count() }}</span>
                    <span class="stat-label">Usuarios Totales</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <span class="stat-number">{{ \App\Models\Apartamento::count() }}</span>
                    <span class="stat-label">Departamentos</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <span class="stat-number">{{ \App\Models\Propietario::count() }}</span>
                    <span class="stat-label">Propietarios</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <span class="stat-number">{{ \App\Models\Usuario::where('rol', 'admin')->count() }}</span>
                    <span class="stat-label">Administradores</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection