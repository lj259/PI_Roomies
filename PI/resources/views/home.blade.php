<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources\js\app.js'])
    <title>Panel Administrativo</title>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <a class="nav-link text-white" href="/admin/login">Cerrar Sesión</a>
    </nav>
    <div class="container mt-5">
        <h2 class="text-center">Panel Administrativo</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <a href="/admin/users" class="btn btn-info btn-block">Gestión de Usuarios</a>
            </div>
            <div class="col-md-4">
                <a href="/admin/departments" class="btn btn-info btn-block">Gestión de Departamentos</a>
            </div>
            <div class="col-md-4">
                <a href="/admin/notices" class="btn btn-info btn-block">Gestión de Avisos</a>
            </div>
        </div>
    </div>
</body>
</html>
