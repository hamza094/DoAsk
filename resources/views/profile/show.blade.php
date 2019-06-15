@extends('layouts.app')

@section('content')
<div class="profiles">
<div class="jumbotron">
  <avatar-form :user="{{$profileUser}}"></avatar-form>
  <p>Since {{$profileUser->created_at->diffforHumans()}}</p>
   <button class="btn btn-primary"  @click="$modal.show('profile')">Update</button>
    </div>
    <h3 class="text-center"><i>Activity Feed</i></h3>
     <div class="activity">
      @foreach($activities as $date=>$activity)
    <h3 class="mt-5">{{$date}}</h3>
     <hr class="my-4">
     @foreach($activity as $record)
     @if(view()->exists("profile.activities.{$record->type}"))
    @include("profile.activities.{$record->type}",['activity'=>$record])
          @endif
           @endforeach
            @endforeach
            </div>
</div>
    
@endsection