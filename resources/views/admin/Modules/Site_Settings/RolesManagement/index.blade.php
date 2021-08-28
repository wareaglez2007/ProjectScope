@extends('layouts.app')

@section('content')
    <div class="container" id="contnet-container">
        <div class="card">
            <div class="card-header">{{ $modname }}</div>

            <div class="card-body">
                {{-- -ROW 1 --}}
                <div class="row">
                    {{-- Manage Roles --}}
                    <div class="col-md-3">
                        <ul class="list-group ">
                            <li class="list-group-item"><a href="">Create new role</a></li>
                            <li class="list-group-item"><a href="">Edit roles</a></li>
                            <li class="list-group-item"><a href="">Delete roles</a></li>
                        </ul>
                    </div>

                    {{-- Main Section to display content for this module --}}
                    <div class="col-md-9">
                        @if (request()->path() == 'admin/roles')
                            @include('admin.Modules.Site_Settings.RolesManagement.partials.default')
                        @endif
                        @if (isset($id))
                            @include('admin.Modules.Site_Settings.GroupsManagement.partials.show')
                        @endif
                        @if (request()->path() == 'admin/groups/create')
                            @include('admin.Modules.Site_Settings.GroupsManagement.partials.create')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
