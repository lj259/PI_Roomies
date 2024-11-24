<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorVistas;
use App\Http\Controllers\usuariosController;

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

Route::get('/Admin/Avisos', [ControladorVistas::class,'RegistroAvisos'])->name('RutaRegistroAvisos');
Route::get('/Admin/Avisos/create', [ControladorVistas::class,'RegistroAvisos'])->name('RutaRegistroAvisos');
Route::get('/Admin/Avisos/edit', [ControladorVistas::class,'RegistroAvisos'])->name('RutaRegistroAvisos');

Route::get('/Admin/Users', [ControladorVistas::class,'AdminUsers'])->name('RutaAdminUsers');
Route::get('/Admin/Users/create', [ControladorVistas::class,'AdminUsers'])->name('RutaAdminUsers');
Route::get('/Admin/Users/edit', [ControladorVistas::class,'AdminUsers'])->name('RutaAdminUsers');

Route::get('/Admin/Departamento', [ControladorVistas::class,'RegDeparta'])->name('RutaRegDeparta');
Route::get('/Admin/Departamento/create', [ControladorVistas::class,'RegDeparta'])->name('RutaRegDeparta');
Route::get('/Admin/Departamento/edit', [ControladorVistas::class,'RegDeparta'])->name('RutaRegDeparta');

// Usuarios

Route::get('/', [ControladorVistas::class,'Inicio'])->name('RutaInicio');
Route::get('/Registro', [ControladorVistas::class,'Registro'])->name('RutaRegistro');
Route::post('/Registro',[ControladorVistas::class,'ValidarRegistro']) ->name('ValidarRegistro');

Route::get('/login', [ControladorVistas::class,'LoginUser'])->name('login');
Route::post('/login',[ControladorVistas::class,'ValidarLoginUsr']) ->name('ValidarUsrLogin');

Route::get('/Registro/Usuario', [ControladorVistas::class,'RegistroUsuario'])->name('RutaRegsitroUsuario');

Route::get('/Test', [ControladorVistas::class,'Test'])->name('RutaTest');

Route::get('/Perfil', [ControladorVistas::class,'Perfil'])->name('RutaPerfil');

Route::get('/Recuperacion', [ControladorVistas::class,'Recuperacion'])->name('RutaRecuperacion');

Route::get('/Reportes', [ControladorVistas::class,'Reportes'])->name('RutaReportes');

Route::get('/Busqueda', [ControladorVistas::class,'Busqueda'])->name('RutaBusqueda');

Route::get('/departamentos', [ControladorVistas::class, 'mostrarDepartamentos'])->name('gestion');

//Validaciones

Route::post('/ValidarTest',[ControladorVistas::class,'ValidarTest']) ->name('ValidarTest');

Route::post('/ValidasUsuario',[ControladorVistas::class,'ValidasUsuario']) ->name('ValidasUsuario');


Route::post('/ValidarAdmLogin',[ControladorVistas::class,'ValidarAdmin']) ->name('ValidarAdmLogin');

Route::post('/ValidarReportes',[ControladorVistas::class,'ValidarReportes']) ->name('ValidarReportes');

Route::post('/ValidarDepa',[ControladorVistas::class,'ValidarDepa']) ->name('ValidarDepa');

Route::post('/ValidarRegActividad',[ControladorVistas::class,'ValidarRegActividad']) ->name('ValidarRegActividad');

Route::post('/ValidarRegAvisos',[ControladorVistas::class,'ValidarRegAvisos']) ->name('ValidarRegAvisos');

Route::post('/ValidarRecuperacion',[ControladorVistas::class,'ValidarRecuperacion']) ->name('ValidarRecuperacion');

Route::post('/ValidarEditDepa',[ControladorVistas::class,'ValidarEditDepa']) ->name('ValidarEditDepa');

Route::post('/ValidarEditUsr',[ControladorVistas::class,'ValidarEditUsr']) ->name('ValidarEditUsr');


// Controlador de usuario

Route::get('/Registro/Usuario', [usuariosController::class,'create'])->name('RutaRegsitroUsuario');
Route::post('/ValidasUsuario',[usuariosController::class,'store']) ->name('ValidasUsuario');
Route::get('/verUsuarios', [usuariosController::class, 'show'])->name('RutaUsuarios');

Route::get('/Admin/Users', [ControladorVistas::class,'AdminUsers'])->name('RutaAdminUsers');
Route::get('/Admin/Users/create', [ControladorVistas::class,'AdminUsers'])->name('RutaAdminUsers');
Route::get('/Admin/Users/edit/{id}', [usuariosController::class,'edit'])->name('usuarioEditar');
Route::post('/Admin/Users/edit/{id}', [usuariosController::class,'update'])->name('EnvioActualizarUsuario');
Route::post('/Admin/Users/delete/{id}', [usuariosController::class,'destroy'])->name('EliminacionUsuario');
