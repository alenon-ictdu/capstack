@extends('layouts.app')

@section('content')

<div class="container">
	<div class="col-sm-8 col-sm-offset-2" style="margin-top: 50px;">
		<form method="POST" action="{{ route('course.update', $course->id) }}">
		  <div class="form-group">
		    <label for="name">Course Name:</label>
		    <input type="text" class="form-control input-sm" name="course_name" value="{{ $course->name }}" required>
		  </div>
		  <input type="hidden" name="_token" value="{{ Session::token() }}">
				  {{ method_field('PUT') }}
		  <button type="submit" class="btn btn-primary btn-xs pull-right"><i class="far fa-save"></i> Save changes</button>
		</form>
	</div>
</div>

@endsection