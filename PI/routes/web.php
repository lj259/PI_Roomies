<?php

use Illuminate\Support\Facades\Route;

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
