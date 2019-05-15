<p>All Threads</p>
  @forelse($threads as $thread)
   <div class="thread">
    <div class="thread-heading">
          <h2><a href="{{$thread->path()}}">
                      @if(auth()->check() && $thread->hasUpdatedFor(auth()->user()))
                          <strong>{{$thread->title}}</strong>
                      @else
                      {{$thread->title}}
                      @endif
                      </a></h2>
    </div>
    <span class="thread-creator small"><a href="{{route('profile',$thread->creator)}}">{{$thread->creator->name}}</a></span>
    <div class="thread-content">
        {!! $thread->body !!}
    </div>
    <div class="thread-info">
        <ul>
        <li><a href="/threads/{{$thread->channel->slug}}">{{$thread->channel->name}}</a></li>
        <li>{{$thread->visits}} Visits</li>
        <li>{{$thread->replies_count}} {{str_plural('reply',$thread->replies_count)}}</li>
        <li><a href="{{$thread->path()}}">read more</a></li>
        </ul>
    </div>
</div>
<div class="thread-border"></div>
@empty
    <h3 class="text-center">Sorry! There are no relevant results at this time</h3>
@endforelse