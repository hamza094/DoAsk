<br>
           <reply :attributes="{{$reply}}" inline-template v-cloak>
            <div class="card" id="reply-{{$reply->id}}">
                <div class="card-header"><a href="{{route('profile',$reply->owner)}}">{{$reply->owner->name}}</a> said {{$reply->created_at->diffForHumans()}}
                @if(auth()->check())
                <favorite :reply="{{$reply}}"></favorite>
                    @endif
                </div>
                <div class="card-body">
                   <div v-if="editing">
                      <div class="form-group">
                       <textarea v-model="body" class="form-control"></textarea>
                       </div>
                       <button class="btn btn-sm btn-primary" @click="update">Update</button>
                       <button class="btn btn-sm btn-link" @click="editing=false">Cancel</button>
                       </div>
                   <div v-else v-text="body">
                       
                   </div>
                     </div>
                  @can('update',$reply)
             <div class="card-footer level">
                <button class="btn btn-sm btn-secondary mr-1" @click="editing=true">Edit</button>
                <button class="btn btn-sm btn-danger" @click="destroy">Delete</button>
                </div>
             @endcan
            </div>
</reply>