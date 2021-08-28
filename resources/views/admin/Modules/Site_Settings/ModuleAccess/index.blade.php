@extends('layouts.app')

@section('content')
    <div class="container" id="contnet-container">
        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>

            <div class="card-body">
                {{-- -ROW 1 --}}
                <div class="row">
                    {{-- Manage Modules --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Module Access Management</h6>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><a href="">Create new relation</a></li>
                                <li class="list-group-item"><a href="">Edit existing module relation</a></li>
                                <li class="list-group-item"><a href="">Delete module permission</a></li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
