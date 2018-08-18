@extends('layouts.login-app')

@section('content')
  
  
      <div class="wrap-login100 p-t-190 p-b-30">
        <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
          {{ csrf_field() }}
          <div class="login100-form-avatar">
            <img src="{{ asset('logo-white.png') }}" alt="AVATAR">
          </div>

          <span class="login100-form-title p-t-10 p-b-20">
            
          </span>
          @if ($errors->has('email') || $errors->has('password'))
          <div class="wrap-input100">
            <div class="alert alert-danger alert-dismissible fade show" id="danger-alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Invalid Email/Password!</strong>
            </div>
          </div>
          @endif
          <div class="wrap-input100 validate-input m-b-10" data-validate = "Email is required">
            <input class="input100" type="text" name="email" placeholder="Email">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-user"></i>
            </span>
          </div>

          <div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
            <input class="input100" type="password" name="password" placeholder="Password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock"></i>
            </span>
          </div>

          <div class="container-login100-form-btn p-t-10">
            <button class="login100-form-btn">
              Login
            </button>
          </div>

          <div class="text-center w-full p-t-25 p-b-230">
            <a href="{{ route('password.request') }}" class="txt1">
              Forgot Password?
            </a>
          </div>

          <div class="text-center w-full">
            
          </div>
        </form>
      </div>
  
@endsection

@section('scripts')
  <script>
    $("#danger-alert").fadeTo(5000, 400).slideUp(400, function(){
        $("#danger-alert").slideUp(400);
    });
  </script>
@endsection