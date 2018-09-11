@extends('layouts.app3')

@section('title', 'Book :: Show')

@section('styles')
     <link href="{{ asset('css/show.css') }}" rel="stylesheet">  
@endsection

@section('breadcrumb')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Show Book</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Books</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show</li>
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
        <dl class="dl-horizontal">
          <label>Created At:</label>
          <p class="small">{{ date('M j, Y H:i', strtotime($book->created_at)) }}</p>
        </dl>

        <dl class="dl-horizontal">
          <label>Last Updated:</label>
          <p class="small">{{ date('M j, Y H:i', strtotime($book->updated_at)) }}</p>
        </dl>
        <div class="border-top" style="margin-bottom: 10px;"></div>
        <dl class="dl-horizontal">
          {{-- <label>Available:</label> @if($book->availability == 1)
                                        <i style="color: #28b779;" class="fas fa-check"></i>
                                        @else
                                        <i style="color: #da542e;" class="fas fa-times"></i>
                                        @endif --}}
            <label>Quantity :</label> {{ $book->quantity }}
        </dl>
        <dl class="dl-horizontal">
          <label>CD:</label> @if($book->with_cd == 1)
                                        <i style="color: #28b779;" class="fas fa-check"></i>
                                        @else
                                        <i style="color: #da542e;" class="fas fa-times"></i>
                                        @endif
        </dl>
      </div>

    </div>
  </div>
</div>

@endsection

@section('scripts')

<!-- this page js -->
    <script src="{{ asset('assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/libs/magnific-popup/meg.init.js') }}"></script>

@endsection
