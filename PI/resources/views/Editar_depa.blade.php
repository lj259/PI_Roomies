@extends('layouts.plantilla_admins')
@section('titulo', 'Registrar Departamento')
@section('Contenido')

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
        <div class="container-fluid p-4 justify-content-around border">
            <h3 class="text-center mb-4">Editar Departamento</h3>
            <div class=" mx-auto">
                <div class=""></div>
                <form method="POST" action="{{{route('RutaUpdateDepa', [$depa->id])}}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-start mt-3"> <!-- Cambio clave aquí -->
                        <div class="col-5"> <!-- Eliminé mx-auto -->
                            <div class="form-group mt-3">
                                <label for="foto">Foto</label>
                                <input type="file" class="form-control" value="{{$depa->img_path}}" name="foto">
                                <small class="text-danger fst-italic">{{$errors->first('foto')}}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="row"></div>
                    </div>

                    <div class="row justify-content-start mt-3">
                        <div class="col-2">
                            <label for="precio">Precio</label>
                            <input type="text" class="form-control" value="{{$depa->precio}}" name="precio"
                                placeholder="Precio mensual">
                            <small class="text-danger fst-italic">{{$errors->first('precio')}}</small>
                        </div>
                        <div class="col-2">
                            <label for="habitaciones">Habitaciones</label>
                            <input type="number" class="form-control" value="{{$depa->habitaciones_disponibles}}"
                                name="habitaciones" placeholder="Número de habitaciones">
                            <small class="text-danger fst-italic">{{$errors->first('habitaciones')}}</small>
                        </div>
                    </div>
                    <div class="row justify-content-start mt-3">
                        <div class="col-8">
                            <label for="ubicacion">Dirección</label>
                            <textarea name="direccion" class="form-control">{{ $depa->direccion }}</textarea>
                            <small class="text-danger fst-italic">{{$errors->first('ubicacion')}}</small>
                        </div>
                    </div>

                    <div class="row justify-content-start mt-3"> <!-- Cambio clave aquí -->
                        <div class="col-3"> <!-- Eliminé mx-auto -->
                            <div class="form-group mt-3">
                                <label for="foto">Disponible para:</label>
                                <input type="text" class="form-control" value="{{$depa->disponible_para}}" name="disponible"
                                    placeholder="ej. Mixto, Hombreso mujeres">
                                <small class="text-danger fst-italic">{{$errors->first('disponible')}}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-start mt-3">
                        <div class="col-5">
                            <label for="servicios">Servicios</label>
                            <textarea class="form-control" name="servicios"
                                placeholder="Servicios incluidos (e.g., agua, electricidad, internet)">xd</textarea>
                            <small class="text-danger fst-italic">{{$errors->first('servicios')}}</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button type="submit" class="btn btn-outline-primary">Editar</button>
                        <a href="#" class="btn btn-outline-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection