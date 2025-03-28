@extends('layouts.plantilla_admins')
@section('titulo', 'Registrar Departamento')
@section('Contenido')
    <link rel="stylesheet" href="{{ asset('css/editardepa.css') }}">
    @session('registrado')
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
                    <a href="{{route('Ruta_gestion_depas')}}" class="nav-link text-dark d-flex align-items-center">Consultar
                        departamentos</a>
                </li>
            </ul>
        </div>

        <!--Campos de Registrar departamento-->
        <div class="container-fluid p-4">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6"> <!-- Ajusta el ancho máximo aquí -->
                    <h3 class="text-center mb-6">Editar Departamento</h3>
                    <form method="POST" action="{{route('RutaUpdateDepa', [$depa->id])}}" enctype="multipart/form-data"
                        class="bg-light p-4 rounded shadow">
                        @csrf
                        @method('PUT')


                        <!-- Sección titulo -->
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-8">
                                <label for="titulo">Título</label>
                                <small class="text-danger fst-italic">{{$errors->first('titulo')}}</small>
                                <textarea name="titulo" class="form-control form-control-enhanced"
                                    rows="2">{{ $depa->titulo }}</textarea>

                            </div>
                        </div>

                        <!-- Sección Foto -->
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <input type="file" class="form-control" value="{{$depa->img_path}}" name="foto">
                                    <small class="text-danger fst-italic">{{$errors->first('foto')}}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Precio y Habitaciones -->
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-4">
                                <label for="precio">Precio</label>
                                <input type="text" class="form-control form-control-enhanced" value="{{$depa->precio}}"
                                    name="precio" placeholder="Precio mensual">
                                <small class="text-danger fst-italic">{{$errors->first('precio')}}</small>
                            </div>
                            <div class="col-md-4">
                                <label for="habitaciones_disponibles">Habitaciones</label>
                                <input type="number" class="form-control form-control-enhanced"
                                    value="{{$depa->habitaciones_disponibles}}" name="habitaciones_disponibles"
                                    placeholder="Número de habitaciones_disponibles">
                                <small class="text-danger fst-italic">{{$errors->first('habitaciones_disponibles')}}</small>
                            </div>
                        </div>

                        <!-- Sección Descripción -->
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-8">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" class="form-control form-control-enhanced"
                                    rows="2">{{ $depa->descripcion }}</textarea>
                                <small class="text-danger fst-italic">{{$errors->first('descripcion')}}</small>
                            </div>
                        </div>

                        <!-- Sección Dirección -->
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-8">
                                <label for="direccion">Dirección</label>
                                <textarea name="direccion" class="form-control form-control-enhanced"
                                    rows="2">{{ $depa->direccion }}</textarea>
                                <small class="text-danger fst-italic">{{$errors->first('direccion')}}</small>
                            </div>
                        </div>

                        <!-- Sección latitud y longitud -->
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-4">
                                <label for="latitud">Latitud</label>
                                <input type="text" class="form-control form-control-enhanced" value="{{$depa->latitud}}"
                                    name="latitud" placeholder="latitud">
                                <small class="text-danger fst-italic">{{$errors->first('latitud')}}</small>
                            </div>
                            <div class="col-md-4">
                                <label for="longitud">Longitud</label>
                                <input type="number" class="form-control form-control-enhanced" value="{{$depa->longitud}}"
                                    name="longitud" placeholder="Número de longitud">
                                <small class="text-danger fst-italic">{{$errors->first('longitud')}}</small>
                            </div>
                        </div>

                        <!-- Sección Disponible para -->
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="modalUserRol" class="form-label">Rol:</label>
                                    <select class="form-select" name="disponible_para" id="modalUserRol">
                                        <option value="mixto" {{ $depa->disponible_para == 'mixto' ? 'selected' : '' }}>Mixto</option>
                                        <option value="mujeres" {{ $depa->disponible_para == 'mujeres' ? 'selected' : '' }}>Mujeres</option>
                                        <option value="hombres" {{ $depa->disponible_para == 'hombres' ? 'selected' : '' }}>Hombres</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Servicios -->
<div class="row justify-content-center mt-3">
    <div class="col-md-8">
        <div class="form-group">
            <label for="servicios">Servicios:</label><br>

            @php
                // Obtener los servicios (ya como array o convertirlo si es necesario)
                $serviciosActuales = is_array($depa->servicios) ? $depa->servicios : json_decode($depa->servicios, true) ?? [];
            @endphp

            <input type="checkbox" name="servicios[]" value="Wi-Fi" 
                   @if(in_array('Wi-Fi', $serviciosActuales)) checked @endif> Wifi <br>
            
            <input type="checkbox" name="servicios[]" value="Aire acondicionado"
                   @if(in_array('Aire acondicionado', $serviciosActuales)) checked @endif> Aire Acondicionado <br>
            
            <input type="checkbox" name="servicios[]" value="Estacionamiento"
                   @if(in_array('Estacionamiento', $serviciosActuales)) checked @endif> Estacionamiento <br>
            
            <input type="checkbox" name="servicios[]" value="Piscina"
                   @if(in_array('Piscina', $serviciosActuales)) checked @endif> Piscina <br>
            
            <input type="checkbox" name="servicios[]" value="Amueblado"
                   @if(in_array('Amueblado', $serviciosActuales)) checked @endif> Amueblado <br>

            <div id="servicios-extra" class="mt-2">
                <p>Extras:</p>
            </div>

            <!-- Campo "Otro" para agregar nuevos servicios -->
            <input type="text" class="form-control mt-2" id="nuevo-servicio"
                   placeholder="Escribe otro servicio y presiona Enter">

            <!-- Contenedor donde se agregarán los nuevos checkboxes -->
        </div>
    </div>
</div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <button type="submit" class="btn contact-btn rounded-pill px-4 py-2">
                                <i class="bi bi-check-circle-fill me-2"></i> Guardar
                            </button>
                            <a href="{{ route('Ruta_gestion_depas') }}" class="btn contact-btn rounded-pill px-4 py-2">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection