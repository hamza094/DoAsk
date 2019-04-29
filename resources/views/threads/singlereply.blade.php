   @foreach($thread->replies as $reply)
           <br>
            <div class="card">
                <div class="card-header">
                <a href="/profiles/{{$reply->owner->name}}">{{$reply->owner->name}}</a>
                <span class="float-right">{{$reply->favorites->count()}} likes</span>
                </div>
                <div class="card-body">
                 <p>{!! $reply->body !!}</p>
                   </div>
                   <div class="card-footer">{{$reply->created_at->diffForHumans()}}</div>
            
            </div>
@endforeach