<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorVistas;

//admin
Route::get('/loginAdmin', [ControladorVistas::class,'loginAdmin'])->name('RutaloginAdmin');
Route::get('/Roles', [ControladorVistas::class,'Roles'])->name('RutaRoles');
Route::get('/RegistroActividad', [ControladorVistas::class,'RegistroActividad'])->name('RutaRegistroActividad');
Route::get('/RegistroAvisos', [ControladorVistas::class,'RegistroAvisos'])->name('RutaRegistroAvisos');
Route::get('/AdminUsers', [ControladorVistas::class,'AdminUsers'])->name('RutaAdminUsers');
Route::get('/PanelAdmin', [ControladorVistas::class,'PanelAdmin'])->name('RutaPanelAdmin');
Route::get('/EditUser', [ControladorVistas::class,'EditUser'])->name('RutaEditUser');
Route::get('/EditDep', [ControladorVistas::class,'EditDep'])->name('RutaEditDep');
Route::get('/RegDeparta', [ControladorVistas::class,'RegDeparta'])->name('RutaRegDeparta');
// Usuarios
Route::get('/', [ControladorVistas::class,'Inicio'])->name('RutaInicio');
Route::get('/Test', [ControladorVistas::class,'Test'])->name('RutaTest');
Route::get('/RegistroUsuario', [ControladorVistas::class,'RegistroUsuario'])->name('RutaRegsitroUsuario');
Route::get('/Perfil', [ControladorVistas::class,'Perfil'])->name('RutaPerfil');
Route::get('/Recuperacion', [ControladorVistas::class,'Recuperacion'])->name('RutaRecuperacion');
Route::get('/Reportes', [ControladorVistas::class,'Reportes'])->name('RutaReportes');
Route::get('/Busqueda', [ControladorVistas::class,'Busqueda'])->name('RutaBusqueda');
Route::get('/Prueba', [ControladorVistas::class,'Prueba'])->name('RutaPrueba');
