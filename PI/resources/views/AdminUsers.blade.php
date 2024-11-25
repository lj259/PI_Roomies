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
<main class="container-fluid vh-100 p-0">

        <!-- Contenido principal -->
        <div class="container-fluid bg-info p-4">
            <h3 class="text-center mb-4">Gestión de Usuarios</h3>
            <div class="row mt-4">
                <div>
                    <a href="{{route('RutaRegistroUsuario')}}" class="btn btn-success btn-block w-100 py-3 my-4">
                        <i class="bi bi-person-plus-fill"></i> Registrar Usuario
                    </a>
                </div>

            @foreach ($consulta as $usuario)        
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
                <a href="{{route('usuarioEditar',['id'=>$usuario->id])}}" class="btn btn-warning btn-sm">{{__('Actualizar')}}</a>
                <form action="{{ route('EliminacionUsuario', ['id' => $usuario->id]) }}" method="post" id="deleteUserForm">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-block w-100 py-3 my-4">
                        <i class="bi bi-person-dash-fill"></i> Eliminar Usuario
                    </button>
                </form>
            </div>

        </div>
        @endforeach

        <div>
                    <a href="#" class="btn btn-secondary btn-block w-100 py-3 my-4">
                        <i class="bi bi-arrow-left"></i> Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
  
</main>
<script>

    const baseEditUrl = `{{ route('EnvioActualizarUsuario', ['id' => 'PLACEHOLDER']) }}`;

    // Editar Usuario
    document.getElementById('editUserSelect').addEventListener('change', function () {
        const userId = this.value; // Obtiene el valor seleccionado
        const editLink = document.getElementById('editUserLink');
        // Reemplaza el marcador de posición con el ID seleccionado
        editLink.href = baseEditUrl.replace('PLACEHOLDER', userId);
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