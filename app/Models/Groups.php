<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'deleted_at',
        'updated_at'
    ];

    public const ADMIN_GROUP = "wareaglez2007@hotmail.com";

    /**
     * @param String where
     * @param String value
     * @return int count
     */
    public function GetGroupCount(String $where = null, String $value = null)
    {
        if ($where == null) {
            return $this->get()->count();
        } else {
            return $this->where($where, $value)->get()->count();
        }
    }

    /**
     * @param String where
     * @return array from groups table
     */
    public function GetAllGroups(String $where = null, $paginate = false, int $paginate_num = 0, String $paginate_sortby = null, String $paginate_direction = 'ASC', $trashed = false)
    {
        if ($paginate && !$trashed) {
            return $this->with('GroupRoles')->orderby($paginate_sortby, $paginate_direction)->paginate($paginate_num);
        } else if ($paginate && $trashed) {
            return $this->onlyTrashed()->with('GroupRoles')->orderby($paginate_sortby, $paginate_direction)->paginate($paginate_num);
        } else if ($trashed && !$paginate) {
            return $this->withTrashed()->orderby($paginate_sortby, $paginate_direction)->get();
        } else {
            return $this->get();
        }
    }

    public function RolesforGroups()
    {
        return $this->belongsToMany(Roles::class);
    }

    /**
     * I will need to create a relation between Groups and Roles
     * Groups_id
     * Roles_id
     */

    public function Roles()
    {
        return $this->belongsToMany(Roles::class);
    }



    public function GroupRoles()
    {
        return $this->hasMany(GroupsRoles::class);
    }



    /**
     * this will return all the roles assigned to a user
     */
    public function groles()
    {
        return $this->belongsToMany(Roles::class, 'groups_roles', 'groups_id')->orderby('id', 'ASC');
    }
}
