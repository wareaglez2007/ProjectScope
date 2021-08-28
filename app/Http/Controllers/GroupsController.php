<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    protected $group_id = null;

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
        $group_count = Groups::get()->count();
        $groups = Groups::orderBy('id', 'ASC')->paginate(8);
        return view('admin.Modules.Site_Settings.GroupsManagement.index')->with([
            'modname' => 'Gruop Management',
            'count' => $group_count,
            'groups' => $groups,
            'id' => $this->getGroup_id()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $group_count = Groups::get()->count();
        $groups = Groups::orderBy('id', 'ASC')->paginate(8);
        return view('admin.Modules.Site_Settings.GroupsManagement.index')->with([
            'modname' => 'Gruop Management - Create New Group',
            'count' => $group_count,
            'groups' => $groups,
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
        $this->setGroup_id($id);
        $group_count = Groups::get()->count();
        $group = Groups::findorfail($id);
        return view('admin.Modules.Site_Settings.GroupsManagement.index')->with([
            'modname' => 'Gruop Management - Individual Group View',
            'count' => $group_count,
            'group' => $group,
            'id' => $id
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
