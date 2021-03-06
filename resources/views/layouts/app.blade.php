<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>{{-- upgraded to 1.12 --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js" defer></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    @yield('head')
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body>
    <!-- Flexbox container for aligning the toasts -->
    <div aria-live="polite" aria-atomic="true" class="justify-content-center align-items-center position-sticky"
        style="position: relative; top:0; z-index:9999;" >
        <div style="position: absolute; top: 0; right: 0; z-index: 9999;" id="dashboard_toast"></div>
    </div>
    <div id="app">

        {{-- First Nav Bar d-none d-lg-block --}}
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark d-none d-lg-block" id="navbar-top-sticky">
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Resources</a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="#">Documentation</a>
                            <a class="dropdown-item" href="#">FAQ</a>
                            <a class="dropdown-item" href="#">Help</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        {{-- Second Navbar --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top" id="navbar-second-light">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <div class="nav-bar-mobile">
                @auth
                    <button class="navbar-toggler pull-right" type="button" data-toggle="collapse"
                        data-target="#sidebarMenu" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                @endauth

                <ul class="list-inline pull-right visible-xs d-none" style="line-height: 35px;">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li>
                                <a href="{{ route('login') }}" style="line-height: 50px;">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li>
                                <a href="{{ route('register') }}" style="line-height: 50px;">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
        {{-- Navigation Ends --}}
        <div class="container-fluid">
            <div class="row">
                @auth
                    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                        <div class="sidebar-sticky pt-3">
                            <ul class="nav flex-column">
                                <h6
                                    class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1">
                                    <span>Personal</span>
                                    <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                                        <i class="bi bi-person-circle"></i>
                                    </a>
                                </h6>
                                <li class="nav-item">
                                    @if (Auth::user()->id == 1)
                                        @php
                                            $url = 'admin.profile';

                                        @endphp
                                    @else
                                        @php
                                            $url = 'user.profile';

                                        @endphp
                                    @endif
                                    <a class="nav-link active" href="{{ route($url) }}">
                                        <span data-feather="home"></span>
                                        Profile <span class="sr-only">(current)</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <span data-feather="file"></span>
                                        Settings
                                    </a>
                                </li>
                                <h6
                                    class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1">
                                    <span>Project Scope</span>
                                    <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                                        <i class="bi bi-lightning-charge-fill"></i>
                                    </a>
                                </h6>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <span data-feather="shopping-cart"></span>
                                        TODO's
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <span data-feather="shopping-cart"></span>
                                        Projects
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <span data-feather="users"></span>
                                        Reminders
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.tickets') }}">
                                        <span data-feather="bar-chart-2"></span>
                                        Tickets
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <span data-feather="layers"></span>
                                        Employees
                                    </a>
                                </li>
                            </ul>
                            @if (Auth::user()->email == Groups::ADMIN_GROUP)

                                <h6
                                    class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1">
                                    <span>Admin</span>
                                    <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                                        <i class="bi bi-gear-fill"></i>
                                    </a>
                                </h6>
                                <ul class="nav flex-column mb-2">
                                    {{-- Add Colapseable --}}
                                    @php
                                        $active1 = '';
                                        $active2 = '';
                                        $active3 = '';
                                        $active4 = '';
                                        $active5 = '';

                                        if (Request::segment(1) == 'admin') {
                                            if (Request::segment(2) == 'groups') {
                                                $active1 = 'active';
                                            } elseif (Request::segment(2) == 'roles') {
                                                $active2 = 'active';
                                            } elseif (Request::segment(2) == 'permissions') {
                                                $active3 = 'active';
                                            } elseif (Request::segment(2) == 'modules') {
                                                $active4 = 'active';
                                            } elseif (Request::segment(2) == 'users') {
                                                $active5 = 'active';
                                            }
                                        }

                                    @endphp

                                    <li class="nav-item">
                                        <div class="accordion" id="accordionFive">
                                            <a class="nav-link" data-toggle="collapse" data-target="#collapseFive"
                                                aria-expanded="false" aria-controls="collapseFive" href="#">
                                                &nbsp;Site Settings
                                            </a>
                                            <div class="collapse hide" id="collapseFive" class="___class_+?70___"
                                                aria-labelledby="headingFive" data-parent="#accordionFive">
                                                <a href="{{ route('admin.groups') }}"
                                                    class="list-group-item nav-link {{ $active1 }}"><i
                                                        class="bi bi-diagram-3"></i>&nbsp;Groups</a>
                                                <a href="{{ route('admin.roles') }}"
                                                    class="list-group-item nav-link {{ $active2 }}"><i
                                                        class="bi bi-people"></i>&nbsp;
                                                    Roles</a>
                                                <a href="{{ route('admin.permissions') }}"
                                                    class="list-group-item nav-link {{ $active3 }}"><i
                                                        class="bi bi-stoplights"></i>&nbsp;
                                                    Permission</a>
                                                <a href="{{ route('admin.modules') }}"
                                                    class="list-group-item nav-link {{ $active4 }}"><i
                                                        class="bi bi-hdd-stack"></i>&nbsp;
                                                    Module Access</a>
                                                <a href="{{ route('admin.users') }}"
                                                    class="list-group-item nav-link {{ $active5 }}"><i
                                                        class="bi bi-person-badge"></i>&nbsp;
                                                    Users Management</a>

                                            </div>
                                        </div>
                                    </li>


                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <span data-feather="file-text"></span>
                                            DashBoard Management
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <span data-feather="file-text"></span>
                                            Account Management
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <span data-feather="file-text"></span>
                                            3rd Party API Management
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </nav>
                @endauth


                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4" style="top:90px;">
                    <div class="table-responsive">
                        <main class="py-4" id="ajax_main_container">
                            @yield('content')
                        </main>
                    </div>
                </main>
            </div>
        </div>

    </div>
    <script src="{{ asset('js/collapsemenuopen.js') }}" defer></script>

</body>

</html>
