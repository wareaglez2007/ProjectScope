<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'updated_at'
    ];

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
    public function GetAllGroups(String $where = null, $paginate = false, int $paginate_num = 0, String $paginate_sortby = null, String $paginate_direction = 'ASC')
    {
        if ($paginate) {
            return $this->with('GroupRoles')->orderby($paginate_sortby, $paginate_direction)->paginate($paginate_num);
        } else {
            return $this->get();
        }
    }

    /**
     * I will need to create a relation between Groups and Roles
     * Groups_id
     * Roles_id
     */

    public function Roles(String $var = null)
    {
        return $this->hasMany(GroupsRoles::class);
    }
    public function GroupRoles()
    {
        return $this->hasMany(GroupsRoles::class);
    }
}
