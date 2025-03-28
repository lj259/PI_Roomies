@extends('layouts.plantilla_admins')
@section('titulo', 'Gestión de Roles y Permisos')
@section('Contenido')
    <link rel="stylesheet" href="{{ asset('css/roles.css') }}">
    <div class="container-fluid vh-100 bg-light p-0">
        <!--
                                                    <div class="bg-danger text-white d-flex align-items-center justify-content-between px-4 py-2">
                                                        <h4 class="mb-0 font-weight-bold">Gestión de Roles y Permiso</h4>
                                                        <div class="d-flex gap-3">
                                                            <button class="btn btn-outline-light d-flex align-items-center">
                                                                <i class="bi bi-person-plus-fill"></i> AGREGAR PERFIL
                                                            </button>
                                                            <button class="btn btn-outline-light">
                                                                <i class="bi bi-person-circle"></i> ADMI
                                                            </button>
                                                            <button class="btn btn-outline-light">
                                                                <i class="bi bi-list"></i>
                                                            </button>
                                                        </div>
                                                    </div> -->

        <div class="d-flex">
            <div class="bg-light p-3" style="width: 150px;">
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
                            <i class="bi bi-envelope-fill"></i> CORREO
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark d-flex align-items-center">
                            <i class="bi bi-gear-fill"></i> AJUSTES
                        </a>
                    </li>
                </ul>
            </div>

            <!--Inicio de la tabla-->

            <div class="container mt-4">
                <div class="table-responsive">
                    <table class="table tabla-admin table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $u)
                                <tr>
                                    <td>{{ $u->id }}</td>
                                    <td>{{ $u->nombre }}</td>
                                    <td>{{ $u->apellido_paterno }}</td>
                                    <td>{{ $u->apellido_materno }}</td>
                                    <td>{{ $u->rol }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editarRolModal" data-user-id="{{ $u->id }}"
                                            data-user-name="{{ $u->nombre }} {{ $u->apellido_paterno }} {{ $u->apellido_materno }}"
                                            data-user-rol="{{ $u->rol }}">
                                            Editar
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


    <!-- Modal -->
    <div class="modal fade" id="editarRolModal" tabindex="-1" aria-labelledby="editarRolModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editarRolModalLabel">Editar rol de usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditarRol" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="modalUserId">
                        <p><strong>Nombre:</strong> <span id="modalUserName"></span></p>

                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol:</label>
                            <select class="form-select" name="nuevo_rol" id="modalUserRol">
                                <option value="admin" >Administrador</option>
                                <option value="usuario">Usuario</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const editarRolModal = document.getElementById('editarRolModal');

            editarRolModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
                const userRol = button.getAttribute('data-user-rol');

                // Actualizar el modal
                document.getElementById('modalUserName').textContent = userName;
                document.getElementById('modalUserRol').value = userRol;
                document.getElementById('modalUserId').value = userId;

                // Actualizar el action del formulario
                const form = document.getElementById('formEditarRol');
                const editRoute = "{{ route('RolesEdit', ['usuario' => '--ID--']) }}".replace('--ID--', userId);
                form.action = editRoute;
            });
        });
    </script>

@endsection