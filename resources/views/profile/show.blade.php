@extends('layouts.app')

@section('content')
<div class="profiles_background">
  <avatar-form :user="{{$profileUser}}"></avatar-form>
  <p>Since {{$profileUser->created_at->diffforHumans()}}</p>
  <div class="container">
  <div class="row text-center">
      <div class="col-md-3 bg-white users">
             <i class="fas fa-trophy"></i>
             <br>
             <span class="users_count">{{$profileUser->reputation}} Xp</span>
             <br>
             <span class="users_info">Reputation</span>
          </div>
          <div class="col-md-3 bg-white users">
         <i class="fas fa-comment-dots"></i>
          <br>
              <span class="users_count">{{$profileUser->replies->count()}}</span>
          <br>
          <span class="users_info">Replies</span>
      </div>
      <div class="col-md-3 bg-white users">
      <i class="fas fa-paste"></i>
          <br>
          <span class="users_count">{{$profileUser->threads->count()}}</span>
          <br>
          <span class="users_info">Threads</span>
      </div>
     </div>
    </div>
   <button class="btn btn-link btn-lg mt-3"  @click="$modal.show('profile')">Edit Profile</button>
    </div>
<div class="profiles">
    <h3 class="text-center"><i>Activity Feed</i></h3>
    <div class="activity">
      @foreach($activities as $date=>$activity)
       <div class="mt-5">
        <span class="activity_menu"></span>
    <h3 >{{$date}}</h3>
        </div>
     
     @foreach($activity as $record)
     @if(view()->exists("profile.activities.{$record->type}"))
    @include("profile.activities.{$record->type}",['activity'=>$record])
          @endif
           @endforeach
           
            @endforeach
    </div>
</div>
    
@endsection