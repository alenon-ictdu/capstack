@extends('layouts.app3')
    
@section('title', 'Book :: Print all QrCode')

@section('breadcrumb')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Print Books Qr</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Books</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Print all QrCode</li>
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
        <ul class="list-inline">
            <li><h3><i class="mdi mdi-file-check"></i> Print All Qr Now!</h3></li>
            <li><button style="position: absolute; right: 35px; top: 25px;" class="btn btn-cyan btn-sm" onclick="printContent('qr')"><i class="fas fa-print"></i> Print</button></li>
        </ul>   
    </div>
</div>

<!-- print content -->
<div id="qr" style="display: none;">
	@foreach($books as $book)
	<div style="display: inline-block;font-family: 'Roboto', sans-serif;;padding: 5px;">
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
    @endforeach
</div>

@endsection

@section('scripts')

<script>
        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
        }   
</script>

@endsection


