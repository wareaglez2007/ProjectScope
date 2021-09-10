<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;
use app\Models\Groups;
use app\Models\Modules;
use app\Models\Permissions;
use App\Models\Roles;

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


        if (isset($request->search_q) && $request->search_q != null) {

            $users = User::withTrashed(false)->where('name', 'LIKE', "%{$request->search_q}%")->orderby('name', 'ASC')->paginate(10);

            if ($request->ajax()) {
                return response()->json([
                    'modname' => 'Users Management',
                    'view' => view('admin.Modules.Site_Settings.UserManagement.index')->with([
                        'modname' => 'Users Management',
                        'user_view' => 'index',
                        'current_page' => $users->currentPage(),
                        'users' => $users
                    ])->render()
                ]);
            }
        } else {

            $users =  User::orderBy('name', 'ASC')->paginate(10);
            if ($request->ajax()) {
                return response()->json([
                    'modname' => 'Users Management',
                    'view' => view('admin.Modules.Site_Settings.UserManagement.index')->with([
                        'modname' => 'Users Management',
                        'user_view' => 'index',
                        'current_page' => $users->currentPage(),
                        'users' => $users
                    ])->render()
                ]);
            } else {
                return view('admin.Modules.Site_Settings.UserManagement.index')->with([
                    'modname' => 'Users Management',
                    'user_view' => 'index',
                    'current_page' => $users->currentPage(),
                    'users' => $users
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userRole = User::with('userRole')->findorfail($id); //Will return user role information

        $userGroups = User::with('userGroups')->findOrFail($id); // will return GroupsRoles info $userGroups->userGroups->groups_id

        $userModulesPermissions = User::findOrFail($id)->GetAllRolesModsPerms()->orderby('id', 'ASC')->paginate(10);


        $modules = Modules::orderby('name', 'ASC')->get();
        $permissions = Permissions::orderby('access_type', 'ASC')->get();
        $roles = Roles::orderby('name', 'ASC')->get();
        $groups = Groups::orderby('name', 'ASC')->get();

        return view('admin.Modules.Site_Settings.UserManagement.partials.show')->with([
            'modname' => 'Users Management - Individual view',
            'user_view' => 'show',
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
}
