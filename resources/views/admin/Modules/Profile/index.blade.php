@extends('layouts.app')

@section('content')
    <div class="container" id="contnet-container">
        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>

            <div class="card-body">
                {{ Auth::user()->name }}


                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.profile.create') }}"><i
                                class="bi bi-person-plus-fill"></i>&nbsp;Create New User</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
