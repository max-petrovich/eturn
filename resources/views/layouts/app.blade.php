<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $pageTitle or  trans('all.site_title') }}</title>

    <!-- Fonts -->
    {{ Html::style('assets/bower/components-font-awesome/css/font-awesome.min.css') }}

    <link href="//fonts.googleapis.com/css?family=Open+Sans" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    {{ Html::style('css/app.css') }}

    <style>
        body {
            font-family: 'Open Sans';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    {{ Html::style('css/styles.css') }}
    <!-- Angular -->
    {{ Html::script('assets/bower/angular/angular.min.js') }}
    {{ Html::script('app/lib/angular/ui-bootstrap-tpls-1.3.2.min.js') }}
    {{ Html::script('app/app.js') }}
    <base href="/">
</head>
<body id="app-layout" ng-app="booking">

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ trans('all.site_title') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('monitoring') }}">{{ trans('all.monitoring') }}</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{{ trans('user.login') }}</a></li>
                        <li><a href="{{ url('/register') }}">{{ trans('user.register') }}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                @if(Auth::user()->is('admin'))
                                    <li><a href="{{ url('/admin') }}" target="_blank"><i class="fa fa-btn fa-user"></i>{{ trans('user.admin_panel') }}</a></li>
                                @endif
                                <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>{{ trans('user.profile') }}</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{{ trans('user.logout') }}</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @include('partials.errors')
    @include('booking.partials.message')
    @if(isset($steps))
        @include('booking.partials.steps')
    @endif
    @yield('content')

    <!-- JavaScripts -->
    {{ Html::script('js/app.js') }}
    @stack('scripts')
</body>
</html>
