@extends('layouts.plantilla_propietarios')
@section('titulo', 'Solicitud')
@section('Contenido')

    <link rel="stylesheet" href="{{asset('css/perfil.css')}}">
    <main class="d-flex flex-column min-vh-100">
        <!-- Solicitudes Pendientes -->
        @foreach($solicitudes as $solicitud)
            <div class="solicitud">
                <h4>Solicitud #{{ $solicitud->id }}</h4>
                <p>Apartamento: {{ $solicitud->apartamento->titulo }}</p>
                <p>Solicitante: {{ $solicitud->usuario->nombre }}</p>
                <p>Estado: {{ $solicitud->estado }}</p>


            </div>
        @endforeach


        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bell"></i> Solicitudes de Amistad</h5>
            </div>
            <div class="card-body">
                @foreach($solicitudes as $solicitud)
                    <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                        <div class="d-flex align-items-center">
                            @if($solicitud->usuario_id->foto_perfil && $solicitud->usuario_id->foto_perfil !== 'perfil/default.jpg')
                                <img src="{{ asset('storage/' . $solicitud->usuario_id->foto_perfil) }}" alt="Foto de perfil"
                                    class="rounded-circle me-3" width="50" height="50">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                    style="width: 50px; height: 50px;">
                                    {{ strtoupper(substr($solicitud->usuario_id->nombre, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-0">{{ $solicitud->usuario_id->nombre }}
                                    {{ $solicitud->usuario_id->apellido_paterno }}
                                </h6>
                                <small class="text-muted">{{ $solicitud->usuario_id->correo }}</small>
                            </div>
                        </div>
                        <div>
                            <form method="POST" action="{{ route('amigos.responder') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">
                                <input type="hidden" name="accion" value="aceptar">
                                <button type="submit" class="btn btn-success btn-sm me-2">
                                    <i class="fas fa-check"></i> Aceptar
                                </button>
                            </form>
                            <form method="POST" action="{{ route('amigos.responder') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">
                                <input type="hidden" name="accion" value="rechazar">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-times"></i> Rechazar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

@endsection