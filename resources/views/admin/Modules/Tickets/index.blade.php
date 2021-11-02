@section('head')
@endsection
@section('styles')
    <link href="{{ asset('css/tickets.css') }}" rel="stylesheet">
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
                        {{-- Ticket options --}}
                        <div class="card" style="margin-bottom: 15px;">
                            <div class="card-body">

                                <div class="btn-toolbar" role="toolbar" aria-label="">
                                    <div class="btn-group" role="group" aria-label="">
                                        <button type="button" class="btn btn-light">
                                            <i class="bi bi-node-plus-fill"></i>
                                            Create New Ticket</button>
                                        <button type="button" class="btn btn-light">
                                            <i class="bi bi-eye-fill"></i>
                                            View all Tickets</button>
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
                        @if (null !== $view)
                            @switch($view)
                                @case('index')
                                    @include('admin.Modules.Tickets.partials.default')
                                    {{-- DO NOT REMOVE THE javascript from here!!! --}}
                                    <script src="{{ asset('js/ticketsDatatables.js') }}" defer></script>
                                @break
                                @case('show')
                                    @include('admin.Modules.Tickets.partials.show')
                                @break
                                @case('edit')
                                    @include('admin.Modules.Tickets.partials.edit')
                                @break
                                @case('create')
                                    <div id="create_new_ticket_section">
                                        @include('admin.Modules.Tickets.partials.create')
                                    </div>
                                @break
                                @default
                                    @include('admin.Modules.Tickets.partials.default')
                                    {{-- DO NOT REMOVE THE javascript from here!!! --}}
                                    <script src="{{ asset('js/ticketsDatatables.js') }}" defer></script>
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
    <script src="{{ asset('js/tickets.js') }}" defer></script>


@endsection
