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
Route::get('/EditUser', [ControladorVistas::class,'EditUser'])->name('RutaEditUser'); //NEEDS VALIDATION!!
Route::get('/EditDep', [ControladorVistas::class,'EditDep'])->name('RutaEditDep');
Route::get('/RegDeparta', [ControladorVistas::class,'RegDeparta'])->name('RutaRegDeparta');
// Usuarios
Route::get('/', [ControladorVistas::class,'Inicio'])->name('RutaInicio');
Route::get('/loginUser', [ControladorVistas::class,'LoginUser'])->name('loginUser');
Route::get('/Test', [ControladorVistas::class,'Test'])->name('RutaTest');
Route::get('/RegistroUsuario', [ControladorVistas::class,'RegistroUsuario'])->name('RutaRegsitroUsuario');
Route::get('/Perfil', [ControladorVistas::class,'Perfil'])->name('RutaPerfil');
Route::get('/Recuperacion', [ControladorVistas::class,'Recuperacion'])->name('RutaRecuperacion');
Route::get('/Reportes', [ControladorVistas::class,'Reportes'])->name('RutaReportes');
Route::get('/Busqueda', [ControladorVistas::class,'Busqueda'])->name('RutaBusqueda');
//Validaciones
Route::post('/ValidarTest',[ControladorVistas::class,'ValidarTest']) ->name('ValidarTest');
Route::post('/ValidasUsuario',[ControladorVistas::class,'ValidasUsuario']) ->name('ValidasUsuario');
Route::post('/ValidarUsrLogin',[ControladorVistas::class,'ValidarLoginUsr']) ->name('ValidarUsrLogin');
Route::post('/ValidarAdmLogin',[ControladorVistas::class,'ValidarAdmin']) ->name('ValidarAdmLogin');
Route::post('/ValidarReportes',[ControladorVistas::class,'ValidarReportes']) ->name('ValidarReportes');
Route::post('/ValidarDepa',[ControladorVistas::class,'ValidarDepa']) ->name('ValidarDepa');
Route::post('/ValidarRegActividad',[ControladorVistas::class,'ValidarRegActividad']) ->name('ValidarRegActividad');
Route::post('/ValidarRegAvisos',[ControladorVistas::class,'ValidarRegAvisos']) ->name('ValidarRegAvisos');
Route::post('/ValidarRecuperacion',[ControladorVistas::class,'ValidarRecuperacion']) ->name('ValidarRecuperacion');
Route::post('/ValidarEditDepa',[ControladorVistas::class,'ValidarEditDepa']) ->name('ValidarEditDepa');
Route::post('/ValidarEditUsr',[ControladorVistas::class,'ValidarEditUsr']) ->name('ValidarEditUsr');