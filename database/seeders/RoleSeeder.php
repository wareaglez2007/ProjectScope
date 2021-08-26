<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    protected $role_setup = [
        0 => 'Admin',
        1 => 'Super Admin',
        2 => 'HR Manager',
        3 => 'HR Employee',
        4 => 'IT Manager',
        5 => 'Full Stack Developer',
        6 => 'Frontend Developer',
        7 => 'Backend Developer',
        8 => 'SEO Manager',
        9 => 'SEO Employee',
        10 => 'Author',
        11 => 'QA',
        12 => 'Photography',
        13 => 'Sales Manager',
        14 => 'Sale Associate',
        15 => 'Design Team Leader',
        16 => 'Designer',
        17 => 'Guest',
        18 => 'subscribed User',
        19 => 'Contractor',
        20 => 'Accounting Manager',
        21 => 'Accountant',
        22 => 'Other',
        23 => 'Office Manager',
        24 => 'Admin Assitant',



    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\Roles::factory()->create();
        for ($i = 0; $i < count($this->role_setup); $i++) {
            DB::table('roles')->insert([
                'name' => $this->role_setup[$i],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
