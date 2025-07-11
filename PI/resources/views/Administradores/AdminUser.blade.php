@extends('layouts.plantilla_admins')
@section('titulo', 'Registro de Actividad')
@section('Contenido')

    <style>
        .small-input {
            width: 50%;
        }
    </style>

    @session('eliminar')
        <script>
            Swal.fire({
                title: "Acción Eliminada",
                text: "{{$value}}",
                icon: "success"
            });
        </script>
    @endsession

    @session('guardado')
        <script>
            Swal.fire({
                title: "Cambio Guardado",
                text: "{{$value}}",
                icon: "success"
            });
        </script>
    @endsession

    <div class="container-fluid vh-100 p-0">

        <div class="d-flex">
            <div class="bg-light border-end p-3 vh-100" style="width: 150px; border-right: 2px solid #ccc;">
                <ul class="nav flex-column gap-3">
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark d-flex align-items-center">
                            <i class="bi bi-bell-fill"></i> NOTIFICACIÓN
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill"></i> REPORTES
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark d-flex align-items-center">
                            <i class="bi bi-gear-fill"></i> AJUSTES
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark d-flex align-items-center">
                            <i class="bi bi-envelope-fill"></i> EMAIL
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark d-flex align-items-center">
                            <i class="bi bi-lock-fill"></i> PERMISOS
                        </a>
                    </li>
                </ul>
            </div>
            <div class="container-fluid bg-gradient p-4 ">
                <div class="input-group mb-3 small-input">
                    <input type="text" class="form-control " name="buscarUsuarios" placeholder="Buscar usuarios"><br>
                    <button class="btn btn-outline-primary">Buscar</button>
                </div>

                <div class="small-input mt-1 mb-3">
                    <small class="text-light fst-italic"><strong>{{$errors->first('bucarActividad')}}</strong></small>
                </div>

                <div class="table-responsive ">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Rol</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consulta as $usuario)
                                <tr>
                                    <td>{{$usuario->id}}</td>
                                    <td>{{$usuario->nombre}}</td>
                                    <td>{{$usuario->apellido_paterno}}</td>
                                    <td>{{$usuario->apellido_materno}}</td>
                                    <td>{{$usuario->rol}}</td>
                                    <td>{{$usuario->correo}}</td>
                                    <td>{{$usuario->telefono}}</td>
                                    <td><button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editarPerfilModal"><i class="bi bi-pencil"></i></button></td>
                                    <td>
                                        <button class="btn btn-danger btn-eliminar" data-id="{{$usuario->id}}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de editar-->
    <div class="modal fade" id="editarPerfilModal" tabindex="-1" aria-labelledby="editarPerfilModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPerfilModalLabel">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del modal -->
                    <form action="{{route('EnvioActualizarUsuario', [$usuario->id])}}" method="POST">
                    @csrf
                        <div class="mb-3">
                            <label for="nombre" class="col-form-label">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" value="{{ $usuario->nombre }}">
                        </div>
                        <div class="mb-3">
                            <label for="apellido_p" class="col-form-label">Apellido Paterno:</label>
                            <input type="text" class="form-control" name="apellido_p" value="{{ $usuario->apellido_paterno }}">
                        </div>
                        <div class="mb-3">
                            <label for="apellido_m" class="col-form-label">Apellido Materno:</label>
                            <input type="text" class="form-control" name="apellido_m" value="{{ $usuario->apellido_materno }}">
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="col-form-label">Correo:</label>
                            <input type="text" class="form-control" name="correo" value="{{$usuario->correo}}">
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="col-form-label">Telefono:</label>
                            <input type="text" class="form-control" name="telefono" value="{{$usuario->telefono}}">
                        </div>
                        <div class="mb-3">
                            <label for="genero" class="col-form-label">Selecciona un género:</label>
                            <select class="form-control" name="genero" id="genero">
                                <option value="masculino" {{ $usuario->genero == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ $usuario->genero == 'femenino' ? 'selected' : '' }}>Femenino</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="col-form-label">Status:</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" {{ $usuario->status == 1 ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ $usuario->status == 0 ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-outline-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".btn-eliminar").forEach(button => {
                button.addEventListener("click", function () {
                    let userId = this.getAttribute("data-id");

                    Swal.fire({
                        title: "¿Estás seguro?",
                        text: "Esta acción no se puede revertir.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Sí, eliminar",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Aquí puedes enviar la solicitud de eliminación
                            Swal.fire("Eliminado!", "El usuario ha sido eliminado.", "success");
                            // Redireccionar o hacer una petición AJAX
                        }
                    });
                });
            });
        });
    </script>


@endsection