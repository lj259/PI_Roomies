<?php

use App\Http\Controllers\AmigosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvisosController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\depasController;
use App\Http\Controllers\usuariosController;
use App\Http\Controllers\PropietarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorVistas;
use App\Http\Controllers\ResetPasww;
use Illuminate\Support\Facades\Broadcast; 

//use App\Http\Controllers\usuariosController;

// Chat en vivo

// Route::get('/chat', [ChatController::class, 'index'])->middleware('auth');

//admin
Route::middleware(['auth','admin'])->group(function(){
    //Eliminar
    Route::get('/Admin/login', [ControladorVistas::class,'loginAdmin'])->name('RutaloginAdmin');
    Route::get('/Admin/logout', [ControladorVistas::class,'logoutAdmin'])->name('RutalogoutAdmin');
    Route::get('/Admin/Home', [ControladorVistas::class,'HomeAdmin'])->name('RutaHomeAdmin');

    //Eliminar
    Route::get('/Admin/Panel', [ControladorVistas::class,'PanelAdmin'])->name('RutaPanelAdmin');
    
    Route::get('/Admin/Roles', [ControladorVistas::class,'Roles'])->name('RutaRoles');
    Route::get('/Admin/Roles/create', [ControladorVistas::class,'Roles'])->name('RutaRoles');
    Route::put('/Admin/Roles/Edit/{usuario}', [ControladorVistas::class, 'Roles_edit'])
    ->name('RolesEdit');
    
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
    Route::post('/Admin/Departamento/Guardar',[depasController::class,'store']) ->name('Registro_Departamento');
    Route::get('/Admin/Departamento/edit/{id}', [depasController::class,'edit'])->name( 'RutaEditDepa');
    Route::put('/Admin/Departamentos/update/{id}', [depasController::class,'update'])->name('RutaUpdateDepa');
    Route::delete('/Admin/Departamentos/delete/{id}', [depasController::class, 'destroy'])->name('RutaDeleteDepa');
    
    Route::get('/Admin/Users', [ControladorVistas::class,'AdminUsers'])->name('RutaAdminUsers');
    Route::get('/Admin/Users/create', [usuariosController::class,'create'])->name('RegistroUsuario');
    Route::get('/Admin/Users/edit/{id}', [usuariosController::class,'edit'])->name('usuarioEditar');
    Route::post('/Admin/Users/edit/{id}', [usuariosController::class,'update'])->name('EnvioActualizarUsuario');
    Route::post('/Admin/Users/delete/{id}', [usuariosController::class,'destroy'])->name('EliminacionUsuario');

    //Propietarios
    Route::get('/Admin/propietarios', [PropietarioController::class, 'index'])->name('propietarios.index');
    Route::get('/Admin/propietarios/crear', [PropietarioController::class, 'create'])->name('propietarios.create');
    Route::post('/Admin/propietarios/crear', [PropietarioController::class, 'store'])->name('propietarios.store');
    Route::get('/Admin/propietarios/{propietario}/editar', [PropietarioController::class, 'edit'])->name('propietarios.edit');
    Route::put('/Admin/propietarios/{propietario}', [PropietarioController::class, 'update'])->name('propietarios.update');
    Route::delete('/Admin/propietarios/{propietario}', [PropietarioController::class, 'destroy'])->name('propietarios.destroy');
    //Fin propietarios

});
//Fin admin

// Usuarios

Route::get('/', [ControladorVistas::class,'Inicio'])->name('RutaInicio');
Route::get('/politica', [ControladorVistas::class,'Politicas'])->name('politica');
Route::get('/about', [ControladorVistas::class,'Sobre'])->name('about');
Route::get('/login', [usuariosController::class,'LoginUser'])->name('login');
Route::post('/login',[usuariosController::class,'login']) ->name('ValidarUsrLogin');
Route::get('/Registro/Usuario', [usuariosController::class,'create'])->name('RutaRegistroUsuario');
Route::post('/Registro/Usuario',[usuariosController::class,'registrar']) ->name('Registrar_Usuario');

