<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Route;
class ModuleSeeder extends Seeder
{

    protected function GetAllControllersName(){
        $controllers = [];
        foreach (Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getAction();

            if (array_key_exists('controller', $action)) {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                $controllers[] = explode('@', $action['controller']);
                $new = [];
                foreach($controllers as $x => $val){

                    $new[$x] = last(explode('\\', $val[0]));

                }
            }

        }
        $res = array_unique($new);
        return $res;
    }




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
        //dump($this->GetAllControllersName());
        foreach ($this->GetAllControllersName() as $mods) {
            DB::table('modules')->insert([
                'name' => $mods,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
