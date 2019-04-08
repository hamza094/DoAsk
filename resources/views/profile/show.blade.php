@extends('layouts.app')

@section('content')
<div class="container">
<div class="col-md-8">
<div class="jumbotron">
  <avatar-form :user="{{$profileUser}}"></avatar-form>
  <p>Since {{$profileUser->created_at->diffforHumans()}}</p>
    </div>
    <h3 class="text-center"><i>Activity Feed</i></h3>
      @foreach($activities as $date=>$activity)
    <h3 class="mt-5">{{$date}}</h3>
     <hr class="my-4">
     @foreach($activity as $record)
     @if(view()->exists("profile.activities.{$record->type}"))
    @include("profile.activities.{$record->type}",['activity'=>$record])
          @endif
           @endforeach
            @endforeach
    
    <div class="col-md-4">
        
    </div>
</div>
@endsection