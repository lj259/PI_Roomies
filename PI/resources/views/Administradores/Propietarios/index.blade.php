@extends('layouts.plantilla_admins')

@section('Contenido')
<div class="container espacio_contenedor my-5">
    <h2>Lista de Propietarios</h2>
    <a href="{{ route('propietarios.create') }}" class="btn btn-success mb-3">Nuevo Propietario</a>
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
                        <a href="{{ route('propietarios.edit', $propietario) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('propietarios.destroy', $propietario) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
