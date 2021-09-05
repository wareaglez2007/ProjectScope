<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Roles extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $roles = [
        'groups' =>
        [
            'Admin' => [ //Admin group's rights
                'roles' => [
                    'admin' => [
                        'permissions' => [
                            'mod_access' => [
                                'ALL' => [
                                    'access_type' => ['*'] // {*} means ALL access types
                                ]
                            ],

                        ]
                    ],
                    'super_user' => [
                        'permissions' => [
                            'mod_access' => [
                                'ALL_ADMIN_MODS' => [ //{includes: Profile, Settings, * under admin}
                                    'access_type' => ['FULL_CRUD', 'NO_DEL_SELF', 'NO_DEL_ADMIN', 'NONE_OTHERS'], // FULL access to all the modules but with some restrictions
                                    'access_grants' => ['ANY_OTHER_MOD']  //ONLY SPECIAL CASE
                                ]
                            ],

                        ]
                    ],
                ]
            ],
            'Human Resources' => [ //HR Group
                'roles' => [
                    'HR Manager' => [
                        'permissions' => [
                            'mod_access' => [
                                'EmployeeController' => [
                                    'access_type' => ['FULL_CRUD', 'NO_DEL_SELF', 'CAN_SEE_SALERIES', 'CAN_PROMOTE', 'CAN_TERMINATE'],
                                ],
                                'ProfileController' => [
                                    'access_type' => ['FULL_CRUD', 'NO_DEL_SELF', 'CAN_OTHER']
                                ],
                                'ProfileSettingsController' => [
                                    'access_type' => ['FULL_CRUD', 'NO_DEL_SELF', 'CAN_OTHER']
                                ],
                                'ToDoController' => [
                                    'access_type' => ['FULL_CRUD', 'CAN_SELF_ASSIGN', 'CAN_ASSIGN']
                                ],
                                'ProjectsController' => [
                                    'access_type' => ['FULL_CRUD', 'CAN_SELF_ASSIGN', 'CAN_ASSIGN']
                                ],
                                'RemindersController' => [
                                    'access_type' => ['FULL_CRUD', 'CAN_SELF_ASSIGN', 'CAN_ASSIGN']
                                ],
                                'TicketsController' => [
                                    'access_type' => ['FULL_CRUD', 'CAN_SELF_ASSIGN', 'CAN_ASSIGN', 'CAN_REASSIGN']
                                ],
                                'Others' => [
                                    'access_type' => ['ADHOC'] //Only Admin or Super user can give access to additional modules and rights CASE BY CASE
                                ]
                            ],

                        ]
                    ],
                    'HR Employee' => [
                        'permissions' => [
                            'mod_access' => [
                                'EmployeeController' => [
                                    'access_type' => ['READ', 'WRITE', 'UPDATE', 'NO_DEL_SELF']
                                ],
                                'ProfileController' => [
                                    'access_type' => ['READ', 'WRITE', 'UPDATE', 'NO_DEL_SELF']
                                ],
                                'ProfileSettingsController' => [
                                    'access_type' => ['READ', 'WRITE', 'UPDATE', 'NO_DEL_SELF']
                                ],
                                'ToDoController' => [
                                    'access_type' => ['READ', 'WRITE', 'UPDATE', 'CAN_SELF_ASSIGN', 'CAN_ASSIGN']
                                ],
                                'ProjectsController' => [
                                    'access_type' => ['READ', 'WRITE', 'UPDATE', 'CAN_SELF_ASSIGN', 'CAN_ASSIGN']
                                ],
                                'RemindersController' => [
                                    'access_type' => ['READ', 'WRITE', 'UPDATE', 'CAN_SELF_ASSIGN', 'CAN_ASSIGN']
                                ],
                                'TicketsController' => [
                                    'access_type' => ['READ', 'WRITE', 'UPDATE', 'CLOSE', 'CAN_SELF_ASSIGN', 'CAN_ASSIGN', 'CAN_REASSIGN']
                                ],
                                'Others' => [
                                    'access_type' => ['ADHOC'] //Only Admin or Super user can give access to additional modules and rights CASE BY CASE
                                ]
                            ],

                        ]
                    ],

                ]

            ],

            'General Users' => [
                'roles' => [
                    'Users' => [
                        'permissions' => [
                            'mod_access' => [
                                'EmployeeController' => [
                                    'access_type' => ['NONE']
                                ],
                                'ProfileController' => [
                                    'access_type' => ['READ', 'UPDATE', 'NO_DEL_SELF']
                                ],
                                'ProfileSettingsController' => [
                                    'access_type' => ['READ', 'UPDATE', 'NO_DEL_SELF']
                                ],
                                'ToDoController' => [
                                    'access_type' => ['READ', 'UPDATE', 'CAN_SELF_ASSIGN', 'CAN_ASSIGN']
                                ],
                                'ProjectsController' => [
                                    'access_type' => ['READ', 'UPDATE']
                                ],
                                'RemindersController' => [
                                    'access_type' => ['READ', 'UPDATE', 'CAN_SELF_ASSIGN', 'CAN_ASSIGN']
                                ],
                                'TicketsController' => [
                                    'access_type' => ['READ', 'WRITE', 'UPDATE', 'CLOSE', 'CAN_SELF_ASSIGN', 'CAN_ASSIGN', 'CAN_REASSIGN']
                                ],
                                'Others' => [
                                    'access_type' => ['ADHOC'] //Only Admin or Super user can give access to additional modules and rights CASE BY CASE
                                ]
                            ],

                        ]
                    ],
                ]

            ]

        ]
    ];
    protected $fillable = [
        'name',
        'deleted_at',
        'updated_at'
    ];



    public function GetGroupsRoles()
    {
        return $this->belongsToMany(Groups::class, Roles::class);
    }
}
