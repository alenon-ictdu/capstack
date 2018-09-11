@extends('layouts.app3')

@section('title', 'Borrowers')

@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Borrowers</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">Borrowers</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

@endsection

@section('content')
@if(session('success'))
  <div class="box bg-success text-center" style="margin-bottom: 10px;">
      <h6 class="text-white"><i class="mdi mdi-thumb-up"></i> {{ session('success') }}</h6>
  </div>
@endif
<div class="card">
	<div class="card-body">
		<table class="table table-hover table-striped" id="indextable">
			<thead>
				<tr>
					<th style="width:11%; ">Name</th>
					<th style="width:11%; ">Address</th>
					<th style="width:11%; ">Contact</th>
					<th style="width:30%; ">Book</th>
					<th style="width:11%; ">Date Borrowed</th>
					<th style="width:11%; ">Due Date</th>
					<th style="width:11%; ">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($borrowers as $row)
					<tr @if(session('isNew') == $row->id) style="font-weight: bold; color: #27a9e3;" @endif>
						<td>{{$row->name}}</td>
						<td>{{$row->address}}</td>
						<td>{{$row->contact }}</td>
						<td>{{$row->book->title}}</td>
						<td>{{date('F d, Y',strtotime($row->created_at) )}}</td>
						<td>{{date('F d, Y',strtotime($row->deadline) )}}</td>
						<td>
							<form method="POST" action="{{ route('destroy.borrow.book', $row->id) }}">
								<button class="btn btn-xs btn-cyan"><i class="fas fa-reply"></i> Return</button>
								<input type="hidden" name="_token" value="{{ Session::token() }}">
                                {{ method_field('DELETE') }}
							</form>
						 	<a href="{{ route('edit.borrow.book', $row->id) }}" class="btn btn-xs btn-success"><i class="fas fa-edit"></i> Edit</a></td>
					</tr>
				@endforeach
			</tbody>
		</table>

	</div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/extra-libs/DataTables/datatables.min.js') }}"></script>
  <script>
    $(document).ready(function() {
    $('#indextable').DataTable();
    } );
  </script>
@endsection
