@extends('layouts.login-app')

@section('content')

      <div class="wrap-login100 p-t-190 p-b-30">
        <form class="login100-form validate-form" method="POST" action="{{ route('password.email') }}">
          {{ csrf_field() }}

          <span class="login100-form-title p-t-20 p-b-45">
            Reset Password
          </span>

            @if ($errors->has('email'))
                <div class="wrap-input100">
                    <div class="alert alert-danger alert-dismissible fade show" id="close-alert">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>{{ $errors->first('email') }} </strong>
                    </div>
                </div>
            @endif

            @if (session('status'))
                <div class="wrap-input100">
                    <div class="alert alert-success alert-dismissible fade show" id="close-alert">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>{{ session('status') }}</strong>
                    </div>
                </div>
            @endif

          <div class="wrap-input100 validate-input m-b-10" data-validate = "Email is required">
            <input class="input100" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-user"></i>
            </span>
          </div>

          <div class="container-login100-form-btn p-t-10">
            <button class="login100-form-btn">
              Send Password Reset Link
            </button>
          </div>

          <div class="text-center w-full p-t-25 p-b-230">
            
          </div>

          <div class="text-center w-full">
            
          </div>
        </form>
      </div>

@endsection

@section('scripts')
  <script>
    $("#close-alert").fadeTo(5000, 400).slideUp(400, function(){
        $("#close-alert").slideUp(400);
    });
  </script>
@endsection