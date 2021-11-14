<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Groups;
use App\Models\Modules;
use App\Models\Permissions;
use App\Models\Roles;
use App\Models\RolesUser;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Session\Session;
use \Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{

    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $routes = Route::getRoutes();
        $filters = Roles::withCount('users')->get();

        //dd($filters);
        return view('admin.Modules.Site_Settings.UserManagement.index')->with([
            'modname' => 'Users Management',
            'user_view' => 'index',
            'current_page' => 1,
            'cats' => $filters
        ]);
    }
    public function GetUsersData(Request $request)
    {
        //dd($request);
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
            $searchValue = '%' . $search_arr['value']. '%'; // Search value

           // dd($request->search);
            if ($request->exists('searchByRole') && $request->searchByRole != null && $search_arr['value'] == null ) {
                $operator = '=';
                $searchValue =  $request->searchByRole;
            } else {
                $operator = 'like';
                $searchValue = '%' . $search_arr['value']. '%';
            }
           // dd($operator);
            // Total records
            $totalRecords = User::select('count(*) as allcount')
                ->with('roles')
                ->count();
            $totalRecordswithFilter = User::select('count(*) as allcount')
                ->with('roles')
                ->whereHas('roles', function ($q) use ($operator, $searchValue) {
                    $q->where('name', $operator, $searchValue);
                })
                ->orwhere('name', $operator, $searchValue)
                ->orwhere('email',  $operator, $searchValue)
                ->orwhere('id',  $operator, $searchValue)
                ->count();

            // Fetch records
            if ($columnName == 'roles') {
                $columnName = 'role_name';
            }

            $records = DB::table('roles')->selectRaw('group_concat(roles.name,"=",roles.id) as role_name,  users.*')
                ->join('roles_users', 'roles.id', 'roles_users.roles_id')
                ->join('users', 'roles_users.users_id', 'users.id')
                ->where(function($q) use ($operator, $searchValue) {
                    $q->where('roles.name', $operator, $searchValue);

                })
                ->orwhere('users.name', $operator, $searchValue)
                ->orwhere('users.email', $operator, $searchValue)
                ->orwhere('users.id',  $operator, $searchValue)
                ->groupBy('users.id')
                ->orderBy($columnName, $columnSortOrder)
                ->skip($start)
                ->take($rowperpage)
                ->get();
            // dd($records);
            $data_arr = array();
            $token = $request->session()->token();
            foreach ($records as $record) {
                $id = $record->id;
                $name = $record->name;
                $email = $record->email;
                $created_at = date('m-d-Y @ H:i:s', strtotime($record->created_at));
                $role_a = $record->role_name;
                $data_arr[] = array(
                    "id" => $id,
                    "name" => $name,
                    "email" => $email,
                    "created_at" => $created_at,
                    "actions" => $id,
                    "token" => $token,
                    "roles" => $role_a
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
        $roles = Roles::whereNotIn('name', ['admin'])->get();
        return view('admin.Modules.Site_Settings.UserManagement.index')->with([
            'modname' => 'Users Management - Create new user',
            'user_view' => 'create',
            'current_page' => 1,
            'roles' => $roles

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
        $roles = Roles::whereNotIn('name', ['admin'])->get();
        if ($request->exists('name') && $request->exists('email') && $request->exists('pass') && $request->exists('roles')) {
            $selected_roles = json_decode(stripslashes($request->roles));

            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'pass' => ['required', 'string', 'min:8'],
            ]);
            $create =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'uuid' => Str::uuid(),
                'password' => Hash::make($request->pass),
            ]);
            if ($create) {
                foreach ($selected_roles as $role) {

                    $create_roles_users =  RolesUser::create([
                        'users_id' => $create->id,
                        'roles_id' => $role,
                    ]);
                }
                $response_messages['success'] = "New user has been added.";
            } else {

                $response_messages['error'] = "Unable to add new user.";
            }



            if ($request->ajax()) {
                return response()->json([
                    "response" => $response_messages,
                    'view' => view('admin.Modules.Site_Settings.UserManagement.partials.create')->with([
                        'modname' => 'Users Management - Create new user',
                        'user_view' => 'create',
                        'current_page' => 1,
                        'roles' => $roles
                    ])->render()
                ]);
            }
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

        $roles_t = new Roles();
        $rolesusers = User::find($id);
        $permissions_roles_mods = [];
        foreach ($rolesusers->roles as $k => $role) {
            $modulespermissionsroles = $roles_t->find($role->id)->modulepermissions()->get();
            foreach ($modulespermissionsroles as $modspers) {
                $permissions_roles_mods[] = $modspers;
            }
        }
        $modules = Modules::orderby('name', 'ASC')->get();
        $permissions = Permissions::orderby('access_type', 'ASC')->get();
        $roles = Roles::orderby('name', 'ASC')->get();
        $groups = Groups::orderby('name', 'ASC')->get();

        return view('admin.Modules.Site_Settings.UserManagement.index')->with([
            'modname' => 'Users Management - Individual view',
            'user_view' => 'show',
            'user' => $rolesusers,
            'modules' => $modules,
            'permissions' => $permissions,
            'roles' => $roles,
            '$groups' => $groups,
            'mprs' => $permissions_roles_mods


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
        $roles_t = new Roles();
        $rolesusers = User::find($id);
        $permissions_roles_mods = [];
        foreach ($rolesusers->roles as $k => $role) {
            $modulespermissionsroles = $roles_t->find($role->id)->modulepermissions()->get();
            foreach ($modulespermissionsroles as $modspers) {
                $permissions_roles_mods[] = $modspers;
            }
        }
        $modules = Modules::orderby('name', 'ASC')->get();
        $permissions = Permissions::orderby('access_type', 'ASC')->get();
        $roles = Roles::orderby('name', 'ASC')->get();
        $groups = Groups::orderby('name', 'ASC')->get();

        return view('admin.Modules.Site_Settings.UserManagement.index')->with([
            'modname' => 'Users Management - Edit: ' . $rolesusers->name,
            'user_view' => 'edit',
            'user' => $rolesusers,
            'modules' => $modules,
            'permissions' => $permissions,
            'roles' => $roles,
            'groups' => $groups,
            'mprs' => $permissions_roles_mods,

        ]);
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
        $isValid = false;
        $rolesusers = User::find($id);
        if ($rolesusers->name != $request->name) {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255']
            ]);
            if ($validatedData) {
                $isValid = true;
            }
        }
        if ($rolesusers->email != $request->email) {

            $validatedData = $request->validate([
                'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users']
            ]);
            if ($validatedData) {
                $isValid = true;
            }
        }
        if (isset($request->pass)) {
            //'password' => ['required', 'string', 'min:8', 'confirmed'],
            $validatedData = $request->validate([
                'pass' => ['required', 'string', 'min:8']
            ]);
            if ($validatedData) {
                $isValid = true;
            }
        }
        if (!isset($request->user_role_select2)) {
            $validatedData = $request->validate([
                'user_role_select2[]' => ['required']
            ]);
            if ($validatedData) {
                $isValid = true;
            }
        }

        $selected = [];
        $selected = $request->user_role_select2;
        sort($selected);
        $assigned_roles_id = [];
        $checker = [];
        foreach ($rolesusers->roles as $assigned) {
            array_push($assigned_roles_id, $assigned->id);
        }
        if (count($selected) > count($assigned_roles_id)) {
            $checker = array_diff($selected, $assigned_roles_id);
        } else {
            $checker = array_diff($assigned_roles_id, $selected);
        }
        if (is_countable($checker) && count($checker) > 0) {
            //we have a difference
            $isValid = true;
        }

        /******UPDATE OR ADD******/
        if ($isValid) {
            //Update and redirect
            $update = new User();
            if (isset($request->name)) {
                $update->where('id', $id)->update(['name' => $request->name]);
            }
            if (isset($request->email)) {
                $update->where('id', $id)->update(['email' => $request->email]);
            }
            if (isset($request->pass)) {
                $update->where('id', $id)->update(['password' => Hash::make($request->pass)]);
            }

            //Update Roles Users Table
            $update_role = new RolesUser();
            //Delete all records belonging to the user in RolesUser table
            $del = $update_role->where('users_id', $id)->forceDelete();
            foreach ($selected as $u_role) {
                //It did not find the record
                //Then add
                $update_role->create([
                    'users_id' => $id,
                    'roles_id' => $u_role
                ]);
            }
            return redirect(route('admin.users.edit', ['id' => $id]))->with('update_response', "User: " . $rolesusers->name . " has been updated.");
        } else {
            return redirect(route('admin.users.edit', ['id' => $id]))->with('response', 'There is nothing to update!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (isset($request->id)) {
            //check role
            $user = User::find($id);
            $rolechecker = new RolesUser();
            $is_admin = $rolechecker->where('users_id', $id)->get();
            foreach ($is_admin as $ad) {
                if ($ad->roles_id == 1 || $user->email == 'wareaglez2007@hotmail.com') {
                    $code = 401;
                    $response_messages['error'] = "Error: Cannot delete " . $user->name . ". Please try another user. ";
                } else {
                    $del = new User();
                    $do_del =   $del->where('id', $request->id)->forceDelete();
                    if ($do_del) {
                        $code = 202;
                        $response_messages['success'] = $user->name . " has been deleted from database!";
                    }
                }
            }

            return response()->json([
                "response" => $response_messages,
                "code" => $code
            ]);
        }
    }

    /**
     * @param User::class object $users
     * @param User::class int $count
     * @return string $start_end
     */

    public function ShowStartEndPagination($users, $count)
    {
        if ($users->hasMorePages() && $users->currentPage() == 1) {
            //There are more pages
            $users_count_start = 1;
            $users_count_end = $users->perPage();
        } elseif ($users->count() < $users->perPage()) {
            //the end
            $users_count_end = $users->total();
            $users_count_start = $users_count_end - $users->count() + 1;
        } else {
            $users_count_end = $users->count() * $users->currentPage();
            $users_count_start = ($users_count_end - $users->count()) + 1;
        }
        $start_end =  "<p>Showing <b> $users_count_start </b> to
                    <b>$users_count_end</b> of <b><u>$count</u></b> entries.
                </p>";
        return $start_end;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
