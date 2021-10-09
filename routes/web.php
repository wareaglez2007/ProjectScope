<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/**
 * Group the routes
 *
 * /admin/
 *
 * /user/
 *
 * /superuser/
 *
 *
 */
Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->prefix('admin')->group(function () {

    /**
     * Profile Controller
     */
    Route::get('profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('admin.profile');
    Route::get('profile/create', [App\Http\Controllers\ProfileController::class, 'create'])->name('admin.profile.create');
    /**
     * Group Controller
     */
    Route::get('groups', [App\Http\Controllers\GroupsController::class, 'index'])->name('admin.groups');
    Route::get('groups/getgroups', [App\Http\Controllers\GroupsController::class, 'GetGroupsData'])->name('admin.groups.getgroups');
    Route::get('groups/create', [App\Http\Controllers\GroupsController::class, 'create'])->name('admin.groups.create');
    Route::post('groups/store', [App\Http\Controllers\GroupsController::class, 'store'])->name('admin.groups.store');
    Route::post('groups/{id}/update', [App\Http\Controllers\GroupsController::class, 'update'])->name('admin.groups.update');
    Route::get('groups/{id}/show', [App\Http\Controllers\GroupsController::class, 'show'])->name('admin.groups.show');
    Route::get('groups/{id}/edit', [App\Http\Controllers\GroupsController::class, 'edit'])->name('admin.groups.edit');
    Route::post('groups/{id}/destroy', [App\Http\Controllers\GroupsController::class, 'destroy'])->name('admin.groups.destroy');



    /**
     * Roles Controller
     */
    Route::get('roles', [App\Http\Controllers\RolesController::class, 'index'])->name('admin.roles');
    Route::get('roles/create', [App\Http\Controllers\RolesController::class, 'create'])->name('admin.roles.create');
    Route::get('roles/update/{id}', [App\Http\Controllers\RolesController::class, 'update'])->name('admin.roles.update');
    Route::get('roles/show/{id}', [App\Http\Controllers\RolesController::class, 'show'])->name('admin.roles.show');
    Route::get('roles/edit/{id}', [App\Http\Controllers\RolesController::class, 'edit'])->name('admin.roles.edit');
    Route::get('roles/store', [App\Http\Controllers\RolesController::class, 'store'])->name('admin.roles.store');

    /**
     * Permissions Controller
     */
    Route::get('permissions', [App\Http\Controllers\PermissionsController::class, 'index'])->name('admin.permissions');
    Route::get('permissions/create', [App\Http\Controllers\PermissionsController::class, 'create'])->name('admin.permissions.create');
    Route::get('permissions/update', [App\Http\Controllers\PermissionsController::class, 'update'])->name('admin.permissions.update');
    Route::get('permissions/getpermissions', [App\Http\Controllers\PermissionsController::class, 'GetPermissionsData'])->name('admin.permissions.getpermissions');

    /**
     * Module Controller
     */
    Route::get('modules', [App\Http\Controllers\ModulesController::class, 'index'])->name('admin.modules');
    Route::get('modules/create', [App\Http\Controllers\ModulesController::class, 'create'])->name('admin.modules.create');
    Route::get('modules/update', [App\Http\Controllers\ModulesController::class, 'update'])->name('admin.modules.update');

    /**
     * Users Management & Assignments (roles/permissions)
     */

    Route::get('users', [App\Http\Controllers\UsersController::class, 'index'])->name('admin.users');
    Route::get('users/getusers', [App\Http\Controllers\UsersController::class, 'GetUsersData'])->name('admin.users.getusers');
    Route::get('users/create', [App\Http\Controllers\UsersController::class, 'create'])->name('admin.users.create');
    Route::get('users/{id}/show', [App\Http\Controllers\UsersController::class, 'show'])->name('admin.users.show');
    Route::get('users/{id}/edit', [App\Http\Controllers\UsersController::class, 'edit'])->name('admin.users.edit');
    Route::get('users/store', [App\Http\Controllers\UsersController::class, 'store'])->name('admin.users.store');
    Route::post('users/{id}/update', [App\Http\Controllers\UsersController::class, 'update'])->name('admin.users.update');
    Route::post('users/{id}/destroy', [App\Http\Controllers\UsersController::class, 'destroy'])->name('admin.users.destroy');
});

Route::middleware('auth')->prefix('users')->group(function () {
    Route::get('profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('user.profile');
});
