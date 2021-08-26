<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    protected $group_setup = [
        0 => 'Admin',
        1 => 'Human Resources',
        2 => 'Developers',
        3 => 'SEO',
        4 => 'Contributors',
        5 => 'FrontEnd UI',
        6 => 'Administration',
        7 => 'Sales',
        8 => 'Design'

    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Groups::factory()->create();


        for ($i = 0; $i < count($this->group_setup); $i++) {
            DB::table('groups')->insert([
                'name' => $this->group_setup[$i],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
