<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources\js\app.js'])
    <title>Registrar Departamento</title>
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center">Registrar Departamento</h3>
        <form>
            <div class="form-group mt-3">
                <label for="foto">Foto</label>
                <input type="file" class="form-control" id="foto">
            </div>
            <div class="form-group mt-3">
                <label for="precio">Precio</label>
                <input type="number" class="form-control" id="precio" placeholder="Precio mensual">
            </div>
            <div class="form-group mt-3">
                <label for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" placeholder="Ubicación del departamento">
            </div>
            <div class="form-group mt-3">
                <label for="habitaciones">Habitaciones</label>
                <input type="number" class="form-control" id="habitaciones" placeholder="Número de habitaciones">
            </div>
            <div class="form-group mt-3">
                <label for="banos">Baños</label>
                <input type="number" class="form-control" id="banos" placeholder="Número de baños">
            </div>
            <div class="form-group mt-3">
                <label for="servicios">Servicios</label>
                <textarea class="form-control" id="servicios" placeholder="Servicios incluidos (e.g., agua, electricidad, internet)"></textarea>
            </div>
            <div class="form-group mt-3">
                <label for="restricciones">Restricciones</label>
                <textarea class="form-control" id="restricciones" placeholder="Restricciones del dueño"></textarea>
            </div>
            <div class="form-group mt-3">
                <label for="cercanias">Cercanías</label>
                <textarea class="form-control" id="cercanias" placeholder="Tiendas, servicios cercanos, paradas de camión"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Registrar Departamento</button>
            <a href="/admin/departments" class="btn btn-secondary mt-4">Cancelar</a>
        </form>
    </div>
</body>
</html>
