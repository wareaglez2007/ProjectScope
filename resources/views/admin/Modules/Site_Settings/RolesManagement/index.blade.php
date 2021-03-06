@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
@section('styles')
    <link href="{{ asset('css/roles.css') }}" rel="stylesheet">
@endsection
@extends('layouts.app')

@section('content')
    <div class="container" id="contnet-container">
        <div class="card">
            <div class="card-header">{{ $modname }}</div>

            <div class="card-body">
                 {{-- -ROW 1 --}}
                 <div class="row">
                    <div class="col-md-12">
                        {{-- Roles options --}}
                        <div class="card" style="margin-bottom: 15px;">
                            <div class="card-body">

                                <div class="btn-toolbar" role="toolbar" aria-label="">
                                    <div class="btn-group" role="group" aria-label="">
                                        <a href="{{ route('admin.roles.create') }}" class="btn btn-light">
                                            <i class="bi bi-plus-circle-dotted"></i>
                                            Create New Role</a>
                                        <a href="{{ route('admin.roles') }}" class="btn btn-light">
                                            <i class="bi bi-eye"></i>
                                            View all Roles</a>
                                        <button type="button" class="btn btn-light">
                                            <i class="bi bi-box-arrow-in-up-right"></i>
                                            Export Data</button>
                                        <button type="button" class="btn btn-light">
                                            <i class="bi bi-box-arrow-in-down-left"></i>
                                            Import Data</button>
                                        <button type="button" class="btn btn-light"><i class="bi bi-pie-chart-fill"></i>
                                            Stats</button>
                                        <button type="button" class="btn btn-light"><i class="bi bi-arrow-clockwise"></i>
                                            Refresh</button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                {{-- Main Section to display content for this module --}}
                <div class="row">
                    <div class="col-md-12">
                        @if (null !== $role_view)
                            @switch($role_view)
                                @case('index')
                                    <div>
                                        @include('admin.Modules.Site_Settings.RolesManagement.partials.default')
                                    </div>
                                @break
                                @case('show')
                                    @include('admin.Modules.Site_Settings.RolesManagement.partials.show')
                                @break
                                 @case('edit')
                                    @include('admin.Modules.Site_Settings.RolesManagement.partials.edit')
                                @break
                                @case('create')
                                    @include('admin.Modules.Site_Settings.RolesManagement.partials.create')
                                @break
                                @default
                                    @include('admin.Modules.Site_Settings.RolesManagement.partials.default')
                            @endswitch
                        @else
                            <p>There are no views available!</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- DO NOT REMOVE THE javascript from here!!! --}}
    <script src="{{ asset('js/roles.js') }}" defer></script>
@endsection
