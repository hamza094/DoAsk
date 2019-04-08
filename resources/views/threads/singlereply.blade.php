   @foreach($thread->replies as $reply)
            <div class="card">
                <div class="card-header">
                <a href="">{{$reply->owner->name}}</a>
                <span class="float-right">{{$reply->favorites->count()}} likes</span>
                </div>
                <div class="card-body">
                 <p>{{$reply->body}}</p>
                   </div>
                   <div class="card-footer">{{$reply->created_at->diffForHumans()}}</div>
            
            </div>
@endforeach