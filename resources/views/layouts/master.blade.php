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
        <!-- <div class="container"> -->
            <a class="navbar-brand" href="{{ url('/admin/home') }}">
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
                    <!-- Authentication Links -->
                    @if(!Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                        </li>
                    @else
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.sport.all') }}">{{ __('Sports') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.competition.all') }}">{{ __('Competitions') }}</a>
                        </li> -->

                        <!-- <li class="nav-item">
                            <a class="nav-link" href="/matches">{{ __('Matches') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/teams">{{ __('Teams') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/players">{{ __('Players') }}</a>
                        </li> -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('admin')->user()->username }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                    {{ __('Logout') }}
                                </a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        <!-- </div> -->
    </nav>
    <div class="container-fluid">
  <div class="row">
  @if(Auth::guard('admin')->check())
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="{{ url('/admin/home') }}">
                <i class="fa fa-home mr-2"></i>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.sport.all') }}">
                <i class="fa fa-baseball-ball mr-2"></i>
              Sports
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.competition.all') }}">
            <i class="fa fa-quidditch mr-2"></i>
              Competitions
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.user.all') }}">
            <i class="fa fa-users mr-2"></i>
              Users
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.editor.all') }}">
            <i class="fa fa-users mr-2"></i>
              Editors
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.forum.all') }}">
            <i class="fab fa-forumbee mr-2"></i>
              Forum 
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.forum-category.all') }}">
            <i class="fab fa-forumbee mr-2"></i>
              Forum Categories
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.ban-policy.all') }}">
            <i class="fa fa-balance-scale-left mr-2"></i>
              Ban Policies
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.support-department.all') }}">
            <i class="fa fa-building mr-2"></i>
              Support Departments
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.history.all') }}">
            <i class="fa fa-ban mr-2"></i>
              Suspension History
            </a>
          </li>
          
          <li class="dropdown">
            <a class="dropdown-toggle nav-link"
              data-toggle="dropdown"
              href="#">
              <i class="fa fa-chart-line mr-2"></i>
                Login Logs
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <!-- links -->
              <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.login-log.admin') }}">
                  Admin Logs
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.login-log.editor') }}">
                  Editor logs
                </a>
              </li>
            </ul>
          </li>

          <li class="dropdown">
            <a class="dropdown-toggle nav-link"
              data-toggle="dropdown"
              href="#">
              <i class="fa fa-user-slash mr-2"></i>
                Failed Logins
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <!-- links -->
              <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.failed-login.admin') }}">
                  Admin Failed Logins
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.failed-login.editor') }}">
                  Editor Failed Logins
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.setting.all') }}">
            <i class="fa fa-cog mr-2"></i>
              Settings
            </a>
          </li>

          <!-- <li class="nav-item">
            <a class="nav-link" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
              Reports
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
              Integrations
            </a>
          </li> -->
        </ul>

        <!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="d-flex align-items-center text-muted" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
              Current month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
              Year-end sale
            </a>
          </li>
        </ul> -->
      </div>
    </nav>
  @endif
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" style="height:100vh;">
        <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
        @include('inc.message')

        @yield('content')
      <!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            This week
          </button>
        </div>
      </div> -->

      <!-- <canvas class="my-4 w-100 chartjs-render-monitor" id="myChart" width="1522" height="642" style="display: block; height: 514px; width: 1218px;"></canvas>

      <h2>Section title</h2> -->
      
    </main>
  </div>
</div>
</div>
<!-- <script src="{{asset('js/.min.js')}}"></script> -->
@yield('scripts')
</body>
</html>