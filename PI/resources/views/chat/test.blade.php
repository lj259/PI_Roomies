@extends('layouts.Plantilla1')

@section('titulo', 'Chat Test')

@section('Contenido')

<div class="container mt-4">
    <h1>Test de Chat</h1>
    <p>Si puedes ver esto, las rutas de chat funcionan correctamente.</p>
    <p>Amigos disponibles para chat: {{ $amigos ? $amigos->count() : 'null' }}</p>
    
    @if($amigos && $amigos->count() > 0)
        <h3>Lista de amigos:</h3>
        <ul>
        @foreach($amigos as $amigo)
            <li>{{ $amigo->nombre }} {{ $amigo->apellido_paterno }}</li>
        @endforeach
        </ul>
    @else
        <p>No tienes amigos aún para chatear.</p>
        <a href="{{ route('amigos.index') }}" class="btn btn-primary">Ir a Amigos</a>
    @endif
</div>

@endsection
