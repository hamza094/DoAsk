@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           @include('threads._list')
           {{$threads->render()}}
        </div>
        <div class="col-md-4">
          <div class="card">
              <div class="card-header">
                  Search Threads
              </div>
              <div class="card-body">
                 <form action="/threads/search" method="get">
                  <div class="form-group">
                      <input type="text" name="q" class="form-control" placeholder="Search for something...">
                  </div>
                  <button type="submit" class="btn btn-primary">Search</button>
                  </form>
              </div>
              <button class="btn btn-success btn-sm">Login</button>
              <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Dropdown button
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <a class="dropdown-item" href="#">Something else here</a>
  </div>
</div>
          </div>
          <hr>
           @if(count($trending ))
            <div class="card">
                <div class="card-header">
                    Trending Threads
                </div>
                <div class="card-body">
                   <ul class="list-group">
                    @foreach($trending as $thread)
                    <li class="list-group-item">
                        <a href="{{url($thread->path)}}">{{$thread->title}}</a>
                    </li>
                    @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection