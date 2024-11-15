<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ACTS') }}</title>
    <link rel="shortcut icon" href="{{ asset('build/assets/images/smmie_logo.ico') }}" type="image/ico">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <style>
        .active {
            font-weight: bolder;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-info shadow-sm">
            <div class="container-fluid">
                <img src="{{ asset('build/assets/images/acts_logo_transparent.jpg') }}" style="width: 30px; margin-right: 10px;" alt="Logo">
                <a class="navbar-brand" href="{{ url('/') }}">ACTS Payroll System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            {{-- @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('payroll') ? 'active' : '' }} {{ request()->is('payroll/*') ? 'active' : '' }}" href="{{ route('payroll') }}">{{ __('Payroll') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('reports') ? 'active' : '' }} {{ request()->is('reports/*') ? 'active' : '' }}" href="{{ route('reports') }}">{{ __('Reports') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('staff') ? 'active' : '' }} {{ request()->is('staff/*') ? 'active' : '' }}" href="{{ route('staff') }}">{{ __('Staff') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('payslips') ? 'active' : '' }} {{ request()->is('payslips/*') ? 'active' : '' }}" href="{{ route('payslips') }}">{{ __('Payslips') }}</a>
                            </li>

                            {{-- <li class="nav-item">
                                <a class="nav-link " href="">{{ __('Setup') }}</a>
                            </li> --}}

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('loans') ? 'active' : '' }} {{ request()->is('loans/*') ? 'active' : '' }}" href="{{ route('loans') }}">{{ __('Loans') }}</a>
                            </li>

{{--                            @if(Auth::user()->id === 1)--}}
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle
                                    {{ request()->is('dropdowns') ? 'active' : '' }} {{ request()->is('dropdowns/*') ? 'active' : '' }}
                                    {{ request()->is('taxs') ? 'active' : '' }}
                                    {{ request()->is('salary') ? 'active' : '' }} {{ request()->is('salary/*') ? 'active' : '' }}
                                    " href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Settings
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('salary') }}">
                                            {{ __('Salary Setup') }}
                                        </a>

                                        <a class="dropdown-item" href="{{ route('dropdowns') }}">
                                            {{ __('Dropdowns') }}
                                        </a>

                                        <a class="dropdown-item" href="{{ route('taxs') }}">
                                            {{ __('Tax Inputs') }}
                                        </a>
                                    </div>
                                </li>
{{--                            @endif--}}

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle {{ request()->is('users') ? 'active' : '' }} {{ request()->is('register') ? 'active' : '' }} {{ request()->is('password/*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    @if (Auth::user()->id === 1)
                                        {{-- <a class="dropdown-item" href="{{ route('register') }}">
                                            {{ __('Register') }}
                                        </a> --}}
                                        <a class="dropdown-item" href="{{ route('users') }}">
                                            {{ __('Users') }}
                                        </a>
                                    @endif

                                    {{-- <a class="dropdown-item" href="#">
                                        {{ __('Profile') }}
                                    </a> --}}
                                    <a class="dropdown-item" href="#"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                                        >
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    <h4>{{ Session::get('success') }}</h4>
                </div>
            @endif

            @if (Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    <h4>{{ Session::get('error') }}</h4>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script>
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
    });
</script>

</html>
