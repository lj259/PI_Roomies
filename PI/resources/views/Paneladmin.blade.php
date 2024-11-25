@extends('layouts.plantilla_admins')
@section('titulo', 'Panel Administrativo')
@section('Contenido')
<link rel="stylesheet" href="{{asset('css/panel_admin.css')}}">

    
    <div class="container-fluid bg_panel min-vh-100">
        <div class="row">
            <h2 class="text-center text-light my-4">Panel Administrativo</h2>
            <div class="col-md-4 mx-auto d-flex flex-column align-items-center">
                <a href="{{ route('RutaAdminUsers',['id'=> request()->route('id')])  }}" class="btn btn-outline-light w-100 py-3 my-3 text-center">
                    <i class="bi bi-people-fill"></i> Gestión de Usuarios
                </a>
                <a href="#" class="btn btn-outline-light w-100 py-3 my-3 text-center">
                    <i class="bi bi-building"></i> Gestión de Departamentos
                </a>
                <a href="#" class="btn btn-outline-light w-100 py-3 my-3 text-center">
                    <i class="bi bi-bell-fill"></i> Gestión de Avisos
                </a>
            </div>
        </div>
    </div>


@endsection