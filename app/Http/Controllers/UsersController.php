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

        $users = User::all();

                return view('admin.Modules.Site_Settings.UserManagement.index')->with([
                    'modname' => 'Users Management',
                    'user_view' => 'index',
                    'current_page' => 1,
                    'users' => $users,

                ]);


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
}
