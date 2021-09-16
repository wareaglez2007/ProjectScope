<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id',
        'roles_id',
    ];
    // public function RolesUsers(){
    //     return $this->belongsToMany(Roles::class, User::class,  'roles_id', 'users_id');
    // }



}
