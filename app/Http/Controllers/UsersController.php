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

            $sortBy = "id";
            $sortDir = "asc";
            $direction = 'desc';
            $current_direction = 'asc';
            $icon_direction = "down";
            if (isset($request->sortBy) && isset($request->sortDir)) {
                if ($request->sortBy != 'id') {
                    $sortBy = "id";
                    $sortDir = "asc";
                    $direction = 'asc';
                    $current_direction = 'asc';
                    $icon_direction = "down";
                }

                switch ($request->sortDir) {
                    case 'desc':
                        $direction = 'asc';
                        $current_direction = 'desc';
                        $icon_direction = "up-alt";
                        break;

                    default:
                        $direction = 'desc';
                        $icon_direction = "down";

                        break;
                }
                $sortBy = $request->sortBy;
                $sortDir = $request->sortDir;
            }
            $icon_directions = (object)[
                'id_icon' => 'down',
                'name_icon' => 'down',
                'email_icon' => 'down',
                'role_icon' => 'down',
                'cd_icon' => 'down'
            ];

            if ($request->sortBy == "id") {
                if ($direction == 'asc') {
                    $icon_directions->id_icon = "up-alt";
                } else {
                    $icon_directions->id_icon = "down";
                }
            }
            if ($request->sortBy == "name") {
                if ($direction == 'asc') {
                    $icon_directions->name_icon = "up-alt";
                } else {
                    $icon_directions->name_icon = "down";
                }
            }

            if ($request->sortBy == "email") {
                if ($direction == 'asc') {
                    $icon_directions->email_icon = "up-alt";
                } else {
                    $icon_directions->email_icon = "down";
                }
            }
            if ($request->sortBy == "roles_id") {
                if ($direction == 'asc') {
                    $icon_directions->role_icon = "up-alt";
                } else {
                    $icon_directions->role_icon = "down";
                }
            }
            if ($request->sortBy == "created_at") {
                if ($direction == 'asc') {
                    $icon_directions->cd_icon = "up-alt";
                } else {
                    $icon_directions->cd_icon = "down";
                }
            }


            /** Number to show per page */

            $users = User::where('name', 'LIKE', "%{$request->search_q}%")
                ->orwhere('email', 'LIKE', "%{$request->search_q}%")
                ->orwhere('roles_id', 'LIKE', "%{$request->search_q}%")
                ->orderby($sortBy, $sortDir)->paginate(10);
            $count = User::where('name', 'LIKE', "%{$request->search_q}%")
                ->orwhere('email', 'LIKE', "%{$request->search_q}%")
                ->orwhere('roles_id', 'LIKE', "%{$request->search_q}%")
                ->count();
            $start_end = $this->ShowStartEndPagination($users, $count);

            if ($request->ajax()) {
                return response()->json([
                    'modname' => 'Users Management',
                    'view' => view('admin.Modules.Site_Settings.UserManagement.partials.showusers')->with([
                        'modname' => 'Users Management',
                        'user_view' => 'index',
                        'current_page' => $users->currentPage(),
                        'users' => $users,
                        'search_q' => $request->search_q,
                        'search_count' => $count,
                        'start_end' => $start_end,
                        'direction' => $direction,
                        'icon_directions' => $icon_directions,
                        'sortby' => $sortBy,
                        'current_direction' => $current_direction
                    ])->render()
                ]);
            }
        } else {
            $sortBy = "id";
            $sortDir = "asc";
            $direction = 'desc';
            $current_direction = 'asc';
            $icon_direction = "down";

            // if ($request->sortBy != 'id') {
            //     $sortBy = "id";
            //     $sortDir = "asc";
            //     $direction = 'asc';
            //     $current_direction = 'asc';
            //     $icon_direction = "down";
            // }
            if (isset($request->sortBy) && isset($request->sortDir)) {



                switch ($request->sortDir) {
                    case 'desc':
                        $direction = 'asc';
                        $current_direction = 'desc';
                        $icon_direction = "up-alt";
                        break;

                    default:
                        $direction = 'desc';
                        $icon_direction = "down";

                        break;
                }
                $sortBy = $request->sortBy;
                $sortDir = $request->sortDir;
            }
            $icon_directions = (object)[
                'id_icon' => 'down',
                'name_icon' => 'down',
                'email_icon' => 'down',
                'role_icon' => 'down',
                'cd_icon' => 'down'
            ];

            if ($request->sortBy == "id") {
                if ($direction == 'asc') {
                    $icon_directions->id_icon = "up-alt";
                } else {
                    $icon_directions->id_icon = "down";
                }
            }
            if ($request->sortBy == "name") {
                if ($direction == 'asc') {
                    $icon_directions->name_icon = "up-alt";
                } else {
                    $icon_directions->name_icon = "down";
                }
            }

            if ($request->sortBy == "email") {
                if ($direction == 'asc') {
                    $icon_directions->email_icon = "up-alt";
                } else {
                    $icon_directions->email_icon = "down";
                }
            }
            if ($request->sortBy == "roles_id") {
                if ($direction == 'asc') {
                    $icon_directions->role_icon = "up-alt";
                } else {
                    $icon_directions->role_icon = "down";
                }
            }
            if ($request->sortBy == "created_at") {
                if ($direction == 'asc') {
                    $icon_directions->cd_icon = "up-alt";
                } else {
                    $icon_directions->cd_icon = "down";
                }
            }


            $request->search_q = "";
            $users =  User::orderBy($sortBy, $sortDir)->paginate(10);
            $count = User::count();
            $start_end = $this->ShowStartEndPagination($users, $count);
            if ($request->ajax()) {
                return response()->json([
                    'modname' => 'Users Management',
                    'view' => view('admin.Modules.Site_Settings.UserManagement.partials.showusers')->with([
                        'modname' => 'Users Management',
                        'user_view' => 'index',
                        'current_page' => $users->currentPage(),
                        'users' => $users,
                        'search_q' => $request->search_q,
                        'search_count' => $count,
                        'start_end' => $start_end,
                        'direction' => $direction,
                        'icon_directions' => $icon_directions,
                        'sortby' => $sortBy,
                        'current_direction' => $current_direction

                    ])->render()
                ]);
            } else {
                return view('admin.Modules.Site_Settings.UserManagement.index')->with([
                    'modname' => 'Users Management',
                    'user_view' => 'index',
                    'current_page' => $users->currentPage(),
                    'users' => $users,
                    'search_q' => $request->search_q,
                    'search_count' => $count,
                    'start_end' => $start_end,
                    'direction' => $direction,
                    'icon_direction' => $icon_direction,
                    'sortby' => $sortBy,
                    'current_direction' => $current_direction,
                    'icon_directions' => (object)$icon_directions
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
