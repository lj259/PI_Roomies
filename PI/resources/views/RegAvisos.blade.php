@extends('layouts.plantilla_admins')
@section('titulo', 'Registro de Avisos')
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

@session('enviado')
    <script>
        Swal.fire({
            title: "Aviso enviado",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession

@session('registrado')
    <script>
        Swal.fire({
            title: "Aviso creado",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession

@session('actualizado')
    <script>
        Swal.fire({
            title: "Aviso actualizado",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession

<div class="container-fluid p-0">
    <!--
    <div class="bg-danger text-white d-flex align-items-center justify-content-between px-4 py-2">
        <h4 class="mb-0 font-weight-bold">Registro de Avisos</h4>
        <div class="d-flex gap-3">
            <button class="btn btn-outline-light">
                <i class="bi bi-person-circle"></i> ADMI
            </button>
            <button class="btn btn-outline-light">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div> -->

    <div class="d-flex">
        <div class="bg-light border-end p-3 vh-100" style="width: 150px; border-right: 2px solid #ccc;">
            <ul class="nav flex-column gap-3">
                <li class="nav-item">
                    <a href="{{route('RutaVerAvisos')}}" class="nav-link text-dark d-flex align-items-center">Consultar
                        avisos</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('RutaRegistroAvisos')}}" class="nav-link text-dark d-flex align-items-center">Crear
                        un nuevo aviso</a>
                </li>
            </ul>
        </div>

        <div class="container-fluid bg-info p-4">
            <!--
            <div class="input-group mb-4 small-input">
                <input type="text" class="form-control" name="buscarAviso" placeholder="Buscar aviso">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="bi bi-search">Buscar</i>
                </button>
            </div> -->

            <div class="small-input mt-1 mb-3">
                <small class="text-light fst-italic"><strong>{{$errors->first('buscarAviso')}}</strong></small>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>id</th>
                            <th>Título</th>
                            <th>Contenido</th>
                            <th>Fecha Creación</th>
                            <th>Fecha Modificación</th>
                            <th>Estado</th>
                            <th>Usuario Creador</th>
                            <th>Categoría</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consulta as $aviso)                            
                            <tr onclick="selectRow({{ $aviso->id }})">
                                <td>{{$aviso->id}}</td>
                                <td>{{$aviso->titulo}}</td>
                                <td>{{$aviso->descripcion}}</td>
                                <td>{{$aviso->created_at}}</td>
                                <td>{{$aviso->updated_at}}</td>
                                <td>{{$aviso->activo}}</td>
                                <td>{{$aviso->nombre_usr}}</td>
                                <td>{{$aviso->categoria}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!--
            <div class="bg-light p-3 rounded mb-4 mt-4" style="max-width: 200px;">
                <h6 class="text-center font-weight-bold">ELIGE A QUÉ USUARIOS SE ENVÍA</h6>
                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            <i class="bi bi-people-fill"></i> TODOS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            <i class="bi bi-person-fill"></i> SOLO UN GRUPO
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            <i class="bi bi-person-badge-fill"></i> LIMITADOS
                        </a>
                    </li>
                </ul>
            </div> -->

            <button id="editar-btn" class="btn btn-success">Editar</button>
            <button id="eliminar-btn" class="btn btn-danger btn-delete" data-id="{{$aviso->id}}">Eliminar</button>


            <form id="selected-row-form" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
                <input type="hidden" name="row_id" id="row-id">
            </form>

            {{--Script para la funcionalidad de seleccionar los avisos al hacer click--}}
            <script>
                let selectedRowId = null;

                function selectRow(id) {
                    selectedRowId = id;
                    document.getElementById('row-id').value = id;
                }

                document.getElementById('editar-btn').addEventListener('click', function () {
                    if (selectedRowId) {
                        window.location.href = `/Admin/Avisos/edit/${selectedRowId}`;
                    } else {
                        alert('Selecciona un aviso primero');
                    }
                });

                document.addEventListener("DOMContentLoaded", () => {
                    const deleteButtons = document.querySelectorAll(".btn-delete");

                    deleteButtons.forEach(button => {
                        button.addEventListener("click", (e) => {
                            const avisoId = selectedRowId;
                            const deleteForm = document.getElementById("selected-row-form");
                            const deleteUrl = `{{ route('RutaEliminarAviso', ['id' => ':id']) }}`.replace(':id', avisoId);

                            Swal.fire({
                                title: "¿Eliminar Aviso?",
                                text: `Se borrara permanentemente este departamento`,
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Eliminar",
                                cancelButtonText: "Cancelar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    deleteForm.action = deleteUrl;
                                    deleteForm.submit();
                                }
                            });
                        });
                    });
                });

            </script>

            
        </div>
    </div>
</div>

@endsection