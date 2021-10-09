<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use App\Models\GroupsRoles;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permissions;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.Modules.Site_Settings.PermissionsManagement.index')->with([
            'modname' => 'Permissions Management',
            'view' => 'index',
            'current_page' => 1,
        ]);
    }
    /**
     * Table data
     */
    public function GetPermissionsData(Request $request)
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
            $totalRecords = Permissions::select('count(*) as allcount')
                ->count();
            $totalRecordswithFilter = Permissions::select('count(*) as allcount')
                ->where('access_type', 'like', '%' . $searchValue . '%')
                ->count();

            // Fetch records
            $records = Permissions::orderBy($columnName, $columnSortOrder)
                ->where('access_type', 'like', '%' . $searchValue . '%')
                ->skip($start)
                ->take($rowperpage)
                ->get();

            $data_arr = array();
            $token = $request->session()->token();
            foreach ($records as $record) {
                $id = $record->id;
                $access_type = $record->access_type;
                $access_rights = $record->access_rights;
                // dd($roles_count);
                $updated_at = date('m-d-Y @ H:i:s', strtotime($record->updated_at));

                $data_arr[] = array(
                    "id" => $id,
                    "access_type" => $access_type,
                    "access_rights" => $access_rights,
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
        //
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
