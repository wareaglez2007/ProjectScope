@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
@section('styles')
    <link href="{{ asset('css/groups.css') }}" rel="stylesheet">
@endsection
@extends('layouts.app')

@section('content')
    <div class="container" id="contnet-container">
        <div class="card">
            <div class="card-header">{{ $modname }}</div>

            <div class="card-body">
                {{-- -ROW 1 --}}
                <div class="row">
                    {{-- Manage Groups --}}
                    <div class="col-md-3">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="{{ route('admin.groups.create') }}">Create new group</a>
                            </li>
                            <li class="list-group-item"><a href="{{ route('admin.groups') }}">See Current Groups</a></li>
                        </ul>
                        <div id="roles_groups_select2_index">
                            @if (Request::segment(3) == 'show' && Request::segment(2) == 'groups' && Request::segment(1) == 'admin')
                                @include('admin.Modules.Site_Settings.GroupsManagement.partials.rolegroupselection')
                            @endif
                        </div>
                    </div>
                    <div class="col-md-9" id="ajax_page">
                        @if (request()->path() == 'admin/groups')
                            @include('admin.Modules.Site_Settings.GroupsManagement.partials.default')
                        @endif
                        <div class="show_roles" id="show_roles_div">
                            @if (Request::segment(3) == 'show' && Request::segment(2) == 'groups' && Request::segment(1) == 'admin')
                                @include('admin.Modules.Site_Settings.GroupsManagement.partials.show')
                            @endif
                        </div>
                        @if (request()->path() == 'admin/groups/create')
                            @include('admin.Modules.Site_Settings.GroupsManagement.partials.create')
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- DO NOT REMOVE THE javascript from here!!! --}}
    <script src="{{ asset('js/groups.js') }}" defer></script>

@endsection
