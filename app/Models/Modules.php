<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    use HasFactory;



    protected $modules = [
        1 => 'ProfileController',
        2 => 'ProfileSettingsController',
        3 => 'TodoController',
        4 => 'ProjectsController',
        5 => 'ReminderController',
        6 => 'TicketsController',
        7 => 'EmployeeController',
        8 => 'UserManagementController',
        9 => 'DashboardController',
        10 => 'AccountManagementController',
        11 => 'ThirdPartyAPIController',
        12 => 'FrontendController'
    ];


    public function GetModulesRoles()
    {
        return $this->belongsToMany(Roles::class);
    }

    public function GetModulesPermissions()
    {
        return $this->belongsToMany(Permissions::class, ModulesPermissionsRoles::class);
    }


}
