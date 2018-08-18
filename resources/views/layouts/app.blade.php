<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inventory</title>

    <link rel="shortcut icon" href="{{ asset('sample.ico') }}" />
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')

    <!-- Font Awesome icon -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    <style>

        @media only screen and (max-width: 769px) {
            .dropdown>.testprofile{
                float:left;
                margin-left: 20px;
            }
            .dropdown>img{
                float:left;
                margin-left: 20px;
            }
        }

        @media only screen and (min-width: 770px) {
            .dropdown>.testprofile{
                float:right;
            }
        }
</style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        Inventory
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @guest

                        @else

                            <li class="{{ Request::is('home*') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                            <li class="{{ Request::is('book/borrowers*') ? 'active' : '' }}"><a href="{{ route('view.borrowers') }}">Borrowers</a></li>
                            <li class="{{ Request::is('book/borrowed*') ? 'active' : '' }}"><a href="{{ route('book.borrowed') }}">Book Borrowed</a></li>
                            <li class="{{ Request::is('course*') ? 'active' : '' }}"><a href="{{ route('course.index') }}">Courses</a></li>
                            @if($penalty_num > 0)<li class="{{ Request::is('book/penalty*') ? 'active' : '' }}"><a href="{{ route('book.penalty') }}">Penalty  <span class="badge blink_me" style="background-color: red;">{{ $penalty_num}}</span> </a></li>@endif
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li class="{{ Request::is('login') ? 'active' : '' }}"><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                            
                        @else
                            <li class="dropdown {{ Request::is('user*') ? 'active' : '' }}">
                                @if(Auth::user()->image == '')
                                    <img src="{{ asset('default-profile.png') }} " width="28;" height="28" style="border-radius: 50%; margin-top: 10px;">
                                @else
                                    <img src="{{ asset('images/' . Auth::user()->image) }} " width="28;" height="28" style="border-radius: 50%; margin-top: 10px;">
                                @endif
                                <a href="#" class="dropdown-toggle testprofile" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre >
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('view.user') }}"><i class="fas fa-user-circle"></i> Profile</a></li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i>
                                             Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <!-- spacer -->
        <div style="margin-bottom: 100px;">
            
        </div>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- jQuery library 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
-->

    <script>
         function blinker() {
            $('.blink_me').fadeOut(500);
            $('.blink_me').fadeIn(500);
        }

        setInterval(blinker, 1000);
    </script>
    @yield('scripts')
</body>
</html>
