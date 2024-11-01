<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorVistas;

<<<<<<< Updated upstream
Route::get('/', function () {
    return view('loginAdmin');
});
=======
Route::get('/', [ControladorVistas::class,'Inicio'])->name('RutaInicio');
Route::get('/Test', [ControladorVistas::class,'Test'])->name('RutaTest');
Route::get('/RegistroUsuario', [ControladorVistas::class,'RegistroUsuario'])->name('RutaRegsitroUsuario');
Route::get('/Perfil', [ControladorVistas::class,'Perfil'])->name('RutaPerfil');
Route::get('/Recuperacion', [ControladorVistas::class,'Recuperacion'])->name('RutaRecuperacion');
Route::get('/Reportes', [ControladorVistas::class,'Reportes'])->name('RutaReportes');
Route::get('/Busqueda', [ControladorVistas::class,'Busqueda'])->name('RutaBusqueda');
>>>>>>> Stashed changes
