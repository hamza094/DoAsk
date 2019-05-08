@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       <div class="col-md-3 padding-0">
          <div class="right-panel">
           hy there
           </div>
       </div>
        <div class="col-md-7 padding-0">
           @include('threads._list')
           {{$threads->render()}}
        </div>
        <div class="col-md-2 padding-0">
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