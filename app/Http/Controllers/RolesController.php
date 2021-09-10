<?php

namespace App\Http\Controllers;

use App\Models\Modules;
use App\Models\Permissions;
use App\Models\Roles;
use App\Models\ModulesPermissionsRoles;
use App\Models\ModulesRoles;
use Illuminate\Http\Request;
use Nette\Utils\Arrays;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Route;

class RolesController extends Controller
{

    private $roles;
    private $roles_count;
    private $role_id;

    public function __construct()
    {
        $this->setRoles(new Roles());
        $this->setRolesCount($this->getRoles()->withTrashed()->count());
    }

    /**
     * Get the value of roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     *
     * @return  self
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get the value of roles_count
     */
    public function getRolesCount()
    {
        return $this->roles_count;
    }

    /**
     * Set the value of roles_count
     *
     * @return  self
     */
    public function setRolesCount($roles_count)
    {
        $this->roles_count = $roles_count;

        return $this;
    }
    /**
     * Get the value of role_id
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * Set the value of role_id
     *
     * @return  self
     */
    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;

        return $this;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $routes = Route::getRoutes();
        $group_info = $this->roles->with('GetGroups')->get();


        if (isset($request->search_q) && $request->search_q != null) {

            $roles = $this->roles->withTrashed(false)->where('name', 'LIKE', "%{$request->search_q}%")->orderby('name', 'ASC')->paginate(6);

            if ($request->ajax()) {
                return response()->json([
                    'modname' => 'Roles Management',
                    'view' => view('admin.Modules.Site_Settings.RolesManagement.partials.showroles')->with([
                        'modname' => 'Roles Management',
                        'roles' => $roles,
                        'role_view' => 'index',
                        'current_page' => $roles->currentPage(),
                        'group_info' => $group_info
                    ])->render()
                ]);
            }
        } else {

            $roles =  $this->getRoles()->orderBy('name', 'ASC')->paginate(6);
            if ($request->ajax()) {
                return response()->json([
                    'modname' => 'Roles Management',
                    'view' => view('admin.Modules.Site_Settings.RolesManagement.partials.showroles')->with([
                        'modname' => 'Roles Management',
                        'roles' => $roles,
                        'role_view' => 'index',
                        'current_page' => $roles->currentPage(),
                        'group_info' => $group_info
                    ])->render()
                ]);
            } else {
                return view('admin.Modules.Site_Settings.RolesManagement.index')->with([
                    'modname' => 'Roles Management',
                    'roles' => $roles,
                    'role_view' => 'index',
                    'current_page' => $roles->currentPage(),
                    'group_info' => $group_info
                ]);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Modules.Site_Settings.RolesManagement.index')->with([
            'modname' => 'Roles Management',
            'role_view' => 'create'

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->exists('flag')) {
            switch ($request->flag) {
                case 'add_roles_modules_access':
                    //Add a role and its selected module to roles_modules table
                    $role_id = $request->role_id;
                    $module_id = $request->module_id;

                    $select_from_roles_modules_count = ModulesRoles::where('roles_id', $role_id)->where('modules_id', $module_id)->count();
                    $modules = Modules::findorfail($module_id);
                    $roles = Roles::findorfail($role_id);
                    if ($select_from_roles_modules_count > 0) {
                        $del_roles_modules = ModulesRoles::where('roles_id', $role_id)->where('modules_id', $module_id)->forceDelete();
                        $del_permissions_modules_roles_row = ModulesPermissionsRoles::where('roles_id', $role_id)->where('modules_id', $module_id)->forceDelete();
                        //dd($del_permissions_modules_roles_row);
                        if ($del_roles_modules) {
                            $update_date_roles = Roles::where('id', $role_id)->update(['updated_at' => now()]);
                            $response_messages['error'] = "Module " . $modules->name . " access has been removed from role " . $roles->name;
                            $flag = 'remove_permissions_div';
                        }
                    } else {
                        $save_new_roles_modules = new ModulesRoles();
                        $save_new_roles_modules->roles_id = $role_id;
                        $save_new_roles_modules->modules_id = $module_id;
                        //$save_new_roles_modules->permissions_id = NULL;
                        $save_new_roles_modules->users_id = Auth::id();
                        $save_new_roles_modules->save();
                        $update_date_roles = Roles::where('id', $role_id)->update(['updated_at' => now()]);
                        if ($update_date_roles) {
                            $response_messages['success'] = "Module " . $modules->name . " access has been added to role " . $roles->name;
                            $flag = 'add_permissions_div';
                        }
                    }

                    $modules = Modules::orderby('name', 'ASC')->get();
                    $permissions = Permissions::orderby('access_type', 'ASC')->get();
                    $this->setRoleId($role_id);
                    $role =  $this->roles->findorfail($role_id);
                    $get_modules_with_roles = $this->roles->find($role_id)->GetRolesModules()->get();
                    $get_permissions_with_roles = ModulesPermissionsRoles::where('roles_id', $role_id)->get();
                    $get_mod_count = ModulesRoles::where('roles_id', $role_id)->get()->count();
                    $group_info = $this->roles->findorfail($role_id)->GetGroups()->get();
                    if ($request->ajax()) {
                        return response()->json([
                            "response" => $response_messages,
                            'modname' => 'Gruop Management - Individual Group View',
                            'add_remove_flag' => $flag,
                            'view' => view('admin.Modules.Site_Settings.RolesManagement.partials.permissions')->with([
                                'modname' => 'Roles Management',
                                'role' => $role,
                                'role_view' => 'show_roles_modules',
                                'modules' => $modules,
                                'permissions' => $permissions,
                                'modules_roles' => $get_modules_with_roles,
                                'roles_permissions' => $get_permissions_with_roles,
                                'get_mods_count' => $get_mod_count,
                                'group_info' => $group_info
                            ])->render()
                        ]);
                    }
                    break;
                case 'add_permissions':
                    $role_id = $request->role_id;
                    $module_id = $request->module_id;
                    $permission_id = $request->permission_id;
                    $select_from_roles_modules_permissions_count = ModulesPermissionsRoles::where('roles_id', $role_id)
                        ->where('modules_id', $module_id)
                        ->where('permissions_id', $permission_id)->count();

                    $modules = Modules::findorfail($module_id);
                    $roles = Roles::findorfail($role_id);
                    $permissions = Permissions::findorfail($permission_id);


                    if ($select_from_roles_modules_permissions_count > 0) {
                        $update_roles_modules_permissions = ModulesPermissionsRoles::where('roles_id', $role_id)
                            ->where('modules_id', $module_id)
                            ->where('permissions_id', $permission_id)
                            ->forceDelete();
                        if ($update_roles_modules_permissions) {
                            $update_date_roles = Roles::where('id', $role_id)->update(['updated_at' => now()]);
                            $response_messages['error'] = "Permission " . $permissions->access_type . " access has been removed from role" . $roles->name . " and module " . $modules->name;
                            $flag = 'remove_permissions_div';
                        }
                    } else {
                        $save_roles_modules_permissions = new ModulesPermissionsRoles();
                        $save_roles_modules_permissions->roles_id = $role_id;
                        $save_roles_modules_permissions->modules_id = $module_id;
                        $save_roles_modules_permissions->permissions_id = $permission_id;
                        $save_roles_modules_permissions->users_id = Auth::id();
                        $save_roles_modules_permissions->save();
                        $update_date_roles = Roles::where('id', $role_id)->update(['updated_at' => now()]);
                        if ($save_roles_modules_permissions) {
                            $response_messages['success'] = "Permission " . $permissions->access_type . " access has been assined to role" . $roles->name . " and module " . $modules->name;
                            $flag = 'add_permissions_div';
                        }
                    }

                    $modules = Modules::orderby('name', 'ASC')->get();
                    $permissions = Permissions::orderby('access_type', 'ASC')->get();
                    $this->setRoleId($role_id);
                    $role =  $this->roles->findorfail($role_id);
                    // $get_all = $this->roles->find($role_id)->GetRolesModules()->GetRolesPermissions()->get();
                    $get_modules_with_roles = $this->roles->find($role_id)->GetRolesModules()->get();
                    $get_permissions_with_roles = ModulesPermissionsRoles::where('roles_id', $role_id)->get();
                    $get_mod_count = ModulesRoles::where('roles_id', $role_id)->get()->count();
                    $group_info = $this->roles->findorfail($role_id)->GetGroups()->get();
                    if ($request->ajax()) {
                        return response()->json([
                            "response" => $response_messages,
                            'modname' => 'Gruop Management - Individual Group View',
                            'add_remove_flag' => $flag,
                            'view' => view('admin.Modules.Site_Settings.RolesManagement.partials.permissions')->with([
                                'modname' => 'Roles Management',
                                'role' => $role,
                                'role_view' => 'show_roles_modules',
                                'modules' => $modules,
                                'permissions' => $permissions,
                                'modules_roles' => $get_modules_with_roles,
                                'roles_permissions' => $get_permissions_with_roles,
                                'get_mods_count' => $get_mod_count,
                                'group_info' => $group_info
                            ])->render()
                        ]);
                    }

                    break;
                default:
                    # code...
                    break;
            }
        }
    }

