@extends('layouts.plantilla_admins')
@section('titulo', 'Registrar Departamento')
@section('Contenido')

<link rel="stylesheet" href="{{asset('css/gestion_depas.css')}}">
@session('registrado')
    <script>
        Swal.fire({
            title: "Departamento registrado",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession

@session('actualizado')
    <script>
        Swal.fire({
            title: "Departamento actualizado",
            text: "{{$value}}",
            icon: "success"
        });
    </script>
@endsession

@session('eliminado')
    <script>
        Swal.fire({
            title: "Departamento eliminado",
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
            <li class="nav-item">
                <a href="{{route('RutaRegDeparta')}}" class="nav-link text-dark d-flex align-items-center">Registrar
                    departamentos</a>
            </li>
        </ul>
    </div>


    <div class="container mt-5 col-md-8">
        @foreach ($departamentos as $depa)
            <div class="card text-justify font-monospace mt-3">
                <div class="card-header fs-5 text-primary">
                    Ubicación: {{ $depa->ubicacion }}
                </div>

                <div class="card-body">
                    <h5 class="fw-bold">Precio: ${{$depa->precio}} mensuales</h5>
                    <h5 class="fw-bold">Baños: {{$depa->baños}} | Habitaciones: {{$depa->habitaciones}} </h5>
                    <h5 class="fw-bold">Restricciones: {{ $depa->restricciones }} </h5>
                    <h5 class="fw-bold">Cercanias: {{ $depa->cercanias }} </h5>
                    <h5 class="fw-bold">Servicios: {{ $depa->servicios }} </h5>
                </div>

                <div class="card-footer text-muted">
                    <a href="{{ route('RutaEditDepa', ['id' => $depa->id]) }}" class="btn btn-warning btn-sm">
                        {{ __('Actualizar') }}
                    </a>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $depa->id }}">
                        {{ __('Eliminar') }}
                    </button>
                </div>
            </div>
        @endforeach
    </div>



    {{-- form para hacer el delete --}}
    <form id="deleteForm" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const deleteButtons = document.querySelectorAll(".btn-delete");

            deleteButtons.forEach(button => {
                button.addEventListener("click", (e) => {
                    const depaID = button.getAttribute("data-id");
                    const deleteForm = document.getElementById("deleteForm");
                    const deleteUrl = `{{ route('RutaDeleteDepa', ['id' => ':id']) }}`.replace(':id', depaID);

                    Swal.fire({
                        title: "¿Eliminar departamento?",
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

@endsection