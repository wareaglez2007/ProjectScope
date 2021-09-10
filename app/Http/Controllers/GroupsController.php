<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use App\Models\GroupsRoles;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\ErrorHandler\ErrorHandler;

class GroupsController extends Controller
{
    protected $group_id = null;
    protected $groups; //===> App\Modles\Groups


    public function __construct()
    {
        $this->middleware('auth');
        $this->groups = new Groups;
    }



    public function getGroup_id()
    {
        return $this->group_id;
    }

    public function setGroup_id(Int $id)
    {
        $this->group_id = $id;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->status == 1) {
            $groups = $this->groups->GetAllGroups(null, true, 6, 'name', 'ASC');
            $gp = $this->groups->all();
            $active = 1;
        } else {
            $groups = $this->groups->GetAllGroups(null, true, 6, 'name', 'ASC', true);
            $gp = $this->groups->onlyTrashed()->with('Roles')->get();
            $active = 0;
        }

        return view('admin.Modules.Site_Settings.GroupsManagement.index')->with([
            'modname' => 'Gruop Management',
            'count' => $this->groups->GetGroupCount(),
            'groups' => $groups,
            'id' => $this->getGroup_id(),
            'roles_count' => $gp,
            'group_status' => $active
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Modules.Site_Settings.GroupsManagement.index')->with([
            'modname' => 'Gruop Management - Create New Group',
            'count' => $this->groups->GetGroupCount(),
            'groups' => $this->groups->GetAllGroups(null, true, 6, 'name', 'ASC'),
            'id' => $this->getGroup_id()
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
        //When the request comes
        $response_messages['success'] = "";
        //1. Check and make sure that the group does not exist already
        $validatedData = $request->validate([
            'name' => 'required|unique:groups,name',

        ]);
        //2. If everything ok, then store into database.
        $create = Groups::create(array('name' => $request->name));
        $response_messages['success'] = "Group " . $request->name . " has been added.";
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,

                'view' => view('admin.Modules.Site_Settings.GroupsManagement.partials.create')->with([
                    'modname' => 'Gruop Management - Create New Group',
                ])->render()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->setGroup_id($id);
        $group = Groups::withTrashed()->findorfail($id);
        $roles_assigned = $this->groups->withTrashed()->find($id)->Roles()->get();
        $roles_count = GroupsRoles::count();
        $roles = Roles::orderby('name', 'ASC')->paginate(8);
        $roles_2 = Roles::orderby('name', 'ASC')->get();
        return view('admin.Modules.Site_Settings.GroupsManagement.index')->with([
            'modname' => 'Gruop Management - Individual Group View',
            'count' => $this->groups->GetGroupCount(),
            'group' => $group,
            'id' => $id,
            'roles' => $roles,
            'roles2' => $roles_2,
            'roles_assigned' => $roles_assigned,
            'roles_count' => $roles_count
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
    public function update(Request $request, GroupsRoles $groupsRoles, Groups $groups)
    {

        $selected_roles = $request->role_id; //if nothing selected, NULL else it will return an array
        $group_id = $request->group_id;
        $role_names = Roles::findorfail($selected_roles);
        $group_names = Groups::withTrashed()->findorfail($group_id);

        $response_messages['success'] = "";

        $query = $groupsRoles->where('groups_id', $group_id)->where('roles_id', $selected_roles)->count();
        if ($query > 0) {
            $del_role = $groupsRoles->where('groups_id', $group_id)->where('roles_id', $selected_roles)->forceDelete();
            $update_date_groups = $groups->where('id', $group_id)->update(['updated_at' => now()]);
            $response_messages['error'] = "Role " . $role_names->name . " has been removed from " . $group_names->name;
        } else {
            $save_new_roles = new GroupsRoles();
            $save_new_roles->groups_id = $group_id;
            $save_new_roles->roles_id = $selected_roles;
            $save_new_roles->users_id = Auth::id();
            $save_new_roles->assigned = 1;
            $save_new_roles->save();
            $update_date_groups = $groups->where('id', $group_id)->update(['updated_at' => now()]);
            $response_messages['success'] = "Role " . $role_names->name . " has been added to " . $group_names->name;
        }
        $roles_2 = Roles::orderby('name', 'ASC')->get();
        $this->setGroup_id($group_id);
        $group = Groups::withTrashed()->findorfail($group_id);
        $roles_assigned = $this->groups->withTrashed()->find($group_id)->Roles()->get();
        $roles = Roles::orderby('name', 'ASC')->paginate(8);
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'modname' => 'Gruop Management - Individual Group View',
                'view' => view('admin.Modules.Site_Settings.GroupsManagement.partials.rolegroupselection')->with([
                    'count' => $this->groups->GetGroupCount(),
                    'group' => $group,
                    'id' => $group_id,
                    'roles' => $roles,
                    'roles2' => $roles_2,
                    'roles_assigned' => $roles_assigned,
                ])->render()
            ]);
        }
    }

    /**
     * trash the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->id != null) {
            if ($request->id != Groups::ADMIN_GROUP) {
                $this->groups->where('id', $request->id)->whereNotIn('id',  [Groups::ADMIN_GROUP])->delete();
                $response_messages['success'] = "Group has been deativated!";
            } else {
                $response_messages['error'] = "You cannot deativate this group";
            }
            $gp = $this->groups->all();
            if ($request->ajax()) {
                return response()->json([
                    "response" => $response_messages,
                    'modname' => 'Group Management',
                    'view' => view('admin.Modules.Site_Settings.GroupsManagement.partials.groupspagination')->with([
                        'modname' => 'Gruop Management',
                        'count' => $this->groups->GetGroupCount(),
                        'groups' => $this->groups->GetAllGroups(null, true, 6, 'name', 'ASC'),
                        'roles_count' => $gp,
                    ])->render()
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if ($request->id != null) {
            if ($request->id != Groups::ADMIN_GROUP) {
                $delete =  $this->groups->where('id', $request->id)->whereNotIn('id',  [Groups::ADMIN_GROUP])->forceDelete();
                if ($delete) {
                    $response_messages['success'] = "Group has been deleted!";
                } else {
                    $response_messages['error'] = "Unable to delete. Delete function in GroupsController.";
                }
            } else {
                $response_messages['error'] = "You cannot delete this group";
            }
            if ($request->status == 1) {
                $groups = $this->groups->GetAllGroups(null, true, 6, 'name', 'ASC');
                $gp = $this->groups->all();
            } else {
                $groups = $this->groups->GetAllGroups(null, true, 6, 'name', 'ASC', true);
                $gp = $this->groups->onlyTrashed()->with('Roles')->get();
            }
            if ($request->ajax()) {
                return response()->json([
                    "response" => $response_messages,
                    'modname' => 'Group Management',
                    'view' => view('admin.Modules.Site_Settings.GroupsManagement.partials.groupspagination')->with([
                        'modname' => 'Gruop Management',
                        'count' => $this->groups->GetGroupCount(),
                        'groups' => $groups,
                        'roles_count' => $gp
                    ])->render()
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
        if ($request->id != null) {
            if ($request->id != Groups::ADMIN_GROUP) {
                $activate =  $this->groups->withTrashed()->find($request->id)->restore();
                if ($activate) {
                    $response_messages['success'] = "Group has been activated!";
                } else {
                    $response_messages['error'] = "Unable to restore!";
                }


                if ($request->status == 1) {
                    $groups = $this->groups->GetAllGroups(null, true, 6, 'name', 'ASC');
                    $gp = $this->groups->all();
                } else {
                    $groups = $this->groups->GetAllGroups(null, true, 6, 'name', 'ASC', true);
                    $gp = $this->groups->onlyTrashed()->with('Roles')->get();
                }
            } else {
                $response_messages['error'] = "You cannot delete this group";
            }
            if ($request->ajax()) {
                return response()->json([
                    "response" => $response_messages,
                    'modname' => 'Group Management',
                    'view' => view('admin.Modules.Site_Settings.GroupsManagement.partials.groupspagination')->with([
                        'modname' => 'Gruop Management',
                        'count' => $this->groups->GetGroupCount(),
                        'groups' => $groups,
                        'roles_count' => $gp
                    ])->render()
                ]);
            }
        }
    }

    /**
     *
     */
    public function GroupsAjaxPaginationdata(Request $request)
    {
        // if(isset($request->group_status)){
        if ($request->status == 1) {
            $groups = $this->groups->GetAllGroups(null, true, 6, 'name', 'ASC');
            $gp = $this->groups->all();
        } else {
            $groups = $this->groups->GetAllGroups(null, true, 6, 'name', 'ASC', true);
            $gp = $this->groups->onlyTrashed()->with('Roles')->get();
        }


        // }
        if ($request->ajax()) {

            return view('admin.Modules.Site_Settings.GroupsManagement.partials.groupspagination')->with([
                'modname' => 'Gruop Management',
                'count' => $this->groups->GetGroupCount(),
                'groups' => $groups,
                'roles_count' => $gp,
            ])->render();
        }
    }


    public function GroupsRolesAjaxPaginationdata(Request $request, $id)
    {

        $this->setGroup_id($id);
        $group = Groups::withTrashed()->findorfail($id);
        $roles_assigned = $this->groups->withTrashed()->find($id)->Roles()->get();

        //dd($roles_assigned);

        $roles = Roles::orderby('name', 'ASC')->paginate(8);
        $roles_count = GroupsRoles::count();
        $roles_2 = Roles::orderby('name', 'ASC')->get();
        if ($request->ajax()) {

            return view('admin.Modules.Site_Settings.GroupsManagement.partials.rolesgroupspagination')->with([
                'modname' => 'Gruop Management - Individual Group View',
                'count' => $this->groups->GetGroupCount(),
                'group' => $group,
                'id' => $id,
                'roles' => $roles,
                'roles2' => $roles_2,
                'roles_assigned' => $roles_assigned,
                'roles_count' => $roles_count

            ])->render();
        }
    }


    /**
     * Search autocomplete
     */
    public function search(Request $request)
    {

        if (isset($request->search_q) && $request->search_q != null) {


            if ($request->status == 1) {
                $query = $request->search_q;
                $groups = Groups::withTrashed(false)->where('name', 'LIKE', "%{$query}%")->paginate(6);
                //dd($groups);
                $gp = $this->groups->all();
            } else {
                $query = $request->search_q;
                $groups = Groups::onlyTrashed()->where('name', 'LIKE', "%{$query}%")->paginate(6);
                $gp = $this->groups->onlyTrashed()->with('Roles')->get();
            }
            if ($request->ajax()) {
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



    public function updatewithSelect2(Request $request, GroupsRoles $groupsRoles, Groups $groups)
    {
        $selected_roles = $request->role_id; //if nothing selected, NULL else it will return an array
        $group_id = $request->group_id;
        $role_names = Roles::findorfail($selected_roles);
        $group_names = Groups::withTrashed()->findorfail($group_id);
        $response_messages['success'] = "";

        $query = $groupsRoles->where('groups_id', $group_id)->where('roles_id', $selected_roles)->count();
        if ($query > 0) {
            $del_role = $groupsRoles->where('groups_id', $group_id)->where('roles_id', $selected_roles)->forceDelete();
            $update_date_groups = $groups->where('id', $group_id)->update(['updated_at' => now()]);
            $response_messages['error'] = "Role " . $role_names->name . " has been removed from " . $group_names->name;
        } else {
            $save_new_roles = new GroupsRoles();
            $save_new_roles->groups_id = $group_id;
            $save_new_roles->roles_id = $selected_roles;
            $save_new_roles->users_id = Auth::id();
            $save_new_roles->assigned = 1;
            $save_new_roles->save();
            $update_date_groups = $groups->where('id', $group_id)->update(['updated_at' => now()]);
            $response_messages['success'] = "Role " . $role_names->name . " has been added to " . $group_names->name;
        }
        $roles_2 = Roles::orderby('name', 'ASC')->get();
        $this->setGroup_id($group_id);
        $group = Groups::withTrashed()->findorfail($group_id);
        $roles_assigned = $this->groups->withTrashed()->find($group_id)->Roles()->get();
        $roles = Roles::orderby('name', 'ASC')->paginate(8);
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'modname' => 'Gruop Management - Individual Group View',
                'view' => view('admin.Modules.Site_Settings.GroupsManagement.partials.rolesgroupspagination')->with([
                    'count' => $this->groups->GetGroupCount(),
                    'group' => $group,
                    'id' => $group_id,
                    'roles' => $roles,
                    'roles2' => $roles_2,
                    'roles_assigned' => $roles_assigned,
                ])->render()
            ]);
        }
    }




    public function updateGroupName(Request $request, GroupsRoles $groupsRoles, Groups $groups)
    {

        $group_id = $request->group_id;
        $group_names = Groups::findorfail($group_id);
        $response_messages['success'] = "";
        if (strtolower($group_names->name) != strtolower($request->name)) {
            $validatedData = $request->validate([
                'name' => 'required|unique:groups,name',

            ]);
        }
        $query = $groups->findorfail($group_id);
        if ($query) {

            $update_groups = $groups->where('id', $group_id)->update([
                'name' => $request->name,
                'updated_at' => now()
            ]);
            $response_messages['success'] = "Group name " . $group_names->name . " has been updated.";
        } else {

            $response_messages['error'] = "Error - GroupController group id: " . $group_id;
        }
        $roles_2 = Roles::orderby('name', 'ASC')->get();
        $this->setGroup_id($group_id);
        $group = Groups::withTrashed()->findorfail($group_id);
        $roles_assigned = $this->groups->withTrashed()->find($group_id)->Roles()->get();
        $roles = Roles::orderby('name', 'ASC')->paginate(8);
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'modname' => 'Gruop Management - Individual Group View',
                'view' => view('admin.Modules.Site_Settings.GroupsManagement.partials.rolesgroupspagination')->with([
                    'count' => $this->groups->GetGroupCount(),
                    'group' => $group,
                    'id' => $group_id,
                    'roles' => $roles,
                    'roles2' => $roles_2,
                    'roles_assigned' => $roles_assigned,
                ])->render()
            ]);
        }
    }
}
