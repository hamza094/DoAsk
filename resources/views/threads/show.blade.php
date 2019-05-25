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
          <h3 class="text-center mt-4">Thread Replies</h3>
          @if($thread->best_reply_id!=null)
          <p>{!! $thread->reply->body !!}</p>
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
 </thread-view>
</div>
@endsection