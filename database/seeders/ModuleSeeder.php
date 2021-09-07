<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    protected $module_setup = [
        0 => 'GroupsController',
        1 => 'RolesController',
        2 => 'PermissionsController',
        3 => 'ModulesController',
        4 => 'ToDoController',
        5 => 'RemindersController',
        6 => 'Administration',
        7 => 'ProjectsController',
        8 => 'TicketsController',
        9 => 'EmployeesController',
        10 => 'AllControllers',

    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < count($this->module_setup); $i++) {
            DB::table('modules')->insert([
                'name' => $this->module_setup[$i],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
