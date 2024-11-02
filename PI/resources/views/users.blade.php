<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources\js\app.js'])
    <title>Gestión de Usuarios</title>
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center">Gestión de Usuarios</h3>
        <div class="row mt-4">
            <div class="col-md-6">
                <a href="/admin/users/create" class="btn btn-success btn-block">Registrar Usuario</a>
            </div>
            <div class="col-md-6">
                <a href="/admin/home" class="btn btn-secondary btn-block">Volver al Inicio</a>
            </div>
        </div>
    </div>
</body>
</html>
