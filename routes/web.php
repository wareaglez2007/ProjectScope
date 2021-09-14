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
    Route::get('groups/create', [App\Http\Controllers\GroupsController::class, 'create'])->name('admin.groups.create');
    Route::post('groups/store', [App\Http\Controllers\GroupsController::class, 'store'])->name('admin.groups.store');
    Route::get('groups/update', [App\Http\Controllers\GroupsController::class, 'update'])->name('admin.groups.update');
    Route::get('groups/show/{id}', [App\Http\Controllers\GroupsController::class, 'show'])->name('admin.groups.show');
    Route::get('groups/groupspagination', [App\Http\Controllers\GroupsController::class, 'GroupsAjaxPaginationdata']);
    Route::post('groups/search', [App\Http\Controllers\GroupsController::class, 'search']);
    Route::post('groups/search/roles', [App\Http\Controllers\GroupsController::class, 'searchRoles']);
    //groupsrolespagination
    Route::get('groups/show/{id}/groupsrolespagination', [App\Http\Controllers\GroupsController::class, 'GroupsRolesAjaxPaginationdata']);
    //Select 2
    Route::get('groups/show/{id}/rolesupdate', [App\Http\Controllers\GroupsController::class, 'updatewithSelect2']);
    //Group name update = '/admin/groups/show/'+group_id+'/updategroup
    Route::get('groups/show/{id}/updategroup', [App\Http\Controllers\GroupsController::class, 'updateGroupName']);
    //Destroy
    Route::post('groups/destroy', [App\Http\Controllers\GroupsController::class, 'destroy'])->name('admin.groups.destroy');
    //Delete
    Route::post('groups/delete', [App\Http\Controllers\GroupsController::class, 'delete'])->name('admin.groups.delete');
    //Activate
    Route::post('groups/activate', [App\Http\Controllers\GroupsController::class, 'activate'])->name('admin.groups.activate');
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
    Route::get('users/show/{id}', [App\Http\Controllers\UsersController::class, 'show'])->name('admin.users.show');
    Route::get('users/edit/{id}', [App\Http\Controllers\UsersController::class, 'edit'])->name('admin.users.edit');
    Route::get('users/store', [App\Http\Controllers\UsersController::class, 'store'])->name('admin.users.store');
});

Route::middleware('auth')->prefix('users')->group(function () {
    Route::get('profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('user.profile');
});
