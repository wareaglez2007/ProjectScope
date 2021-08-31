@extends('layouts.app')

@section('content')
    <div class="container" id="contnet-container">
        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>

            <div class="card-body">
                {{-- -ROW 1 --}}
                <div class="row">
                    {{-- Manage Permissions --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Permissions Management</h6>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><a href="">Create new permissions</a></li>
                                <li class="list-group-item"><a href="">Edit permissions</a></li>
                                <li class="list-group-item"><a href="">Delete permissions</a></li>
                            </ul>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection