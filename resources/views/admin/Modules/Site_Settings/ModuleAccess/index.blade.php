@extends('layouts.app')

@section('content')
    <div class="container" id="contnet-container">
        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>

            <div class="card-body">
                {{-- -ROW 1 --}}
                {{-- -ROW 1 --}}
                <div class="row">
                    <div class="col-md-12">
                        {{-- Modules options --}}
                        <div class="card" style="margin-bottom: 15px;">
                            <div class="card-body">

                                <div class="btn-toolbar" role="toolbar" aria-label="">
                                    <div class="btn-group" role="group" aria-label="">
                                        <a href="{{ route('admin.groups') }}" class="btn btn-light">
                                            <i class="bi bi-layers-fill"></i>
                                            View all Modules</a>
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


            </div>
        </div>
    </div>
@endsection
