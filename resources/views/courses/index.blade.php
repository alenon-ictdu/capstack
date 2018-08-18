@extends('layouts.app3')

@section('title', 'Courses')

@section('breadcrumb')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Courses</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">Courses</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')

@if(session('success'))
  <div class="box bg-success text-center" style="margin-bottom: 10px;">
      <h6 class="text-white"><i class="mdi mdi-thumb-up"></i> {{ session('success') }}</h6>
  </div>
@endif

<div class="row">
	<div class="col-lg-8">
		<div class="card">
			<div class="card-body border-bottom">
				<h4 class="card-title"><i class="fas fa-list"></i> List</h4>
			</div>
			<div class="card-body">
				<table class="table table-hover table-bordered" id="indextable">
				    <thead>
				      <tr>
				        <th>ID</th>
				        <th>Name</th>
				        <th>Action</th>
				      </tr>
				    </thead>
				    <tbody>
				    @foreach($courses as $row)
				      <tr>
				        <td>{{ $row->id }}</td>
				        <td>{{ $row->name }}</td>
				        <td><button data-toggle="modal" data-target="#course{{$row->id}}Modal" class="btn btn-sm btn-cyan"><i class="fas fa-edit"></i> Edit</button></td>
				      </tr>

				    <!-- Modal -->
					<div class="modal fade" id="course{{$row->id}}Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Edit Course</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					       	<form id="edit_form{{$row->id}}" method="POST">
							  <div class="form-group">
							    <label for="name">Course Name:</label>
							    <input type="text" class="form-control input-sm" name="editedname" value="{{ $row->name }}" required>
							  </div>
							  <input type="hidden" name="_token" value="{{ Session::token() }}">
    						{{ method_field('PUT') }}
							</form>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
					        <button type="submit" form="edit_form{{$row->id}}" formaction="{{ route('course.update', $row->id) }}" type="button" class="btn btn-sm btn-cyan">Save changes</button>
					      </div>
					    </div>
					  </div>
					</div>

				    @endforeach
				    </tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="card">
			<div class="card-body border-bottom">
				<h4 class="card-title"><i class="fas fa-plus"></i> Add Course</h4>
			</div>
			<div class="card-body">
				<form action="{{ route('course.store') }}" method="POST">
					{{ csrf_field() }}
				  <div class="form-group">
				    <label for="name">Course Name:</label>
				    <input type="text" class="form-control input-sm" name="name" required>
				  </div>
				  <button type="submit" class="btn btn-cyan btn-sm">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection


@section('scripts')

  <!-- this page js -->
    <script src="{{ asset('assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/DataTables/datatables.min.js') }}"></script>
  <script>
    $('#indextable').DataTable();

  </script>

 
@endsection

