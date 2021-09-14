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
                    {{-- Manage Roles --}}
                    <table class="table">

                        <tbody>
                            <tr>
                                <td scope="row"><a href="{{ route('admin.users.create') }}"
                                        class="btn btn-success btn-sm">Create New User</a></td>
                                <td><a href="{{ route('admin.users') }}" class="btn btn-info btn-sm">See All Users</a></td>
                            </tr>
                        </tbody>
                    </table>
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
