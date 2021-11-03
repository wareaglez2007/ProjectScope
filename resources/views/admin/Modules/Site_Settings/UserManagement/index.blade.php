@section('head')
@endsection
@section('styles')
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
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
                        {{-- user options --}}
                        <div class="card" style="margin-bottom: 15px;">
                            <div class="card-body">

                                <div class="btn-toolbar" role="toolbar" aria-label="">
                                    <div class="btn-group" role="group" aria-label="">
                                        <a href="{{ route('admin.users.create') }}" class="btn btn-light">
                                            <i class="bi bi-person-plus-fill"></i>
                                            Create New User</a>
                                        <a href="{{ route('admin.users') }}" class="btn btn-light">
                                            <i class="bi bi-person-lines-fill"></i>
                                            View all Users</a>
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
                        @if (null !== $user_view)
                            @switch($user_view)
                                @case('index')
                                    @include('admin.Modules.Site_Settings.UserManagement.partials.default')
                                    {{-- DO NOT REMOVE THE javascript from here!!! --}}
                                    <script src="{{ asset('js/userDatatables.js') }}" defer></script>
                                @break
                                @case('show')
                                    @include('admin.Modules.Site_Settings.UserManagement.partials.show')
                                @break
                                @case('edit')
                                    @include('admin.Modules.Site_Settings.UserManagement.partials.edit')
                                @break
                                @case('create')
                                    <div id="create_new_user_section">
                                        @include('admin.Modules.Site_Settings.UserManagement.partials.create')
                                    </div>
                                @break
                                @default
                                    @include('admin.Modules.Site_Settings.UserManagement.partials.default')
                                    {{-- DO NOT REMOVE THE javascript from here!!! --}}
                                    <script src="{{ asset('js/userDatatables.js') }}" defer></script>
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
    <script src="{{ asset('js/users.js') }}" defer></script>


@endsection
