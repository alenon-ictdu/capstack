@extends('layouts.app3')

@section('title', 'Borrowed Books')

@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Borrowed Books</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">Borrowed Books</li>
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
		<table class="table table-hover table-striped" id="indextable">
			<thead>
				<tr>
					<th style="width:5%; ">Book ID</th>
					<th style="width:20%; ">Title</th>
					<th style="width:11%; ">Author</th>
					<th style="width:5%; ">With CD</th>
					<th style="width:11%; ">Year Published</th>
					<th>Borrower</th>
					<th style="width:11%; ">Date Borrowed</th>
					<th style="width:11%; ">Due Date</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($books as $book)
					<tr @if(session('isNew') == $book->id) style="font-weight: bold; color: #ff890fe6;" @endif>
						<td>{{$book->id}}</td>
						<td>{{$book->title}}</td>
						<td>{{(strlen($book->author) >= 15) ? substr($book->author, 0, 15). '...' : $book->author}}</td>
						<td>{{ ($book->with_cd) == 0 ? 'No':'Yes' }}</td>
						<td>{{$book->year_published }}</td>
						<td>{{ $book->borrower->firstname. ' ' . $book->borrower->lastname }}</td>
						<td>{{ date('F d, Y',strtotime($book->borrower->created_at) ) }}</td>
						<td>{{ date('F d, Y',strtotime($book->borrower->deadline) ) }}</td>
						<td>
							<form method="POST" action="{{ route('destroy.borrow.book', $book->borrower->id) }}">
								<button class="btn btn-xs btn-cyan"><i class="fas fa-reply"></i> Return</button>
								<input type="hidden" name="_token" value="{{ Session::token() }}">
                                {{ method_field('DELETE') }}
							</form>
						 	<a href="{{ route('edit.borrow.book', $book->borrower->id) }}" class="btn btn-xs btn-success"><i class="fas fa-edit"></i> Edit</a></td>

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