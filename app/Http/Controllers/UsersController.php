<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Groups;
use App\Models\Modules;
use App\Models\Permissions;
use App\Models\Roles;
use App\Models\RolesUser;
use \Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

        return view('admin.Modules.Site_Settings.UserManagement.index')->with([
            'modname' => 'Users Management',
            'user_view' => 'index',
            'current_page' => 1,
        ]);
    }
    public function GetUsersData(Request $request)
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
            $totalRecords = User::select('count(*) as allcount')
                ->count();
            $totalRecordswithFilter = User::select('count(*) as allcount')
                ->where('name', 'like', '%' . $searchValue . '%')
                ->orwhere('email', 'like', '%' . $searchValue . '%')
                ->count();

            // Fetch records
            $records = User::orderBy($columnName, $columnSortOrder)
                ->where('name', 'like', '%' . $searchValue . '%')
                ->orwhere('email', 'like', '%' . $searchValue . '%')
                ->skip($start)
                ->take($rowperpage)
                ->get();

            $data_arr = array();

            foreach ($records as $record) {
                $id = $record->id;
                $name = $record->name;
                $email = $record->email;
                $created_at = date('m-d-Y @ H:i:s', strtotime($record->created_at));

                $data_arr[] = array(
                    "id" => $id,
                    "name" => $name,
                    "email" => $email,
                    "created_at" => $created_at,
                    "actions" => $id,


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
            'modname' => 'Users Management - Individual view',
            'user_view' => 'edit',
            'user' => $rolesusers,
            'modules' => $modules,
            'permissions' => $permissions,
            'roles' => $roles,
            '$groups' => $groups,
            'mprs' => $permissions_roles_mods


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
