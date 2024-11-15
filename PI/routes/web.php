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

// Ruta para la vista de inicio de sesión
Route::view('/admin/login', 'login')->name('admin.login');

// Ruta para la vista de inicio administrativa
Route::view('/admin/home', 'home')->name('admin.home');

// Rutas para la gestión de usuarios
Route::view('/admin/users', 'users')->name('admin.users');
Route::view('/admin/users/create', 'create_user')->name('admin.users.create');
Route::view('/admin/users/edit', 'edit_user')->name('admin.users.edit');

// Rutas para la gestión de departamentos
Route::view('/admin/departments', 'departments')->name('admin.departments');
Route::view('/admin/departments/create', 'create_department')->name('admin.departments.create');
Route::view('/admin/departments/edit', 'edit_department')->name('admin.departments.edit');

// Rutas para la gestión de avisos
Route::view('/admin/notices', 'notices')->name('admin.notices');
Route::view('/admin/notices/create', 'create_notice')->name('admin.notices.create');
Route::view('/admin/notices/edit', 'edit_notice')->name('admin.notices.edit');

// Ruta para el cierre de sesión
Route::view('/admin/logout', 'login')->name('admin.logout');

Route::post('/ValidarUsrLogin',[ControladorVistas::class,'ValidarLoginUsr']) ->name('ValidarUsrLogin');
Route::post('/ValidarAdmLogin',[ControladorVistas::class,'ValidarAdmin']) ->name('ValidarAdmLogin');
Route::post('/ValidarReportes',[ControladorVistas::class,'ValidarReportes']) ->name('ValidarReportes');
Route::post('/ValidarDepa',[ControladorVistas::class,'ValidarDepa']) ->name('ValidarDepa');
Route::post('/ValidarRegActividad',[ControladorVistas::class,'ValidarRegActividad']) ->name('ValidarRegActividad');
Route::post('/ValidarRegAvisos',[ControladorVistas::class,'ValidarRegAvisos']) ->name('ValidarRegAvisos');
Route::post('/ValidarRecuperacion',[ControladorVistas::class,'ValidarRecuperacion']) ->name('ValidarRecuperacion');
Route::post('/ValidarEditDepa',[ControladorVistas::class,'ValidarEditDepa']) ->name('ValidarEditDepa');
Route::post('/ValidarEditUsr',[ControladorVistas::class,'ValidarEditUsr']) ->name('ValidarEditUsr');