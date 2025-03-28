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
                            <a href="{{ route('propietarios.edit', $propietario) }}" class="btn btn-update btn-sm"><i
                                    class="bi bi-pencil"></i> Editar</a>
                            <form action="{{ route('propietarios.destroy', $propietario) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete btn-sm"><i class="bi bi-trash3 me-2"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection