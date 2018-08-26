@extends('layouts.landing-app')

@section('content')

<span class="top-book">Newly Added</span>

<div class="test">

  @if(isset($books))
      @foreach($books as $row)
          <div class="card-container" data-toggle="modal" data-target="#bookModal{{$row->id}}">
            <div class="blog-card spring-fever" style="background: url({{ asset('landing-img/book-cover.png') }}) no-repeat;">
              <div class="title-content">
                <h3>{{$row->title}}</h3>
                <hr />
                <div class="intro">{{$row->course}}</div>
              </div><!-- /.title-content -->
              <div class="card-info">
                {{$row->author}}
              </div><!-- /.card-info -->
              <div class="utility-info">
                <ul class="utility-list">
                  <!-- <li class="comments">12</li> -->
                  <li class="date">{{$row->year_published}}</li>
                </ul>
              </div><!-- /.utility-info -->
              <!-- overlays -->
              <div class="gradient-overlay"></div>
              <div class="color-overlay"></div>
            </div><!-- /.blog-card -->
          </div>

          <!-- Button trigger modal -->
          <!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
            Launch demo modal
          </button> -->

          <!-- Modal -->
          <div class="modal fade" id="bookModal{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                  <!-- <dl>
                    <dt>Title</dt>
                    <dd>{{$row->title}}</dd>
                  
                    <dt>Author</dt>
                    <dd>{{$row->author}}</dd>
                  
                    <dt>Course</dt>
                    <dd>{{$row->course}}</dd>
                  
                    <dt>Year Published</dt>
                    <dd>{{$row->year_published}}</dd>
                  
                    <dt>Available</dt>
                    <dd><i class="fas fa-check"></i></dd>
                  
                    <dt>CD</dt>
                    <dd><i class="fas fa-check"></i></dd>
                  </dl> -->
                  <div class="modal-body-content">
                    <p class="header">Title</p>
                    <p class="info">{{$row->title}}</p>

                    <p class="header m-t-25">Author</p>
                    <p class="info">{{$row->author}}</p>

                    <p class="header m-t-25">Course</p>
                    <p class="info">{{$row->course}}</p>

                    <p class="header m-t-25">Year Published</p>
                    <p class="info">{{$row->year_published}}</p>

                    <p class="header m-t-25">Available</p>
                    <p class="info" style="color: green;"><i class="fas fa-check"></i></p>

                    <p class="header m-t-25">CD</p>
                    <p class="info" style="color: green;"><i class="fas fa-check"></i></p>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
              </div>
            </div>
          </div>
      @endforeach

  <hr size="20" class="hr-gradient">

  {{-- {!! $books->render() !!} --}}
  {{ $books->links() }}
  @endif

</div>

@endsection