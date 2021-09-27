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
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">
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
                        <li class="nav-item dropdown">

                                <a class="dropdown-item text-light" style="text-decoration:none" href="{{ route('2fa.logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out-alt text-danger mr-2"></i>
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('2fa.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>

        <main class="py-4">
            @include('inc.message')
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">2FA Authentication </div>
                            <div class="card-body">
                                <p>Enter the pin from the google authenticator app</p>
                                <form action="{{ route('2faVerify') }}" method="post">
                                    @csrf
                                    <input id="one_time_password" type="password" class="form-control" name="one_time_password" required>
                                    <div class="col-md-8 col-12 mt-2">
                                        <button type="submit" class="btn btn-success"> Proceed </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- <script src="{{asset('js/.min.js')}}"></script> -->
    @yield('scripts')
</body>
</html>
