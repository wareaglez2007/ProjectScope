<?php

namespace App\Http\Controllers;

use App\Models\Modules;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Http\Request;
use Nette\Utils\Arrays;

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
        if (isset($request->search_q) && $request->search_q != null) {

            $roles = $this->roles->withTrashed(false)->where('name', 'LIKE', "%{$request->search_q}%")->paginate(6);

            if ($request->ajax()) {
                return response()->json([
                    'modname' => 'Roles Management',
                    'view' => view('admin.Modules.Site_Settings.RolesManagement.partials.showroles')->with([
                        'modname' => 'Roles Management',
                        'roles' => $roles,
                        'role_view' => 'index',
                        'current_page' => $roles->currentPage()
                    ])->render()
                ]);
            }
        } else {

            $roles =  $this->getRoles()->orderBy('id', 'ASC')->paginate(6);
            if ($request->ajax()) {
                return response()->json([
                    'modname' => 'Roles Management',
                    'view' => view('admin.Modules.Site_Settings.RolesManagement.partials.showroles')->with([
                        'modname' => 'Roles Management',
                        'roles' => $roles,
                        'role_view' => 'index',
                        'current_page' => $roles->currentPage()
                    ])->render()
                ]);
            } else {
                return view('admin.Modules.Site_Settings.RolesManagement.index')->with([
                    'modname' => 'Roles Management',
                    'roles' => $roles,
                    'role_view' => 'index',
                    'current_page' => $roles->currentPage()
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return view('admin.Modules.Site_Settings.RolesManagement.index')->with([
            'modname' => 'Roles Management',
            'role' => $role,
            'role_view' => 'show',
            'modules' => $modules,
            'permissions' => $permissions,
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
