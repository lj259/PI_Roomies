<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources\js\app.js'])
    <title>Editar Usuario</title>
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center">Editar Usuario</h3>
        <form>
            <div class="form-group">
                <label for="name">Nombre Completo</label>
                <input type="text" class="form-control" id="name" value="Nombre actual">
            </div>
            <div class="form-group mt-3">
                <label for="status">Estado</label>
                <select class="form-control" id="status">
                    <option>Activo</option>
                    <option>Bloqueado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Guardar Cambios</button>
            <a href="/admin/users" class="btn btn-secondary mt-4">Cancelar</a>
        </form>
    </div>
</body>
</html>
