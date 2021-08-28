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
                    </div>
                    <div class="col-md-9">
                        @if (request()->path() == 'admin/groups')
                            @include('admin.Modules.Site_Settings.GroupsManagement.partials.default')
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
