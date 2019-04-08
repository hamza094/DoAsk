@component('profile.activities.activity')
 @slot('heading')
<b>{{$profileUser->name}}</b> favorited a <a href="{{$activity->subject->favorited->path()}}">reply</a>
     @endslot
      @slot('body')

    {{$activity->subject->favorited->body}}

@endslot
 @endcomponent