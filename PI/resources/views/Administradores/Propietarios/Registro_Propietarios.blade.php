@extends('layouts.plantilla_admins')

@section('Contenido')
    <link rel="stylesheet" href="{{ asset('css/propietarios.css') }}">

    <div class="container p-5 mt-5">
        <div class="row justify-content-center"> <!-- Centra horizontalmente -->
            <div class="col-md-8 col-lg-6"> <!-- Controla el ancho máximo -->
                <div class="card shadow"> <!-- Agrega sombreado para mejor apariencia -->
                    <div class="card-header custom-card-header text-white"> <!-- Encabezado de tarjeta -->
                        <h2 class="mb-0 text-center">Registrar Propietario</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('propietarios.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Correo</label>
                                <input type="email" name="correo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control">
                            </div>
                            <div class="d-flex justify-content-center gap-2"> <!-- Contenedor flex (horizontal) -->
                                <!-- Botón "Regresar" -->
                                <a href="{{ route('propietarios.index') }}"
                                    class="btn guardar-btn rounded-pill text-decoration-none">
                                    Regresar
                                </a>

                                <!-- Botón "Guardar" -->
                                <button type="submit" class="btn guardar-btn rounded-pill">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection