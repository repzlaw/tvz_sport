<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','TVZ Sports')</title>
    <!-- <meta name="keywords" content="@yield('meta_keywords','some default keywords')"> -->
    <meta name="description" content="@yield('meta_description','TVZ Sports')">
    <link rel="canonical" href="{{url()->current()}}"/>
    @yield('links')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- jquery cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js" integrity="sha512-BmM0/BQlqh02wuK5Gz9yrbe7VyIVwOzD1o40yi1IsTjriX/NGF37NyXHfmFzIlMmoSIBXgqDiG1VNU6kB5dBbA==" crossorigin="anonymous"></script> -->

    <!-- bootstrap cdn -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #212529;
        }
        @yield('style')
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    TVZ Sports
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">{{ __('Home') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/events">{{ __('Events') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/matches">{{ __('Matches') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/teams">{{ __('Teams') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/players">{{ __('Players') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/forums">{{ __('Forums') }}</a>
                        </li>

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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{-- {{ Auth::user()->display_name ? Auth::user()->display_name : Auth::user()->username }} --}}
                                    
                                    @if (Auth::user()->picture)
                                        <img
                                        src="/storage/images/profile/{{Auth::user()->picture->file_path}}"
                                        alt="{{ Auth::user()->username}}"
                                        style="height: 30px; width:30px;  border-radius: 15px;"/>
                                    @else
                                        <img
                                        src="/storage/images/profile/no_image.png"
                                        alt="{{ Auth::user()->username}}"
                                        style="height: 30px; width:30px;  border-radius: 15px;"/>
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/profile">
                                        <i class="fa fa-user text-primary mr-2"></i>
                                        {{ __('Profile') }}
                                    </a>

                                    @if (Auth::user()->role_id === 2 || Auth::user()->role_id === 3)
                                    <a class="dropdown-item" href="/user/news">
                                        <i class="fa fa-newspaper text-primary mr-2"></i>
                                        {{ __('Post news') }}
                                    </a>
                                    @endif

                                    <a class="dropdown-item" href="/user/settings">
                                        <i class="fa fa-cog text-primary mr-2"></i>
                                        {{ __('Settings') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out-alt text-danger mr-2"></i>
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
            @include('inc.message')

            @yield('content')
        </main>
    </div>
    <!-- <script src="{{asset('js/.min.js')}}"></script> -->
    @yield('scripts')
</body>
</html>