    /**
     * Display the specified resource.
     * Show Roles & Permissions
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modules = Modules::orderby('name', 'ASC')->get();
        $permissions = Permissions::orderby('access_type', 'ASC')->get();
        $this->setRoleId($id);
        $role =  $this->roles->findorfail($id);
        $get_modules_with_roles = $this->roles->find($id)->GetRolesModules()->get();
        $get_permissions_with_roles = ModulesPermissionsRoles::where('roles_id', $id)->get();
        $get_mod_count = ModulesRoles::where('roles_id', $id)->get()->count();
        $group_info = $this->roles->findorfail($id)->GetGroups()->get();
        // dd($group_info);
        //dd($get_mod_count);
        //   dd($get_permissions_with_roles);
        return view('admin.Modules.Site_Settings.RolesManagement.index')->with([
            'modname' => 'Roles Management',
            'role' => $role,
            'role_view' => 'show',
            'modules' => $modules,
            'permissions' => $permissions,
            'modules_roles' => $get_modules_with_roles,
            'roles_permissions' => $get_permissions_with_roles,
            'get_mods_count' => $get_mod_count,
            'group_info' => $group_info
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Search autocomplete
     */
    public function search(Request $request)
    {

        if (isset($request->search_q) && $request->search_q != null) {


            if ($request->status == 1) {
                $query = $request->search_q;
                $roles = $this->getRoles()->withTrashed(false)->where('name', 'LIKE', "%{$query}%")->paginate(6);
                //dd($groups);
                $all_roles = $this->getRoles()->all();
            } else {
                $query = $request->search_q;
                $groups = $this->getRoles()->onlyTrashed()->where('name', 'LIKE', "%{$query}%")->paginate(6);
                $all_roles = $this->getRoles()->onlyTrashed()->with('Roles')->get();
            }
            if ($request->ajax()) {
                return response()->json([
                    'modname' => 'Role Management',
                    'view' => view('admin.Modules.Site_Settings.GroupsManagement.partials.groupspagination')->with([
                        'modname' => 'Gruop Management',
                        'count' => $this->groups->GetGroupCount(),
                        'roles' => $groups,
                        'roles_count' => $all_roles,
                    ])->render()
                ]);
            }
        } else {
            if ($request->status == 1) {
                $groups = $this->groups->GetAllGroups(null, true, 6, 'name', 'ASC');
                $gp = $this->groups->all();
            } else {

                $groups = $this->groups->GetAllGroups(null, true, 6, 'name', 'ASC', true);
                $gp = $this->groups->onlyTrashed()->with('Roles')->get();
            }

            return response()->json([
                'modname' => 'Group Management',
                'view' => view('admin.Modules.Site_Settings.GroupsManagement.partials.groupspagination')->with([
                    'modname' => 'Gruop Management',
                    'count' => $this->groups->GetGroupCount(),
                    'groups' => $groups,
                    'roles_count' => $gp,
                ])->render()
            ]);
        }
    }
}
