<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{


    /**
     * Permissions table
     * Needs:
     * 1. ID
     * 2. access_type
     * 3. access_rights
     * 4. created_date
     * 5. updated_date
     * 6. created_by (user id)
     * 7. updated_by (user id)
     * **********TABLE REPRESENTATION************
     * 
     * ******************************************************************
     * ID | access_type | access_rights | ... Dates | ... BY |
     * 1  |     *       |     all       | ...       | Seeder (auto)
     * 2  | CREATE      |      
     */

    protected $permissions = [
        1 => ['access_type' => '*', 'access_rights' => 'all'], //ONLY ADMIn
        2 => ['access_type' => 'create', 'access_rights' => 2],
        3 => ['access_type' => 'read', 'access_rights' => 3],
        4 => ['access_type' => 'update', 'access_rights' => 4],
        5 => ['access_type' => 'delete', 'access_rights' => 5],
        6 => ['access_type' => 'trash', 'access_rights' => 6],
        7 => ['access_type' => 'all_crud', 'access_rights' => 20], //c+r+u+d+d (2+3+4+5+6)
        8 => ['access_type' => 'read_update_only', 'access_rights' => 7], //r+u (3+4)
        9 => ['access_type' => 'read_update_delete_only', 'access_rights' => 12], //r+u+d (3+4+5)
        10 => ['access_type' => 'read_update_trash_only', 'access_rights' => 13], //r+u+dd (3+4+6)
        11 => ['access_type' => 'read_delete_only', 'access_rights' => 8], //r+d (3+5) 
        12 => ['access_type' => 'read_trash_only', 'access_rights' => 9], //r+t (3+6)
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= count($this->permissions); $i++) {
            DB::table('permissions')->insert([
                'access_type' => $this->permissions[$i]['access_type'],
                'access_rights' => $this->permissions[$i]['access_rights'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
