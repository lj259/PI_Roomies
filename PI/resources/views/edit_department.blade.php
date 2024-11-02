<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources\js\app.js'])
    <title>Editar Departamento</title>
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center">Editar Departamento</h3>
        <form>
            <div class="form-group mt-3">
                <label for="foto">Foto</label>
                <input type="file" class="form-control" id="foto">
            </div>
            <div class="form-group mt-3">
                <label for="precio">Precio</label>
                <input type="number" class="form-control" id="precio" value="Precio actual">
            </div>
            <div class="form-group mt-3">
                <label for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" value="Ubicación actual">
            </div>
            <div class="form-group mt-3">
                <label for="habitaciones">Habitaciones</label>
                <input type="number" class="form-control" id="habitaciones" value="Número de habitaciones actual">
            </div>
            <div class="form-group mt-3">
                <label for="banos">Baños</label>
                <input type="number" class="form-control" id="banos" value="Número de baños actual">
            </div>
            <div class="form-group mt-3">
                <label for="servicios">Servicios</label>
                <textarea class="form-control" id="servicios">Servicios actuales</textarea>
            </div>
            <div class="form-group mt-3">
                <label for="restricciones">Restricciones</label>
                <textarea class="form-control" id="restricciones">Restricciones actuales</textarea>
            </div>
            <div class="form-group mt-3">
                <label for="cercanias">Cercanías</label>
                <textarea class="form-control" id="cercanias">Cercanías actuales</textarea>
            </div>
            <div class="form-group form-check mt-4">
                <input type="checkbox" class="form-check-input" id="borrado_logico">
                <label class="form-check-label" for="borrado_logico">Borrado lógico</label>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Guardar Cambios</button>
            <a href="/admin/departments" class="btn btn-secondary mt-4">Cancelar</a>
        </form>
    </div>
</body>
</html>
