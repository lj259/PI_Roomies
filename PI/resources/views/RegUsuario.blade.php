<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #ffffff;
        }
        .form-container {
            max-width: 400px;
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .image-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .mascota {
            width: 100px;
            max-width: 100%;
        }
        .casa {
            width: 120px;
            max-width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-container">
            <!-- Imagen de la casa y personaje -->
            <img src="casa.png" alt="Casa" class="casa">
            <img src="personaje1.png" alt="Personaje 1" class="mascota">
        </div>
        <!-- Formulario de Registro -->
        <div class="form-container mx-auto mt-3">
            <h4>Registrar Usuario</h4>
            <form>
                <div class="form-group text-left">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ingresa tu nombre completo">
                </div>
                <div class="form-group text-left">
                    <label>Género:</label><br>
                    <div class="btn-group" role="group" aria-label="Género">
                        <button type="button" class="btn btn-success">F</button>
                        <button type="button" class="btn btn-primary">M</button>
                    </div>
                </div>
                <div class="form-group text-left">
                    <label for="edad">Edad:</label>
                    <input type="number" class="form-control" id="edad" placeholder="Ingresa tu edad">
                </div>
                <div class="form-group text-left">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" class="form-control" id="telefono" placeholder="Ingresa tu teléfono">
                </div>
                <div class="form-group text-left">
                    <label for="correo">Correo Institucional:</label>
                    <input type="email" class="form-control" id="correo" placeholder="Ingresa tu correo institucional">
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">Registrar</button>
            </form>
        </div>
        <div class="image-container mt-3">
            <!-- Imagen de personaje a la derecha -->
            <img src="personaje2.png" alt="Personaje 2" class="mascota">
        </div>
    </div>

    <!-- Enlace a Bootstrap JS (Opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
