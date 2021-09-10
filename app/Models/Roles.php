<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Roles extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name',
        'deleted_at',
        'updated_at'
    ];



    public function GetRolesModules()
    {
        return $this->belongsToMany(Modules::class);
    }

    public function GetGroups(){
        return $this->belongsToMany(Groups::class);
    }


    //  /**
    //  * I will need to create a relation between Groups and Roles
    //  * Groups_id
    //  * Roles_id
    //  */

    // public function Modules()
    // {
    //     return $this->belongsToMany(Modules::class);
    // }
}
