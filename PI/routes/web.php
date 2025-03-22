<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvisosController;
use App\Http\Controllers\depasController;
use App\Http\Controllers\usuariosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorVistas;
//use App\Http\Controllers\usuariosController;

//admin
Route::get('/Admin/login', [ControladorVistas::class,'loginAdmin'])->name('RutaloginAdmin');
Route::get('/Admin/logout', [ControladorVistas::class,'logoutAdmin'])->name('RutalogoutAdmin');
Route::get('/Admin/Home', [ControladorVistas::class,'HomeAdmin'])->name('RutaHomeAdmin');
Route::get('/Admin/Panel', [ControladorVistas::class,'PanelAdmin'])->name('RutaPanelAdmin');

Route::get('/Admin/Roles', [ControladorVistas::class,'Roles'])->name('RutaRoles');
Route::get('/Admin/Roles/create', [ControladorVistas::class,'Roles'])->name('RutaRoles');
Route::get('/Admin/Roles/edit', [ControladorVistas::class,'Roles'])->name('RutaRoles');

Route::get('/Admin/Actividad', [ControladorVistas::class,'RegistroActividad'])->name('RutaRegistroActividad');
Route::get('/Admin/Actividad/create', [ControladorVistas::class,'RegistroActividad'])->name('RutaRegistroActividad');
Route::get('/Admin/Actividad/edit', [ControladorVistas::class,'RegistroActividad'])->name('RutaRegistroActividad');

Route::get('/Admin/Avisos', [AvisosController::class,'index'])->name('RutaVerAvisos');
Route::get('/Admin/Avisos/create', [AvisosController::class,'create'])->name('RutaRegistroAvisos');
Route::post('/Admin/Avisos/store', [AvisosController::class,'store'])->name('ValidarAviso');
Route::get('/Admin/Avisos/edit/{id}', [AvisosController::class,'edit'])->name('RutaEditarAvisos');
Route::put('/Admin/Avisos/update/{id}', [AvisosController::class,'update'])->name('RutaUpdateAviso');
Route::delete('/Admin/Avisos/delete/{id}', [AvisosController::class,'destroy'])->name('RutaEliminarAviso');


//Route::get('/Admin/Departamento/create', [ControladorVistas::class,'RegDeparta'])->name('RutaRegDeparta');
Route::get('/Admin/Departamento', [depasController::class, 'index'])->name('Ruta_gestion_depas');
Route::get('/Admin/Departamento/create', [depasController::class,'create'])->name('RutaRegDeparta');
Route::post('/ValidarDepa',[depasController::class,'store']) ->name('ValidarDepa');
Route::get('/Admin/Departamento/edit/{id}', [depasController::class,'edit'])->name( 'RutaEditDepa');
Route::put('/Admin/Departamentos/update/{id}', [depasController::class,'update'])->name('RutaUpdateDepa');
Route::delete('/Admin/Departamentos/delete/{id}', [depasController::class, 'destroy'])->name('RutaDeleteDepa');
// Usuarios

Route::get('/', [ControladorVistas::class,'Inicio'])->name('RutaInicio');

Route::get('/login', [ControladorVistas::class,'LoginUser'])->name('login');
Route::post('/login',[AuthController::class,'login']) ->name('ValidarUsrLogin');


Route::get('/Test', [ControladorVistas::class,'Test'])->name('RutaTest');

Route::get('/Perfil', [AuthController::class,'Perfil'])->name('RutaPerfil');



Route::get('/Reportes', [ControladorVistas::class,'Reportes'])->name('RutaReportes');

Route::get('/Busqueda', [ControladorVistas::class,'Busqueda'])->name('RutaBusqueda');

Route::get('/Busqueda/Detalles', [ControladorVistas::class,'Busqueda'])->name('RutaDeatalles');

Route::post('/ValidarTest',[ControladorVistas::class,'ValidarTest']) ->name('ValidarTest');



Route::post('/ValidarAdmLogin',[ControladorVistas::class,'ValidarAdmin']) ->name('ValidarAdmLogin');

Route::post('/ValidarReportes',[ControladorVistas::class,'ValidarReportes']) ->name('ValidarReportes');

Route::post('/ValidarRegActividad',[ControladorVistas::class,'ValidarRegActividad']) ->name('ValidarRegActividad');

Route::post('/ValidarRegAvisos',[ControladorVistas::class,'ValidarRegAvisos']) ->name('ValidarRegAvisos');

Route::post('/ValidarRecuperacion',[ControladorVistas::class,'ValidarRecuperacion']) ->name('ValidarRecuperacion');

Route::post('/ValidarEditDepa',[ControladorVistas::class,'ValidarEditDepa']) ->name('ValidarEditDepa');

Route::post('/ValidarEditUsr',[ControladorVistas::class,'ValidarEditUsr']) ->name('ValidarEditUsr');


// Controlador de usuario

Route::get('/Registro/Usuario', [usuariosController::class,'create'])->name('RutaRegistroUsuario');
Route::post('/ValidasUsuario',[usuariosController::class,'store']) ->name('ValidasUsuario');

Route::get('/Admin/Users', [ControladorVistas::class,'AdminUsers'])->name('RutaAdminUsers');
Route::get('/Admin/Users/create', [usuariosController::class,'create'])->name('RegistroUsuario');
Route::get('/Admin/Users/edit/{id}', [usuariosController::class,'edit'])->name('usuarioEditar');
Route::post('/Admin/Users/edit/{id}', [usuariosController::class,'update'])->name('EnvioActualizarUsuario');
Route::post('/Admin/Users/delete/{id}', [usuariosController::class,'destroy'])->name('EliminacionUsuario');

//Rutas del merge de ver la info de departementos y perfil
Route::get('/Busqueda/Resultados', [depasController::class,'Resultados'])->name('RutaResultados');
Route::get('/departamentos', [ControladorVistas::class, 'mostrarDepartamentos'])->name('gestion');


use App\Http\Controllers\ResetPasww;
//Ruta recuperacion de constraseña *cambiar a metodo de email mas adelante
Route::get('/Recuperacion', [ControladorVistas::class,'Recuperacion'])->name('RutaRecuperacion');
Route::get('/Recuperacion/Nueva', [ControladorVistas::class,'Nueva'])->name('RutaRecuperacionNueva');
Route::post('/Recuperacion/Nueva', [ResetPasww::class,'NuevaContraseña'])->name('Recuperacion_pssw');