Route::middleware(['auth'])->group(function () { 
    
    Route::get('/logout', [usuariosController::class,'logout'])->name('logout');
    
    Route::get('/Perfil', [usuariosController::class,'Perfil'])->name('RutaPerfil');
    Route::post('/Perfil/actualizar', [usuariosController::class,'updateProfile'])->name('RutaActualizarPerfil');
    
    Route::get('/Test', [ControladorVistas::class,'Test'])->name('RutaTest');

    Route::get('/Reportes', [ControladorVistas::class,'Reportes'])->name('RutaReportes');

    Route::get('/Sugerencias', [ControladorVistas::class, 'Sugerencias'])->name('RutaSugerencias');
    
    Route::get('/Busqueda', [ControladorVistas::class,'Busqueda'])->name('RutaBusqueda');
    
    Route::get('/Busqueda/Detalles/{id}/{propietario_id}', [depasController::class,'Detalles'])->name('RutaDetalles');
    
    // Rutas de amigos
    Route::get('/amigos', [AmigosController::class, 'index'])->name('amigos.index');
    Route::get('/amigos/buscar', [AmigosController::class, 'buscar'])->name('amigos.buscar');
    Route::post('/amigos/enviar-solicitud', [AmigosController::class, 'enviarSolicitud'])->name('amigos.enviar-solicitud');
    Route::post('/amigos/responder', [AmigosController::class, 'responderSolicitud'])->name('amigos.responder');
    Route::delete('/amigos/{amigo}/eliminar', [AmigosController::class, 'eliminarAmigo'])->name('amigos.eliminar');
    
    // Rutas de chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/amigo/{amigo}', [ChatController::class, 'chatConAmigo'])->name('chat.conversacion');
    Route::post('/chat/enviar', [ChatController::class, 'enviarMensaje'])->name('chat.enviar-mensaje');
    Route::get('/chat/mensajes/{amigo}', [ChatController::class, 'obtenerMensajes'])->name('chat.obtener-mensajes');
    
    // Add these inside your auth middleware group
    Route::get('/chat/propietarios', [ChatController::class, 'index_props'])->name('chat.propietarios');
    Route::get('/chat/propietario/{propietario}', [ChatController::class, 'chatConPropietario'])->name('chat.propietario');
    Route::post('/chat/propietario/enviar', [ChatController::class, 'enviarMensajePropietario'])->name('chat.enviar-mensaje-propietario');
    Route::get('/chat/propietario/mensajes/{propietario}', [ChatController::class, 'obtenerMensajesPropietario'])->name('chat.obtener-mensajes-propietario');
    // Route::get('/Busqueda/Resultados/{publico}', [depasController::class, 'Resultados'])->name('RutaResultados');
    
    Route::get('/departamentos', [ControladorVistas::class, 'mostrarDepartamentos'])->name('gestion');
    
    Route::get('/Busqueda/Resultados', [depasController::class,'Resultados'])->name('RutaResultados');

    Route::post('/Sugerencias', [ControladorVistas::class, 'crearSugerencia'])->name('crearSugerencia');
});

//Rutas propietarios
// Public routes for propietarios
Route::get('/propietario/registro', [PropietarioController::class, 'showRegistrationForm'])->name('propietario.registro');
Route::post('/propietario/registro', [PropietarioController::class, 'register'])->name('propietario.register');
Route::get('/propietario/login', [PropietarioController::class, 'showLoginForm'])->name('propietario.login');
Route::post('/propietario/login', [PropietarioController::class, 'login'])->name('propietario.login.submit');
Route::post('/propietario/soli_arr/{id_usuario}/{id_apartamento}', [PropietarioController::class, 'crear_soli_arrendamiento'])->name('propietario.soli_arr');

// Protected routes for propietarios (using session-based middleware)
Route::middleware(['propietario'])->group(function () {
    Route::get('/propietario/dashboard', [PropietarioController::class, 'dashboard'])->name('propietario.dashboard');
    Route::get('/propietario/perfil', [PropietarioController::class, 'perfil'])->name('propietario.perfil');
    Route::post('/propietario/perfil/actualizar', [PropietarioController::class, 'updateProfile'])->name('propietario.perfil.actualizar');
    Route::get('/propietario/logout', [PropietarioController::class, 'logout'])->name('propietario.logout');
    Route::get('/propietario/solicitudes', [PropietarioController::class, 'solicitudes'])->name('propietario.solicitudes');


    // Apartment management routes
    Route::get('/propietario/apartamentos', [PropietarioController::class, 'misApartamentos'])->name('propietario.apartamentos');
    Route::get('/propietario/apartamentos/crear', [PropietarioController::class, 'crearApartamento'])->name('propietario.apartamentos.crear');
    Route::post('/propietario/apartamentos/guardar', [PropietarioController::class, 'storeApartamento'])->name('propietario.apartamentos.guardar');
    Route::get('/propietario/apartamentos/{id}/editar', [PropietarioController::class, 'editarApartamento'])->name('propietario.apartamentos.editar');
    Route::put('/propietario/apartamentos/{id}/actualizar', [PropietarioController::class, 'updateApartamento'])->name('propietario.apartamentos.actualizar');
    Route::delete('/propietario/apartamentos/{id}/eliminar', [PropietarioController::class, 'eliminarApartamento'])->name('propietario.apartamentos.eliminar');

    Route::get('/chat/usuario/{usuario}', [ChatController::class, 'chatConUsuarioPropietario'])->name('chat.propietario.usuario');
    Route::post('/chat/usuario/enviar', [ChatController::class, 'enviarMensajeComoPropietario'])->name('chat.propietario.enviar-mensaje');
    Route::get('/chat/usuario/mensajes/{usuario}', [ChatController::class, 'obtenerMensajesPropietarioUsuario'])->name('chat.propietario.obtener-mensajes');
});

