@extends('layouts.plantilla_admins')

@section('Contenido')

    <link rel="stylesheet" href="{{ asset('css/propietarios.css') }}">

    <div class="container espacio_contenedor my-5">
        <div class="d-flex justify-content-start gap-3 mt-3">
            <h2>Lista de Propietarios</h2>
            <a href="{{ route('propietarios.create') }}" class="btn guardar-btn rounded-pill p-3">
                <i class="bi bi-plus-lg me-2"></i> Nuevo Propietario
            </a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($propietarios as $propietario)
                    <tr>
                        <td>{{ $propietario->nombre }}</td>
                        <td>{{ $propietario->correo }}</td>
                        <td>{{ $propietario->telefono }}</td>
                        <td>
                            <button class="btn btn-update btn-sm" data-bs-toggle="modal" data-bs-target="#editarPropietario{{ $propietario->id }}"><i class="bi bi-pencil"></i> Editar</button>    
                            <form action="{{ route('propietarios.destroy', $propietario) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete btn-sm"><i class="bi bi-trash3 me-2"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <!-- Modal de editar-->
                    <div class="modal fade" id="editarPropietario{{ $propietario->id }}" tabindex="-1" aria-labelledby="editarPropietarioLabel{{ $propietario->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarPropietarioLabel">Editar Propietario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Contenido del modal -->
                                    <form action="{{route('propietarios.update', [$propietario->id])}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                        <div class="mb-3">
                                            <label for="nombre" class="col-form-label">Nombre:</label>
                                            <input type="text" class="form-control" name="nombre" value="{{ $propietario->nombre }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="correo" class="col-form-label">Correo:</label>
                                            <input type="text" class="form-control" name="correo" value="{{$propietario->correo}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="telefono" class="col-form-label">Telefono:</label>
                                            <input type="text" class="form-control" name="telefono" value="{{$propietario->telefono}}">
                                        </div>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-outline-primary">Guardar cambios</button>
                                        </div>
                                    </form>
                                </div>
                
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection