@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
 @include('threads.breadcrumbs')
<div class="single-thread">
<thread-view :thread="{{$thread}}" inline-template>
    <div  v-cloak>
       @include('threads._discussion')
         <div class="single-thread_replies">
          @if($thread->best_reply_id!=null)
           <div class="single-thread_replies_best">
                         <span class="single-thread_avatar"><img src="{{$thread->reply->owner->avatar_path}}" alt=""></span> 
                          <a href="{{route('profile',$thread->reply->owner)}}">{{$thread->reply->owner->username}} 
                              (<small>{{ $thread->reply->owner->reputation }} XP</small>)</a> <small>{{$thread->reply->created_at->diffForHumans(null, true)}}</small> <span class="float-right single-thread_replies_best_content">Best Answer</span>
                          <p>{!! $thread->reply->body !!}</p>
               
                </div>
          
          
          @endif
          @if(Auth::check() && auth()->user()->email_verified_at==null)
           @include('threads.singlereply')
           <br>
            <p class="text-center">Please <a href="/home">Verify</a> your account to participate in discussion</p>
          @else
             <replies
          @added="repliesCount++"
           @removed="repliesCount--">
           </replies> 
           @endif
               <br>
        </div>
          </div>
 </thread-view>
</div>
@endsection