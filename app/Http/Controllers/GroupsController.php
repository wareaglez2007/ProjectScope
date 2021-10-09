<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use App\Models\GroupsRoles;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\XmlConfiguration\Group;
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

        return view('admin.Modules.Site_Settings.GroupsManagement.index')->with([
            'modname' => 'Groups Management',
            'group_view' => 'index',
            'current_page' => 1,
        ]);
    }

    /**
     * Table data
     */
    public function GetGroupsData(Request $request)
    {
        if ($request->exists('draw')) {
            ## Read value
            $draw = $request->draw;
            $start = $request->start;
            $rowperpage = $request->length; // Rows display per page

            $columnIndex_arr = $request->order;
            $columnName_arr = $request->columns;
            $order_arr = $request->order;
            $search_arr = $request->search;

            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            $columnSortOrder = $order_arr[0]['dir']; // asc or desc
            $searchValue = $search_arr['value']; // Search value

            // Total records
            $totalRecords = Groups::select('count(*) as allcount')
                ->count();
            $totalRecordswithFilter = Groups::select('count(*) as allcount')
                ->where('name', 'like', '%' . $searchValue . '%')
                ->count();

            // Fetch records
            $records = Groups::orderBy($columnName, $columnSortOrder)
                ->where('name', 'like', '%' . $searchValue . '%')
                ->skip($start)
                ->take($rowperpage)
                ->get();

            $data_arr = array();
            $token = $request->session()->token();
            foreach ($records as $record) {
                $id = $record->id;
                $name = $record->name;
                $roles_count = $record->groles->count();
                // dd($roles_count);
                $updated_at = date('m-d-Y @ H:i:s', strtotime($record->updated_at));

                $data_arr[] = array(
                    "id" => $id,
                    "name" => $name,
                    "roles_count" => $roles_count,
                    "updated_at" => $updated_at,
                    "actions" => $id,
                    "token" => $token


                );
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr
            );

            return response()->json($response);
        }
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
            'group_view' => 'create',
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
         //Will need the group onfo
        //will need the roles assigned to group
        //will need the list of roles
        $group = Groups::find($id);
        $roles = Roles::orderby('name', 'ASC')->get();

        //dd($roles);
        return view('admin.Modules.Site_Settings.GroupsManagement.index')->with([
            'modname' => 'Show - Group(s) | ' . $group->name . ' on view mode.',
            'group_view' => 'show',
            'group' => $group,
            'roles' => $roles,
            //'selected' => 0
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
        //Will need the group onfo
        //will need the roles assigned to group
        //will need the list of roles
        $group = Groups::find($id);
        $roles = Roles::orderby('name', 'ASC')->get();

        //dd($roles);
        return view('admin.Modules.Site_Settings.GroupsManagement.index')->with([
            'modname' => 'Edit - Group(s) | ' . $group->name . ' on edit mode.',
            'group_view' => 'edit',
            'group' => $group,
            'roles' => $roles,
            'selected' => null
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupsRoles $groupsRoles, Groups $groups, $id)
    {
        $group = $groups->find($request->id);
        $response_messages = [];


        if ($group->name != $request->name) {
            //validate
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:groups']
            ]);
            if ($validatedData) {
                //Update Group Name
                $update_group = $groups->find($request->id)->update(
                    [
                        'name' => $request->name,
                        'updated_at' => now()
                    ]
                );
                $response_messages['success'] = [$group->name . " name has been updated!"];
            } else {
                $response_messages['success'] = [$validatedData];
            }
        }

        $assigned_roles_array = [];

        //roles id scenarios
        if (is_countable($request->roles_id) && count($request->roles_id) > 0) {
            //There are roles that have been selected by the user

            //1. check the database records and see if the group has any roles already assigned
            if (is_countable($group->groles) && count($group->groles) > 0) {
                //2. group has roles assigned
                //we need to compare group roles selected vs group roles assigned
                //Create the asigned roles array from object
                foreach ($group->groles as $assigned_roles) {

                    $assigned_roles_array[] = $assigned_roles->id;
                }

                //Now we have to do arrray diffs
                //1. compare assigned roles to selected roles 1st
                //In this case if there are any role ids that are not in selected will pop
                $assigned_vs_selected = array_diff($assigned_roles_array, $request->roles_id);
                //if the return array is empty then that means no changes
                //2. compare selected roles to assigned  roles
                $selected_vs_assigned = array_diff($request->roles_id, $assigned_roles_array);

                if (is_countable($assigned_vs_selected) && is_countable($selected_vs_assigned)) {

                    if (count($assigned_vs_selected) > 0) {
                        // dump(count($assigned_vs_selected));
                        //if the return array has anything that means the assigned values need to be removed
                        $response = array();
                        foreach ($assigned_vs_selected as $rid) {
                            $remove_old_roles = $groupsRoles->where('groups_id', $request->id)->where('roles_id', $rid)->forceDelete();

                            $response[] = $group->name . " roles have been updated. Role ID: " . $rid . " has been removed.";
                            // unset($response_messages);
                            $response_messages['error'] = $response;
                        }
                    }

                    if (count($selected_vs_assigned) > 0) {
                        //if there is a diff that means the user added more item
                        $response = array();
                        foreach ($selected_vs_assigned as $sid) {
                            $add_new = new GroupsRoles();
                            $update_group_roles = $add_new->create([
                                'groups_id' => $id,
                                'roles_id' => $sid,
                                'users_id' => auth()->id(),
                                'updated_at' => now(),

                            ]);
                            $response[] = $group->name . " roles have been updated. Role ID: " . $sid . " has been added.";
                            $response_messages['success'] = $response;
                        }
                    }

                    //IF THE ARRAY DIFF FOR BOTH INSTANCES IS ZERO, THEN WE HAVE NOTHING TO UPDATE
                    if (count($assigned_vs_selected) == 0 && count($selected_vs_assigned) == 0) {
                        $response_messages['warning'] = ["There are no roles to be updated for " . $group->name . '.'];
                    }
                }
            } else {
                //3. there are no records of the group having roles assigned
                $response = array();
                //Here we need to create new records
                foreach ($request->roles_id as $req_role_id) {

                    $add_new = new GroupsRoles();
                    $update_group_roles = $add_new->create([
                        'groups_id' => $id,
                        'roles_id' => $req_role_id,
                        'users_id' => auth()->id(),
                        'updated_at' => now(),

                    ]);
                    $response[] = $group->name . " roles have been updated. Role ID: " . $req_role_id . " has been added.";
                    $response_messages['success'] = $response;
                }
            }
        } else {
            $response = array();
            //No roles have been selected so we have to empty the table of this group
            $delete_group_roles = $groupsRoles->where('groups_id', $id)->forceDelete();
            $response[] = $group->name . "'s roles have been removed from our records.";
            $response_messages['error'] = $response;
        }



        /*******************/
        //End of scenario for roles
        /******************/

        $groups = Groups::find($id);
        $roles = Roles::orderby('name', 'ASC')->get();
        if ($request->ajax()) {
            return response()->json([
                "response" => $response_messages,
                'modname' => 'Gruop Management - Individual Group View',
                'view' => view('admin.Modules.Site_Settings.GroupsManagement.partials.edit')->with([
                    'modname' => 'Edit - ' . $groups->name . ' on edit mode.',
                    'group_view' => 'edit',
                    'group' => $groups,
                    'roles' => $roles,
                    'selected' => ''
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
    public function destroy(Request $request, $id)
    {
        if (isset($request->id)) {
            //check group
            $group = Groups::find($id);
            if(strtolower(trim($group->name)) == "admin" || strtolower(trim($group->name)) == "users"){
                    $code = 403;
                    $response_messages['error'] = "Error: Cannot delete " . $group->name . ". Please try another group. ";
            }else{

                $del = new Groups();
                $do_del = $del->where('id', $request->id)->forceDelete();
                if ($do_del) {
                    $code = 202;
                    $response_messages['success'] = $group->name . " has been deleted from database!";
                }
            }
            return response()->json([
                "response" => $response_messages,
                "code" => $code
            ]);
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
