<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('assets/images/tms-icon.ico') }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/welcome.css') }}">

    </head>
    <body onload="myFunction()" style="background-color: #222222;width: 100%;height: 100vh;margin: 0;">
        <div>
            <img class="tms" src="{{ asset('tms.png') }}">
        </div>
        
        <div class="bookshelf_wrapper" id="loader">

              <ul class="books_list" id="loader_ul">
                <li class="book_item first" id="loader_li1"></li>
                <li class="book_item second" id="loader_li2"></li>
                <li class="book_item third" id="loader_li3" ></li>
                <li class="book_item fourth" id="loader_li4"></li>
                <li class="book_item fifth" id="loader_li5"></li>
                <li class="book_item sixth" id="loader_li6"></li>
              </ul>
          <div class="shelf" id="loader_shelf"></div>
        </div>

        <div class="flex-center position-ref full-height" id="myDiv">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        
                    @endauth
                </div>
            @endif

            </div>
        </div>
    </body>

    <script>
        var myVar;

        function myFunction() {
            myVar = setTimeout(showPage, 3000);
        }

        function showPage() {

          
         
            window.open("{{ url('/dashboard') }}", "_self");
        }   
    </script>
</html>
