<div class="card" v-if="editing">
    <div class="card-header">
            <input type="text" class="form-control" v-model="form.title">
    </div>
    
 <div class="card-body">
       <div class="form-group">
           <wysiwyg v-model="form.body" :value="form.body"></wysiwyg>
           <!--<textarea cols="30" rows="5" class="form-control" v-model="form.body"></textarea>-->
       </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-sm btn-primary" @click="Update">Update</button>
        <button class="btn btn-sm btn-link" @click="cancel">Cancel</button>
          @can('update',$thread)
        <form action="{{$thread->path()}}" method="post" class="float-right">
            {{csrf_field()}} {{method_field('DELETE')}}
            <button type="submit" class="btn btn-danger btn-sm">Delete Thread</button>
        </form>
        @endcan
    </div>
</div>


<div v-else>
    
    <div class="row no-gutters">
    <div class="col-md-1 col-sm-1 left-content">
        <span class="single-thread_avatar"><img src="{{$thread->creator->avatar_path}}" alt=""></span> 
        </div>    
        <div class="col-md-11 col-sm-11">
        <div class="right-content">
    <span class="single-thread_title" v-text="this.form.title"></span>
    <div class="single-thread_links">
        <ul>
            <li>Posted by: <a href="{{route('profile',$thread->creator)}}">{{$thread->creator->username}} (<small>{{ $thread->creator->reputation }} XP </small>)</a></li>
        <li v-if="authorize('updateThread',thread)">
        <button class="btn btn-sm btn-primary" @click="editing=true">Edit</button>
        </li>
          @if(auth()->check())
        @if(auth()->user()->email_verified_at!==null)
        <li>
         <button class="btn btn-primary" v-if="authorize('isAdmin')" @click="tooglePinned" v-text="pinned ? 'UnPinned' : 'Pinned' ">Lock</button>
        </li>
        <li><subscribe :active="{{json_encode($thread->isSubscribedTo)}}" v-if="!locked"></subscribe></li>
        <li> <button class="btn btn-primary" v-if="authorize('isAdmin')" @click="toogleLock" v-text="locked ? 'Unlock' : 'lock' ">Lock</button></li>
        @endif
        @endif
        </ul>
    </div> 
        <article class="single-thread_content">
            <div class="body"><span ref="thread-body" v-html="this.form.body"></span></div>
        </article>
    </div>
        </div>
    </div>
    </div>
