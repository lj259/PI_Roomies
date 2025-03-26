@extends('layouts.Plantilla1')
@section('titulo', 'Perfil')
@section('Contenido')

<link rel="stylesheet" href="{{asset('css/perfil.css')}}">

    <!--
                                    <div class="bg-danger text-white d-flex align-items-center px-3" style="height: 60px; font-size: 18px;">
                                        <div>Perfil de Usuario</div>
                                        <div class="ml-auto text-white" style="cursor: pointer; font-size: 16px;">✏️ Editar perfil usuario</div>
                                    </div>-->
    <main class="min-vh-100">
        <div class="container mt-4">
            <div class="row align-items-start">


                <div class="col-md-3 text-center">
                    <img src="..." alt="" class="img-fluid rounded" style="width: 120px;">
                </div>


                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Información del perfil</h3>
                            <p class="card-text">
                                <strong>Nombre:</strong> {{ $usuario->nombre ?? 'Información no disponible'}}<br>
                                <strong>Género:</strong> @if($usuario->genero == 'h')
                                            Masculino
                                        @elseif($usuario->genero == 'm')
                                            Femenino
                                        @elseif($usuario->genero == 'o')
                                            Otro
                                        @else
                                            Selecciona tu género
                                        @endif
                                        <br>
                                <strong>Teléfono:</strong> {{ $usuario->telefono ?? 'Información no disponible' }}<br>
                                <strong>Correo Electrónico:</strong> {{ $usuario->correo}}<br>
                                <strong>Fecha de registro:</strong>
                                {{ $usuario->created_at ?? 'Información no disponible' }}
                            </p>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editarPerfilModal">Editar perfil</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br><br>

        <!-- Modal -->
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
                        <form>
                            <div class="mb-3">
                                <label for="nombre" class="col-form-label">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" value="{{ $usuario->nombre }}">
                            </div>

                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="col-form-label">Correo:</label>
                                <input type="text" class="form-control" name="telefono" value="{{$usuario->correo}}">
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="col-form-label">Telefono:</label>
                                <input type="text" class="form-control" name="telefono" value="{{$usuario->telefono}}">
                            </div>
                            <div class="mb-3">
                                <label for="">Género</label>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        @if($usuario->genero == 'h')
                                            Masculino
                                        @elseif($usuario->genero == 'm')
                                            Femenino
                                        @elseif($usuario->genero == 'o')
                                            Otro
                                        @else
                                            Selecciona tu género
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        <li><a class="dropdown-item {{ $usuario->genero === 'h' ? 'active' : '' }}" href="#">Masculino</a></li>
                                        <li><a class="dropdown-item {{ $usuario->genero === 'm' ? 'active' : '' }}" href="#">Femenino</a></li>
                                        <li><a class="dropdown-item {{ $usuario->genero === 'o' ? 'active' : '' }}" href="#">Otro</a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-outline-primary">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Importante para que no se aparesca el mensaje de bienvenida cada vez -->
    

@endsection