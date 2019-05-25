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
    <span class="thread-creator small">Posted By: <a href="{{route('profile',$thread->creator)}}">{{$thread->creator->username}}</a></span>
    <div class="thread-content">
        {!! str_limit($thread->body,200) !!}
    </div>
    <div class="thread-info">
        <ul>
        <li class="thread-info_name"><a href="/threads/{{$thread->channel->slug}}"> <span
        style="background-color:{{$thread->channel->color}};
        width: 1rem;
        height: 1rem;
        margin-right: .9rem;
        border-radius: 50%;
        display: inline-block;">
        </span>{{$thread->channel->name}}</a></li>
        <li class="thread-info_visits"><i class="fas fa-eye"></i> {{$thread->visits}} Visits</li>
        <li class="thread-info_count"><i class="fas fa-comment-dots"></i> {{$thread->replies_count}} {{str_plural('reply',$thread->replies_count)}}</li>
        <li class="thread-info_read"><a href="{{$thread->path()}}">read more</a></li>
        </ul>
    </div>
</div>
<div class="thread-border"></div>
@empty
    <h3 class="text-center">Sorry! There are no relevant results at this time</h3>
@endforelse