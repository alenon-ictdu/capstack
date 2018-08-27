<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        {{-- <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> --}}

        <title>Capstack</title>
        <link rel="icon" type="image/png" href="{{ asset('logo-black.png') }}"/>

         <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css"> -->

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
  
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

        <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">

        <link rel="stylesheet" type="text/css" href="{{ asset('css/landing/style.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('css/landing/card.css') }}">

    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span> 
                </button>
                <a href="#"><img src="{{ asset('landing-img/logo-full.png') }}" class="img-logo" style="width: 150px; padding-top: 5px; margin-right: 20px; margin-left: 20px;"></a>
              </div>
              <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                  <li class="{{ Request::is('/') ? 'active' : '' }} {{ Request::is('books/sort-by-year*') ? 'active' : '' }} {{ Request::is('search*') ? 'active' : '' }}"><a href="/">HOME</a></li>
                  <li class="{{ Request::is('books/newly-added*') ? 'active' : '' }}"><a href="{{ route('newly-added') }}">NEWLY ADDED</a></li>
                  <li class="{{ Request::is('books/a-z-list*') ? 'active' : '' }}"><a href="{{ route('a-z-list') }}">A-Z LIST</a></li> 
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">COURSES
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      @foreach($allCourses as $row)
                      <li><a href="{{ route('course', $row->id) }}">{{ $row->name }}</a></li>
                      @endforeach
                    </ul>
                  </li> 
                </ul>
                <form class="navbar-form navbar-right hide-search" action="{{ route('books-search') }}">
                    {{ csrf_field() }}
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="q">
                    <div class="input-group-btn">
                      <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
        </nav>


        <div class="container m-t-100">
          @yield('content')
        </div>

        <footer class="footer-distributed">

          <div class="footer-left">

            <h3>{{-- Cap<span>stock</span> --}}<img src="{{ asset('landing-img/logo-full-white.png') }}" width="250"></h3>

            <p class="footer-links">
              <a href="/">Home</a>
              ·
              <a href="{{ route('newly-added') }}">Newly Added</a>
              ·
              <a href="{{ route('a-z-list') }}">A-Z List</a>
            </p>

            <p class="footer-company-name">Capstack &copy; 2018</p>
          </div>

          <div class="footer-center">

            <div>
              {{-- <i class="fa fa-map-marker"></i> --}}
              <a href="#"><img src="{{ asset('landing-img/logo.png') }}" width="40"></a>
              <p>Systems Plus College Foundation</p>
            </div>

            <div class="m-t-10">
              {{-- <i class="fa fa-phone"></i> --}}
              <a href="#"><img src="{{ asset('landing-img/ictdu-logo.png') }}" width="40"></a>
              <p>ICT Development Unit</p>
            </div>

          </div>

          <div class="footer-right">

            <p class="footer-company-about">
              <span>About the company</span>
              Lorem ipsum dolor sit amet, consectateur adispicing elit. Fusce euismod convallis velit, eu auctor lacus vehicula sit amet.
            </p>

            <div class="footer-icons">

              <a href="#"><i class="fa fa-facebook"></i></a>
              <a href="#"><i class="fa fa-twitter"></i></a>
              <a href="#"><i class="fa fa-linkedin"></i></a>
              <a href="#"><i class="fa fa-github"></i></a>

            </div>

          </div>

        </footer>
    </body>
</html>
