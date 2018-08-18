@extends('layouts.app3')

@section('title', 'Admin Profile')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/settings.css') }}">
    <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Admin Profile</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

@endsection

@section('content')

@if(session('success'))
	<div class="box bg-success text-center col-lg-8 offset-lg-2" style="margin-bottom: 10px;">
	  <h6 class="text-white"><i class="mdi mdi-thumb-up"></i> {{ session('success') }}</h6>
	</div>
@endif
@if($errors->has('profile_picture'))
    <div class="box bg-danger text-center col-lg-8 offset-lg-2" style="margin-bottom: 10px;">
	  <h6 class="text-white"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('profile_picture') }}</h6>
	</div>
@endif
@if($errors->has('name') || $errors->has('email'))
    <div class="box bg-danger text-center col-lg-8 offset-lg-2" style="margin-bottom: 10px;">
	  <h6 class="text-white"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</h6>
	  <h6 class="text-white"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('email') }}</h6>
	</div>
@endif
@if($errors->has('old_password') || $errors->has('new_password'))
    <div class="box bg-danger text-center col-lg-8 offset-lg-2" style="margin-bottom: 10px;">
    @if($errors->first('old_password'))
	  <h6 class="text-white"><i class="fas fa-info"></i> {{ $errors->first('old_password') }}</h6>
	@endif
	@if($errors->first('new_password'))
	  <h6 class="text-white"><i class="fas fa-info"></i> {{ $errors->first('new_password') }}</h6>
	@endif
	</div>
@endif

<div class="col-lg-8 offset-lg-2">
	<div class="accordion" id="accordionExample">
	    <div class="card m-b-0">
	        <div class="card-header" id="headingOne">
	          <h5 class="mb-0">
	            <a  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
	                <i class="m-r-5 fas fa-image" aria-hidden="true"></i>
	                <span>Profile Picture</span>
	            </a>
	          </h5>
	        </div>
	        <div id="collapseOne" class="collapse @if($errors->has('profile_picture')) show @endif @if(session('picture-is-in')) show @endif " aria-labelledby="headingOne" data-parent="#accordionExample">
	          <div class="card-body">
	            <div class="row">
		      		<div class="col-md-2">
		      			@if(Auth::user()->image == '')
		      				<img src=" {{ asset('default-profile.png') }} " width="100" height="100">
		      			@else
							<img src=" {{ asset('images/' . Auth::user()->image) }} " width="100" height="100">
		      			@endif
		      		</div>
		      		<div class="col-md-8">			      			
		      			<form action="{{ route('update.picture') }}" method="POST" enctype="multipart/form-data" data-parsley-validate="parsley">
		      				{{ csrf_field() }}
		      				<div class="custom-file">
		                     	<input type="file" class="custom-file-input" id="validatedCustomFile" name="profile_picture">
		                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
		                        <div class="invalid-feedback">Example invalid custom file feedback</div>
		                    </div>
		      				{{-- <input type="file" name="profile_picture" class="form-group margin-top-30" required data-parsley-required-message="Please insert an image"> --}}
		      				<button class="btn btn-success btn-sm" style="margin-top: 10px;"><i class="fas fa-save"></i> Save changes</button>
		      			</form>
		      		</div>
		      	</div>
	          </div>
	        </div>
	    </div>
	    <div class="card m-b-0 border-top">
	        <div class="card-header" id="headingTwo">
	          <h5 class="mb-0">
	            <a class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
	                <i class="m-r-5 fas fa-user-circle" aria-hidden="true"></i>
	                <span>Information</span>
	            </a>
	          </h5>
	        </div>
	        <div id="collapseTwo" class="collapse @if($errors->has('name') || $errors->has('email')) show @endif @if(session('info-is-in')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionExample">
	          <div class="card-body">
	            <form action="{{ route('update.info') }}" method="POST" data-parsley-validate="parsley">
		      	  {{ csrf_field() }}
				  <div class="form-group">
				    <label for="exampleInputName">Name</label>
				    <input type="text" class="form-control" id="exampleInputName" placeholder="Name" value="{{ Auth::user()->name }}" name="name" required data-parsley-required-message="Name is required">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail">Email address</label>
				    <input type="email" class="form-control" id="exampleInputEmail" placeholder="Email" value="{{ Auth::user()->email }}" name="email" required data-parsley-required-message="Email is required">
				  </div>
				  <button class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save changes</button>
				</form>
	          </div>
	        </div>
	    </div>
	    <div class="card m-b-0 border-top">
	        <div class="card-header" id="headingThree">
	          <h5 class="mb-0">
	            <a class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
	                <i class="m-r-5 fas fa-lock" aria-hidden="true"></i>
	                <span>Password</span>
	            </a>
	          </h5>
	        </div>
	        <div id="collapseThree" class="collapse @if($errors->has('old_password') || $errors->has('new_password')) show @endif @if(session('password-is-in')) show @endif" aria-labelledby="headingThree" data-parent="#accordionExample">
	          <div class="card-body">
	            <form action="{{ route('update.password', Auth::user()->id) }}" method="POST" data-parsley-validate="parsley">
				  <div class="form-group">
				    <label>Old Password</label>
				    <input type="password" class="form-control" placeholder="Old Password" name="old_password" required data-parsley-required-message="Old Password is required">
				  </div>
				  <div class="form-group">
				    <label>New Password</label>
				    <input type="password" class="form-control" placeholder="New Password" name="new_password" required data-parsley-required-message="New Password is required">
				  </div>
				  <div class="form-group">
				    <label>Confirm New Password</label>
				    <input type="password" class="form-control" placeholder="Confirm New Password" name="new_password_confirmation" required data-parsley-required-message="New Password is required"> 
				  </div>
				  <button class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save changes</button>
				   <input type="hidden" name="_token" value="{{ Session::token() }}">
	 				{{ method_field('PUT') }}
				</form>
	          </div>
	        </div>
	    </div>
	</div>
</div>

@endsection

@section('scripts')
      <script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection