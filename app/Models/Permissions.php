<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;




   public const ALL = '*';
   public const CREATE = 2;
   public const READ = 3;
   public const UPDATE = 4;
   public const DELETE = 5;
   public const TRASH = 6;
   public const ALL_CRUD = 20;
   public const READ_UPDATE_ONLY = 7;
   public const READ_UPDATE_DELETE_ONLY = 12;
   public const READ_UPDATE_TRASH_ONLY = 13;
   public const READ_DELETE_ONLY = 8;
   public const READ_TRSH_ONLY = 9;


}
