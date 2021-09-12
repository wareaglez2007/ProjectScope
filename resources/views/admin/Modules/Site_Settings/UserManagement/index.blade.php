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
                    <table class="table table-bordered">

                        <tbody>
                            <tr>
                                <td scope="row"><a href="" class="btn btn-success btn-sm">Create New Role</a></td>
                                <td><a href="" class="btn btn-warning btn-sm">See Permissions</a></td>
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
                                    @include('admin.Modules.Site_Settings.UserManagement.partials.show')
                                @break
                                @case('show_user')
                                    @include('admin.Modules.Site_Settings.UserManagement.partials.edit')
                                @break
                                @case('create')
                                    @include('admin.Modules.Site_Settings.UserManagement.partials.create')
                                @break
                                @default
                                    @include('admin.Modules.Site_Settings.UserManagement.partials.show')
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