Route::middleware(['auth'])->group(function () { 

    
});


//Fin usuarios
//validaciones
Route::post('/ValidarTest',[ControladorVistas::class,'ValidarTest']) ->name('ValidarTest');

Route::post('/ValidarAdmLogin',[ControladorVistas::class,'ValidarAdmin']) ->name('ValidarAdmLogin');

Route::post('/ValidarReportes',[ControladorVistas::class,'ValidarReportes']) ->name('ValidarReportes');

Route::post('/ValidarRegActividad',[ControladorVistas::class,'ValidarRegActividad']) ->name('ValidarRegActividad');

Route::post('/ValidarRegAvisos',[ControladorVistas::class,'ValidarRegAvisos']) ->name('ValidarRegAvisos');

Route::post('/ValidarRecuperacion',[ControladorVistas::class,'ValidarRecuperacion']) ->name('ValidarRecuperacion');

Route::post('/ValidarEditDepa',[ControladorVistas::class,'ValidarEditDepa']) ->name('ValidarEditDepa');

Route::post('/ValidarEditUsr',[ControladorVistas::class,'ValidarEditUsr']) ->name('ValidarEditUsr');

//Fin Validaciones

// Controlador de usuario




//Rutas del merge de ver la info de departementos y perfil

//Ruta recuperacion de constraseña *cambiar a metodo de email mas adelante
Route::get('/Recuperacion', [ControladorVistas::class,'Recuperacion'])->name('RutaRecuperacion');
Route::get('/Recuperacion/Nueva', [ControladorVistas::class,'Nueva'])->name('RutaRecuperacionNueva');
Route::post('/Recuperacion/Nueva', [ResetPasww::class,'NuevaContraseña'])->name('Recuperacion_pssw');
    
// Compobar las rutas repeticdas
    

    Route::get('/Busqueda/Resultados', [depasController::class,'Resultados'])->name('RutaResultados');
    
    
    
    //validaciones
    Route::post('/ValidarTest',[ControladorVistas::class,'ValidarTest']) ->name('ValidarTest');
    
    Route::post('/ValidarAdmLogin',[ControladorVistas::class,'ValidarAdmin']) ->name('ValidarAdmLogin');
    
    Route::post('/ValidarReportes',[ControladorVistas::class,'ValidarReportes']) ->name('ValidarReportes');
    
    Route::post('/ValidarRegActividad',[ControladorVistas::class,'ValidarRegActividad']) ->name('ValidarRegActividad');
    
    Route::post('/ValidarRegAvisos',[ControladorVistas::class,'ValidarRegAvisos']) ->name('ValidarRegAvisos');
    
    Route::post('/ValidarRecuperacion',[ControladorVistas::class,'ValidarRecuperacion']) ->name('ValidarRecuperacion');
    
    Route::post('/ValidarEditDepa',[ControladorVistas::class,'ValidarEditDepa']) ->name('ValidarEditDepa');
    
    Route::post('/ValidarEditUsr',[ControladorVistas::class,'ValidarEditUsr']) ->name('ValidarEditUsr');
    
    //Fin Validaciones
    
    // Controlador de usuario
    
    
    
    
    //Rutas del merge de ver la info de departementos y perfil
    Route::get('/departamentos', [ControladorVistas::class, 'mostrarDepartamentos'])->name('gestion');
    
    
    
    //Ruta recuperacion de constraseña *cambiar a metodo de email mas adelante
    Route::get('/Recuperacion', [ControladorVistas::class,'Recuperacion'])->name('RutaRecuperacion');
    Route::get('/Recuperacion/Nueva', [ControladorVistas::class,'Nueva'])->name('RutaRecuperacionNueva');
    Route::post('/Recuperacion/Nueva', [ResetPasww::class,'NuevaContraseña'])->name('Recuperacion_pssw');


//Fin usuarios