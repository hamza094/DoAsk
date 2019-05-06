@component('profile.activities.activity') @slot('heading')
<b>{{$profileUser->name}}</b> replied to a <a href="{{$activity->subject->thread->path()}}">"{{$activity->subject->thread->title}}"</a> @endslot @slot('body')

    {!!$activity->subject->body!!}
<p>XP:{{$activity->subject->xp}}</p>
@endslot @endcomponent
