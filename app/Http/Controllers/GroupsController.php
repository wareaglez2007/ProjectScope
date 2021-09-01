<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use App\Models\GroupsRoles;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
    public function index()
    {
        $gp = $this->groups->all();
        return view('admin.Modules.Site_Settings.GroupsManagement.index')->with([
            'modname' => 'Gruop Management',
            'count' => $this->groups->GetGroupCount(),
            'groups' => $this->groups->GetAllGroups(null, true, 8, 'id', 'ASC'),
            'id' => $this->getGroup_id(),
            'roles_count' => $gp
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
            'groups' => $this->groups->GetAllGroups(null, true, 8, 'id', 'ASC'),
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
        //1. Check and make sure that the group does not exist already
        //2. If everything ok, then store into database.
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
        $group = Groups::findorfail($id);
        $roles_assigned = $this->groups->find($id)->Roles()->get();
        $roles_count = GroupsRoles::count();


        $roles = Roles::orderby('id', 'ASC')->paginate(8);

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
        // $current_assigned_roles_to_group = $this->groups->find($group_id)->GroupRoles()->get(); //Array
        //$current_assigned_count = $this->groups->find($group_id)->GroupRoles()->get()->count(); //int
        $role_names = Roles::findorfail($selected_roles);
        $group_names = Groups::findorfail($group_id);
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
            $save_new_roles->save();
            $update_date_groups = $groups->where('id', $group_id)->update(['updated_at' => now()]);
            $response_messages['success'] = "Role " . $role_names->name . " has been added to " . $group_names->name;
        }
        $roles_2 = Roles::orderby('name', 'ASC')->get();
        $this->setGroup_id($group_id);
        $group = Groups::findorfail($group_id);
        $roles_assigned = $this->groups->find($group_id)->Roles()->get();
        $roles = Roles::orderby('id', 'ASC')->paginate(8);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    /*****************AJAX */




    public function GroupsAjaxPaginationdata(Request $request)
    {
        $gp = $this->groups->all();
        if ($request->ajax()) {

            return view('admin.Modules.Site_Settings.GroupsManagement.partials.groupspagination')->with([
                'modname' => 'Gruop Management',
                'count' => $this->groups->GetGroupCount(),
                'groups' => $this->groups->GetAllGroups(null, true, 8, 'id', 'ASC'),
                'roles_count' => $gp
            ])->render();
        }
    }


    public function GroupsRolesAjaxPaginationdata(Request $request, $id)
    {
        //dump($id);
        $this->setGroup_id($id);
        $group = Groups::findorfail($id);
        $roles_assigned = $this->groups->findorfail($id)->Roles()->get();

        //dd($roles_assigned);

        $roles = Roles::orderby('id', 'ASC')->paginate(8);
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
            $query = $request->search_q;
            $data = Groups::where('name', 'LIKE', "%{$query}%")->paginate(10);
            // if(is_countable($data) && count($data) > 0){
            //     $output = '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="display:block;">';
            //     foreach ($data as $row) {
            //         $output .= '<a class="dropdown-item" href="'.route('admin.groups.show', ['id' => $row->id]).'">' . $row->name . '</a>';
            //     }
            //     $output .= '</div>';
            // }else{
            //     $output = '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="display:block;">';
            //     $output .= '<a class="dropdown-item" href="#">0 Results found</a>';
            //     $output .= '</div>';
            // }

            // echo $output;
            $gp = $this->groups->all();
            if ($request->ajax()) {

                return view('admin.Modules.Site_Settings.GroupsManagement.partials.groupspagination')->with([
                    'modname' => 'Gruop Management',
                    'count' => $this->groups->GetGroupCount(),
                    'groups' => $data,
                    'roles_count' => $gp
                ])->render();
            }
        } else {
            $gp = $this->groups->all();
            return view('admin.Modules.Site_Settings.GroupsManagement.partials.groupspagination')->with([
                'modname' => 'Gruop Management',
                'count' => $this->groups->GetGroupCount(),
                'groups' => $this->groups->GetAllGroups(null, true, 8, 'id', 'ASC'),
                'roles_count' => $gp
            ])->render();
        }
    }



    public function updatewithSelect2(Request $request, GroupsRoles $groupsRoles, Groups $groups)
    {
        $selected_roles = $request->role_id; //if nothing selected, NULL else it will return an array
        $group_id = $request->group_id;
        // $current_assigned_roles_to_group = $this->groups->find($group_id)->GroupRoles()->get(); //Array
        //$current_assigned_count = $this->groups->find($group_id)->GroupRoles()->get()->count(); //int
        $role_names = Roles::findorfail($selected_roles);
        $group_names = Groups::findorfail($group_id);
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
            $save_new_roles->save();
            $update_date_groups = $groups->where('id', $group_id)->update(['updated_at' => now()]);
            $response_messages['success'] = "Role " . $role_names->name . " has been added to " . $group_names->name;
        }
        $roles_2 = Roles::orderby('name', 'ASC')->get();
        $this->setGroup_id($group_id);
        $group = Groups::findorfail($group_id);
        $roles_assigned = $this->groups->findorfail($group_id)->Roles()->get();
        $roles = Roles::orderby('id', 'ASC')->paginate(8);
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
