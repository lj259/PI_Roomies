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
    <form action="{{ route('Registro_Departamento') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" class="form-control" name="titulo" required value="{{old('titulo')}}">
            <small class="text-danger fst-italic">{{$errors->first('titulo')}}</small>
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
            <textarea class="form-control" name="descripcion" required value="{{old('descripcion')}}"></textarea>
            <small class="text-danger fst-italic">{{$errors->first('descripcion')}}</small>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <input type="number" class="form-control" name="precio" step="0.01" required value="{{old('precio')}}">
            <small class="text-danger fst-italic">{{$errors->first('precio')}}</small>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Ubicación:</label>
            <input type="text" class="form-control" name="direccion" required value="{{old('direccion')}}">
            <small class="text-danger fst-italic">{{$errors->first('direccion')}}</small>
        </div>
        
        <div class="form-group">
            <label for="servicios">Servicios:</label><br>

            <input type="checkbox" name="servicios[]" value="Wifi"> Wifi <br>
            <input type="checkbox" name="servicios[]" value="Aire Acondicionado"> Aire Acondicionado <br>
            <input type="checkbox" name="servicios[]" value="Estacionamiento"> Estacionamiento <br>
            <input type="checkbox" name="servicios[]" value="Piscina"> Piscina <br>
            <input type="checkbox" name="servicios[]" value="Amueblado"> Amueblado <br>
            
            <div id="servicios-extra" class="mt-2"><p>Extras:</p></div>

            <!-- Campo "Otro" para agregar nuevos servicios -->
            <input type="text" class="form-control mt-2" id="nuevo-servicio" placeholder="Escribe otro servicio y presiona Enter">

            <!-- Contenedor donde se agregarán los nuevos checkboxes -->
        </div>


        <div class="mb-3">
            <label for="habitaciones_disponibles" class="form-label">Habitaciones disponibles:</label>
            <input type="number" class="form-control" name="habitaciones_disponibles" required value="{{old('habitaciones_disponibles')}}">
            <small class="text-danger fst-italic">{{$errors->first('habitaciones_disponibles')}}</small>
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
    // Servicios
    document.getElementById("nuevo-servicio").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Evita que el formulario se envíe al presionar Enter

            let nuevoServicio = this.value.trim();
            if (nuevoServicio !== "") {
                let contenedor = document.getElementById("servicios-extra");

                // Crear un nuevo checkbox
                let div = document.createElement("div");
                let checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.name = "servicios[]";
                checkbox.value = nuevoServicio;
                checkbox.checked = true; // Marcado por defecto

                let label = document.createElement("label");
                label.textContent = " " + nuevoServicio;

                div.appendChild(checkbox);
                div.appendChild(label);
                contenedor.appendChild(div);

                this.value = ""; // Limpiar el campo de entrada
            }
        }
    });
</script>
</div>

@endsection