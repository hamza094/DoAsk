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


<div class="card" v-else>
    <div class="card-header"><span v-text="this.form.title"></span> 
    </div>
 <div class="card-body">
        <article>
            <div class="body"><span v-html="this.form.body"></span></div>
        </article>
    </div>
    <div class="card-footer" v-if="authorize('updateThread',thread)">
        <button class="btn btn-sm btn-primary" @click="editing=true">Edit</button>
    </div>
</div>