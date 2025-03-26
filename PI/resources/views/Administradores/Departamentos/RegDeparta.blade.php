@extends('layouts.plantilla_admins')
@section('titulo', 'Registrar Departamento')
@section('Contenido')

@session('Exito')
    <script>
        Swal.fire({
            title: "Registro exitoso",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession

<div class="d-flex">
    <div class="bg-light border-end p-3 vh-100" style="width: 170px; border-right: 2px solid #ccc;">
        <ul class="nav flex-column gap-3">
            <li class="nav-item">
                <a href="{{route('Ruta_gestion_depas')}}" class="nav-link text-dark d-flex align-items-center">Consultar departamentos</a>
            </li>
            <li class="nav-item">
                <a href="{{route('RutaRegDeparta')}}" class="nav-link text-dark d-flex align-items-center">Registrar departamentos</a>
            </li>
        </ul>
    </div>

    <!--Campos de Registrar departamento-->
    <div class="container p-3 m-3">
    <h2>Registrar Departamento</h2>
    <form action="{{ route('ValidarDepa') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" class="form-control" name="titulo" required>
        </div>
        <div class="mb-3">
            <label for="propietario_id" class="form-label">Propietario:</label>
            <select name="propietario_id" required>
                <option disabled>Elije una Opcion</option>
                @isset($propietarios)
                    @foreach ($propietarios as $p)
                        <option value="{{$p->id }}">{{ $p->nombre }}</option>
                    @endforeach
                @endisset
            </select>     
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea class="form-control" name="descripcion" required></textarea>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <input type="number" class="form-control" name="precio" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="ubicacion" class="form-label">Ubicación:</label>
            <input type="text" class="form-control" name="ubicacion" required>
        </div>
        <div class="mb-3">
            <label for="habitaciones_disponibles" class="form-label">Habitaciones disponibles:</label>
            <input type="number" class="form-control" name="habitaciones_disponibles" required>
        </div>
        <div class="mb-3">
            <label for="imagenes" class="form-label">Imágenes:</label>
            <input type="file" class="form-control" name="imagenes[]" multiple accept="image/*">
        </div>

        <!-- Mapa -->
        <div class="mb-3">
            <label for="mapa" class="form-label">Seleccionar ubicación:</label>
            <div id="map" style="height: 400px;"></div>
            <input type="hidden" name="latitud" id="latitud">
            <input type="hidden" name="longitud" id="longitud">
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>

<!-- Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
    var map = L.map('map').setView([20.588055555556, -100.38805555556], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([20.588055555556, -100.38805555556], {draggable: true}).addTo(map);

    marker.on('dragend', function (event) {
        var position = marker.getLatLng();
        document.getElementById('latitud').value = position.lat;
        document.getElementById('longitud').value = position.lng;
    });

    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        document.getElementById('latitud').value = e.latlng.lat;
        document.getElementById('longitud').value = e.latlng.lng;
    });
</script>
</div>

@endsection