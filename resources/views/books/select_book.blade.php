@extends('layouts.app3')
        
@section('title', 'Book :: Print selected QrCode')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Print Books Qr</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Books</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Print Selected QrCode</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

@endsection

@section('content')

<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body border-bottom">
                <h4 class="card-title"><i class="fas fa-list"></i> Books</h4>
            </div>
            <div class="card-body">
                <table id="books-table" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author(s)</th>
                            <th>Year Published</th>
                            <th>Course</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $row)
                        <tr>
                            <td class="ir">{{ $row->id }}</td>
                            <td class="tr">{{ $row->title }}</td>
                            <td>{{ $row->author }}</td>
                            <td>{{ $row->year_published }}</td>
                            <td>{{ $row->course['name'] }}</td>
                            <td><button class="btn btn-success btn-xs add-item" id="add-btn"><i class="fas fa-plus"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="card">
            <div class="card-body border-bottom">
                <h4 class="card-title"><i class="fas fa-list"></i> Selected Books</h4>
            </div>
            <div class="card-body">
                <button style="float: right; margin-bottom: 8px;" class="btn btn-xs btn-cyan" id="print-selected-qr" form="selected_form">Print</button>
                <form id="selected_form" action="{{ route('print-selected-books') }}" method="POST">
                    {{csrf_field()}}
                    <table id="selectedTable" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Quantity</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="exampleModalLabel">Alert Model</h5> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Are you sure you want to print these qr books?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-cyan" onclick="printContent('qr_content')">Ok</button>
            </div>
        </div>
    </div>
</div>


<div id="qr_content" style="display: none;">
</div>

@endsection

@section('scripts')
  <!-- this page js -->
    <script src="{{ asset('js/qrcode.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/DataTables/datatables.min.js') }}"></script>

    <script>
    $('#books-table').DataTable();
    </script>

    <script>
    $("#books-table").on('click', '.add-item', function() {
        // alert('working!');
    var $book_id = $(this).closest("tr")   // Finds the closest row <tr> 
                       .find(".ir")     // Gets a descendent with class="nr"
                       .text();         // Retrieves the text within <td>

    var markup = "<tr><td class='selected_id'>"+$book_id+"</td><td><input type='text' id='quantity_"+$book_id+"' value='1' ></td><td><button id='delete-row' type='button' class='btn btn-xs btn-danger'><i class='fas fa-trash'></i></button></td></tr>";
    $("#selectedTable tbody").append(markup);
    });
    </script>

    <script>
        $('#selectedTable').on('click', '#delete-row', function() {
            $(this).closest('tr').remove();
        });
    </script>

    <script>

        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
        }        

        $('#selected_form').on('submit', function(e) {
            // remove qr content first
            $('#qr_content').empty();

            e.preventDefault();
            var url = $(this).attr('action');
            var post = $(this).attr('method');

            var table = $("#selectedTable tbody");
            var x = 0;
            var selectedData = [];
            var htmlData = '';

            table.find('tr').each(function (i) {
                var $tds = $(this).find('td'),
                    bookId = $tds.eq(0).text(),
                    bookQuantity = $tds.eq(1).find("input").val();
                
                selectedData[x++] = {
                    'id' : bookId,
                    'quantity' : bookQuantity
                };
                // console.log(bookId + ' ' + bookQuantity);
            });

            // console.log(selectedData);
            
            $.ajax({
                type: post,
                url: url,
                data: {
                    _token : $('meta[name="csrf-token"]').attr('content'), 
                    selectedData
                },
                dataTy: 'json',
                success: function(data) {
                    var dataLength = data.length;
                    for(var i = 0; i < dataLength; i++) {
                        var qrQuantity = data[i]['quantity'];
                        // console.log(data[i]['id']);
                        if(qrQuantity > 1){
                            for(var q = 0; q < qrQuantity; q++){
                                htmlData = "<div style='display: inline-block; font-family: 'Roboto', sans-serif; padding: 5px;'><img src='{{ asset('images/spcf-property.png') }}' width='300' style='border-bottom: 1px solid black; padding-bottom: 5px;margin-right:15px;'><ul class='list-inline'><div id='qr"+i+"_"+q+"' style='padding:13px 10px 40px 10px; float:left;'></div><div style='display:inline-block; margin-top:28px;'><strong>ID No: </strong>"+data[i]['id']+"<br><strong>Course: </strong> "+data[i]['course']+" <br> <strong>Year Published: </strong> "+data[i]['year_published']+"</div></ul></div>";   

                                $("#qr_content").append(htmlData);
                                new QRCode(document.getElementById("qr"+i+"_"+q), {
                                    text: data[i]['id'],
                                    width: 80,
                                    height: 80
                                });
                            }
                        } 
                        else {
                            htmlData = "<div style='display: inline-block; font-family: 'Roboto', sans-serif; padding: 5px;'><img src='{{ asset('images/spcf-property.png') }}' width='300' style='border-bottom: 1px solid black; padding-bottom: 5px;margin-right:15px;'><ul class='list-inline'><div id='qr"+i+"' style='padding:13px 10px 10px 10px; float:left;'></div><div style='display:inline-block; margin-top:28px;'><strong>ID No: </strong>"+data[i]['id']+"<br><strong>Course: </strong> "+data[i]['course']+" <br> <strong>Year Published: </strong> "+data[i]['year_published']+"</div></ul></div>";

                           

                            $("#qr_content").append(htmlData);
                            new QRCode(document.getElementById("qr"+i), {
                                text: '{ id : '+data[i]['id']+ ' }',
                                width: 80,
                                height: 80
                            });
                        }
                    }

                    $('#confirmModal').modal('show');

                    // printContent('qr_content');
                    // setTimeout(printContent('qr_content'), 10000);
                   
                    // console.log(data);
                    // $("#qr_content").append(htmlData);
                }
            });
        });/*INSERT MEMBER*/
    </script>

@endsection
