@component('profile.activities.activity') @slot('heading')
<b>{{$profileUser->name}}</b> published <a href="{{$activity->subject->path()}}">"{{$activity->subject->title}}"</a> @endslot @slot('body')

    {{$activity->subject->body}}

@endslot @endcomponent