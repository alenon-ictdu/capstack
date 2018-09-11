@extends('layouts.app3')

@section('title', 'Book :: Borrow')

@section('styles')
     <link href="{{ asset('css/show.css') }}" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="{{ asset('/css/borrow.css') }}">  
     <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Borrow Book</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Books</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Borrow</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

@endsection

@section('content')

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-7 border-right">
        <h1 style="display: inline;">{{ $book->title }} </h1><br>
        <label>Author(s): </label> {{ $book->author }} <br>
        <label>Year Published: </label> {{ $book->year_published }} <br>
        <label>Course: </label> @foreach($courses as $row) @if($row->id == $book->course_id) {{ $row->name }} @endif @endforeach

        <div class="row el-element-overlay">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="el-card-item">
                        <div class="el-card-avatar el-overlay-1"> @if($book->image == '') <img src="{{ asset('default-book.jpg') }}"/> @else <img src="{{ asset('images/' . $book->image) }}"/> @endif
                            <div class="el-overlay">
                                <ul class="list-style-none el-info">
                                    <li class="el-item">@if($book->image == '') <a class="btn default btn-outline image-popup-vertical-fit el-link" href="{{ asset('default-book.jpg') }}"><i class="mdi mdi-magnify-plus"></i></a> @else <a class="btn default btn-outline image-popup-vertical-fit el-link" href="{{ asset('images/' . $book->image) }}"><i class="mdi mdi-magnify-plus"></i></a> @endif</li>
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="el-card-content">
                            <h4 class="m-b-0">Project title</h4> <span class="text-muted">subtitle of project</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="col-lg-5">
      	<div class="card-body border-bottom" style=" margin-bottom: 10px;">
      		<h4 class="card-title"><i class="fas fa-user"></i> Borrower Info</h4>
      	</div>
        <form action="{{ route('borrow.book') }}" class="form-horizontal" method="POST" data-parsley-validate="parsley" enctype="multipart/form-data">
	    {{ csrf_field() }}
	    	<input type="hidden" name="book_id" value="{{ $book->id }}">
	          <div class="form-group">
	              <label for="firstname">Name</label>
	              <input type="text" id="name" class="form-control input-sm" name="name" value="{{ old('name') }}" required data-parsley-maxlength="255" data-parsley-required-message="Name is required">
	          </div>
	          <div class="form-group">
	              <label for="address">Address</label>
	              <input type="text" id="address" class="form-control input-sm" name="address" value="{{ old('address') }}" >
	          </div>
	          <div class="form-group">
	              <label for="contact">Contact No. or Email</label>
	              <input type="text" id="contact" class="form-control input-sm" name="contact" value="{{ old('contact') }}" required data-parsley-maxlength="25" data-parsley-required-message="Contact is required">
	          </div>
	          <div class="form-group">
	              <label for="deadline">Due Date</label>
	              <input type="date" id="deadline" class="form-control input-sm" name="deadline" value="{{ old('deadline') }}" required data-parsley-required-message="Deadline is required">
	          </div>
	          <button class="btn btn-block btn-cyan btn-sm">Submit</button>
	  	</form>
      </div>

    </div>
  </div>
</div>

@endsection

@section('scripts')
      <script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection