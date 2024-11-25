@extends('layouts.plantilla_admins')
@section('titulo', 'Gestión de Usuarios')
@section('Contenido')
@session('Exito')
    <script>
        Swal.fire({
            title: "Registro correcto",
            text: '{{$value}}',
            icon: "success"
        });
    </script>
@endsession
<div class="container-fluid vh-100 p-0">

    <div class="d-flex">
        <!-- Barra lateral de navegación -->
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

        <!-- Contenido principal -->
        <div class="container-fluid bg-info p-4">
            <h3 class="text-center mb-4">Gestión de Usuarios</h3>
            <div class="row mt-4">
                <div class="col-md-6">
                    <a href="#" class="btn btn-success btn-block w-100 py-3 my-4">
                        <i class="bi bi-person-plus-fill"></i> Registrar Usuario
                    </a>
                </div>
                <div class="col-md-6">
                    <select id="editUserSelect" class="form-select my-3">
                        <option value="" disabled selected>Selecciona un usuario</option>
                        @foreach($registros as $datos)
                        <option value="{{$datos->id}}">{{$datos->nombre}}</option>
                        @endforeach
                    </select>
                    
                    <a href="#" id="editUserLink" class="btn btn-success btn-block w-100 py-3 my-4">
                        <i class="bi bi-person-plus-fill"></i> Editar Usuario
                    </a>
                </div>

<div class="col-md-6">
    <select id="deleteUserSelect" class="form-select my-3">
        <option value="" disabled selected>Selecciona un usuario</option>
        @foreach($registros as $datos)
        <option value="{{$datos->id}}">{{$datos->nombre}}</option>
        @endforeach
    </select>
    <form action="#" method="post" id="deleteUserForm">
        @csrf
        <button type="submit" class="btn btn-danger btn-block w-100 py-3 my-4">
            <i class="bi bi-person-dash-fill"></i> Eliminar Usuario
        </button>
    </form>
</div>

                <div class="col-md-6">
                    <a href="#" class="btn btn-secondary btn-block w-100 py-3 my-4">
                        <i class="bi bi-arrow-left"></i> Volver al Inicio
                    </a>
                </div>
            </div>
        </div>

        @foreach ($consulta as $usuario )        
        <div class="card text-justify font-monospace mt-3">
            <div class="card-header fs-5 text-primary">
                {{$usuario->nombre}}
            </div>

            <div class="card-body">
                <h5 class="fw-bold">{{$usuario->email}}</h5>
                <h5 class="fw-medium">{{$usuario->telefono}}</h5>
                <p class="card-text fw-lighter"> </p>
            </div>

            <div class="card-footer text-muted">
                <button type="submit" class="btn btn-warning btn-sm">{{__('Actualizar')}}</button>
                <button type="submit" class="btn btn-danger btn-sm">{{__('Eliminar')}}</button>
            </div>

        </div>
        @endforeach
    </div>
</div>
<script>

    const baseEditUrl = `{{ route('EnvioActualizarUsuario', ['id' => 'PLACEHOLDER']) }}`;

    // Editar Usuario
    document.getElementById('editUserSelect').addEventListener('change', function () {
        const userId = this.value; // Obtiene el valor seleccionado
        const editLink = document.getElementById('editUserLink');
        // Reemplaza el marcador de posición con el ID seleccionado
        editLink.href = baseEditUrl.replace('PLACEHOLDER', userId);
    });
    const basedeletetUrl = `{{ route('EliminacionUsuario', ['id' => 'PLACEHOLDER']) }}`; 

    // Evento para actualizar la acción del formulario al seleccionar un usuario
    document.getElementById('deleteUserSelect')?.addEventListener('change', function () {
        const userId = this.value; // Obtiene el ID seleccionado
        const deleteForm = document.getElementById('deleteUserForm'); 
        deleteForm.action = basedeletetUrl.replace('PLACEHOLDER', userId); // Actualiza la acción del formulario
    });

    // Función para confirmar eliminación
    document.getElementById('deleteUserForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Previene el envío inmediato del formulario

        Swal.fire({
            title: '¿Seguro que desea eliminar el registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: '¡Sí, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Envía el formulario si se confirma
            }
        });
    });
</script>

@endsection