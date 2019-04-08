@forelse($threads as $thread)
            <div class="card">
                <div class="card-header">Posted By: <a href="{{route('profile',$thread->creator)}}">{{$thread->creator->name}}</a> 
                 <span class="badge badge-primary float-right"><b>{{$thread->replies_count}} {{str_plural('reply',$thread->replies_count)}}</b></span>
                </div>
                <div class="card-body">                  
                  <article>
                      <h4><a href="{{$thread->path()}}">
                      @if(auth()->check() && $thread->hasUpdatedFor(auth()->user()))
                          <strong>{{$thread->title}}</strong>
                      @else
                      {{$thread->title}}
                      @endif
                      </a></h4>
                      <p>{!! $thread->body !!}</p>                      
                  </article>                                    
                </div>
                <div class="card-footer">
                    {{$thread->visits}} Visits
                </div>                
            </div>
            <hr>
            @empty
            <h3 class="text-center">Sorry! There are no relevant results at this time</h3>
            @endforelse