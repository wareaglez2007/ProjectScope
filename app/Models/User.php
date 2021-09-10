<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'roles_id',
        'assigned',
        'uuid',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return Role ID and Info Associated with User
     */
    public function userRole()
    {
        return $this->belongsto(Roles::class, 'roles_id', 'id');
    }

    public function GetAllRolesModsPerms()
    {

        return $this->belongsToMany(ModulesPermissionsRoles::class, GroupsRoles::class,'roles_id', 'roles_id', 'roles_id', 'roles_id');
    }


    public function userGroups()
    {
        return $this->belongsTo(GroupsRoles::class, 'roles_id', 'roles_id');
    }
}
