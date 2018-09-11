@extends('layouts.app3')

@section('title', 'Book :: List')

@section('breadcrumb')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Books</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">Books</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if(session('borrow_warning'))
                <script>
                  alert('Book no.' + {{ session('borrow_warning') }} + ' is not available.');
                </script>
            @endif
            @if(session('success'))
              <div class="box bg-success text-center" style="margin-bottom: 10px;">
                  <h6 class="text-white"><i class="mdi mdi-thumb-up"></i> {{ session('success') }}</h6>
              </div>
            @endif
            @if(session('info'))
              <div class="box bg-info text-center" style="margin-bottom: 10px;">
                  <h6 class="text-white"><i class="mdi mdi-information"></i> {{ session('info') }}</h6>
              </div>
            @endif
            <div class="card card-default">
                <div class="card-body">
                        <a href="{{ route('book.create') }}" class="btn btn-cyan btn-sm"><i class="fa fa-plus"></i> Add Book</a>
                        <a href="{{ route('backup.book') }}" class="btn btn-cyan btn-sm"><i class="fa fa-download"></i> Backup Database</a>
                        <a href="#" class="btn btn-sm btn-cyan" onclick="printContent('all-books')"><i class="fa fa-print"></i> Print Books Data</a>
                        <a href="{{ route('select-books') }}" style="float:right" class="btn btn-sm btn-dark">Select a qr to print</a>
                        <a href="{{ route('books.print') }}" class="btn btn-cyan btn-sm"><i class="fa fa-print"></i> Print All QR</a>
                        <a href="{{ route('exportbooks') }}" class="btn btn-cyan btn-sm"><i class="fa fa-download"></i> Export Records</a>
                </div>

                <div class="border-top">
                  <div class="card-body">
                    
                      <table class="table table-striped table-hover table-bordered" id="indextable">
                          <thead>
                            <tr>
                              <th style="width:10%">ID</th>
                              <th style="width:30%">Title</th>
                              <th style="width:10%">Author(s)</th>
                              <th style="width:10%">Year Published</th>
                              <th>Course</th>
                              <th>Quantity</th>
                              {{-- <th>Availability</th> --}}
                              <th>CD</th>
                              <th>QR Code</th>
                              <th style="width:25%" >Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($books  as $book)
                                    <tr>
                                      
                                      <td>{{ $book->id }}</td>
                                      <td title="{{ $book->title }}">{{ $book->title }} @if($book->created_at >= $day7) <span class="badge badge-danger">New</span> @endif</td>
                                      <td title="{{ $book->author }}">{{ (strlen($book->author) >= 30) ? substr($book->author, 0, 30). '...' : $book->author }}</td>
                                      <td>{{ $book->year_published }}</td>    
                                      <td>{{ $book->course['name'] }}</td>
                                      {{-- <td>@if($book->availability == 1)
                                          <i style="color: #28b779;" class="fas fa-check"></i>
                                          @else
                                          <i style="color: #da542e;" class="fas fa-times"></i>
                                          @endif
                                      </td> --}}
                                      <td>{{ $book->quantity }}</td>
                                      <td>@if($book->with_cd == 1)
                                          <i style="color: #28b779;" class="fas fa-check"></i>
                                          @else
                                          <i style="color: #da542e;" class="fas fa-times"></i>
                                          @endif
                                      </td>
                                      <td>
                                          <a href="#" class="btn btn-outline-dark btn-xs" data-toggle="modal" data-target="#myModal{{$book->id}}" title="Click me to view the QR"><i class="fa fa-qrcode"></i></a>
                                      </td>
                                      <td>
                                          <a href="{{ route('book.show', $book->id) }}" class="btn btn-outline-dark btn-xs"><i class="fa fa-eye"></i> View</a>
                                          @if($book->quantity >= 1)
                                            <a href="{{ route('view.borrow.book', $book->id) }}" class="btn btn-outline-dark btn-xs"><i class="fa fa-book"></i> Borrow</a>
                                          @endif
                                          <a href="{{ route('book.edit', $book->id) }}" class="btn btn-outline-dark btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                                                                  
                                          <form  class="form_inline" method="POST" action="{{ route('book.destroy', $book->id) }}" onsubmit="return ConfirmDelete()">
                                          <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                                          <input type="hidden" name="_token" value="{{ Session::token() }}">
                                          {{ method_field('DELETE') }}
                                          </form>
                                      </td>
                                      
                                    </tr>
                                    <!-- Modal -->
                                      <div class="modal fade" id="myModal{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                            <div class="modal-body" >
                                              <div class="row">
                                                  <div class="col-md-offset-2">
                                                      <img src="data:image/png;base64, {{base64_encode(QrCode::format('png')->size(480)->generate('{ id : '.$book->id. ' }'))}} ">
                                                  </div>
                                              </div>
                                            </div>

                                            <!-- print content -->
                                            <div id="qr{{$book->id}}" style="display: none;">
                                              <div style="display: inline-block;font-family: 'Roboto', sans-serif;;padding: 5px;" >
                                                  <img src="{{ asset('images/spcf-property.png') }}" width="300" style="border-bottom: 1px solid black; padding-bottom: 5px;">
                                                  
                                                  <ul class="list-inline" >
                                                      <div style="float:left;"><img src="data:image/png;base64, {{base64_encode(QrCode::format('png')->size(100)->generate('{ id : '.$book->id. ' }'))}} "></div>
                                                      <div style="display: inline-block; margin-top: 28px;">
                                                          {{-- <h1 style="font-size: 12px;">ID: {{ $book }}</h1> --}}
                                                          <strong>ID No: </strong>{{$book->id}}<br>
                                                          <strong>Course: </strong>{{$book->course['name']}}<br>
                                                          <strong>Year Published: </strong>{{$book->year_published}}
                                                      </div>
                                                  </ul> 
                                              </div>
                                            </div>
                                            
                                            <div class="modal-footer">
                                              <button class="btn btn-cyan btn-sm" onclick="printContent('qr{{$book->id}}')"><i class="fa fa-print"></i> Print</button>
                                              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div> 
                                    <!-- Modal -->
                              @endforeach
                          </tbody>
                      </table>
                    

                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="all-books">
  <div class="container">
    <div class="col-md-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Year Published</th>
            <th>Availability</th>
            <th>CD Availability</th>
          </tr>
        </thead>
        <tbody>
          @foreach($allBooks as $row)
          <tr>
            <td>{{ $row->id }}</td>
            <td>{{ $row->title }}</td>
            <td>{{ $row->author }}</td>
            <td>{{ $row->year_published }}</td>
            <td>@if($row->availability == 1)
                {{ 'Yes' }}
                @else
                {{ 'No' }}
                @endif
            </td>
            <td>@if($row->with_cd == 1)
                {{ 'Yes' }}
                @else
                {{ 'No' }}
                @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>


<script>

        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
        }   

        function blinker() {
            $('.blink_me').fadeOut(500);
            $('.blink_me').fadeIn(500);
        }

        setInterval(blinker, 1000);
        


        //////////////////////////////////////////

        var expanded = false;

        function showCheckboxes() {
          var checkboxes = document.getElementById("checkboxes");
          if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
          } else {
            checkboxes.style.display = "none";
            expanded = false;
          }
        }

         function ConfirmDelete()
          {
          var x = confirm("Are you sure you want to delete this book?");
          if (x)
            return true;
          else
            return false;
          }     
</script>

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

