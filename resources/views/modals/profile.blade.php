   <modal name="profile" height="auto">
   <div class="form">
       <form action="{{route('profiles.update',['user'=>auth()->user()->id])}}" method="post">
        {{ csrf_field() }}
        {{method_field('PATCH')}}
       <div class="form-group">
        <label for="name" class="label text-muted">Name</label>
        <input type="text" name="name" id="name" class="form-control" autocomplete="name"  value="{{auth()->user()->name}}" required>
         
        </div>
        
        <div class="form-group">
        <label for="username" class="label text-muted">Userame</label>
        <input type="text" name="username" id="username" class="form-control" autocomplete="username" value="{{auth()->user()->username}}" required>
        
        </div>
        
        <div class="form-group">
        <label for="email" class="label text-muted">Email</label>
        <input type="Email" name="email" id="email" class="form-control" autocomplete="email"  value="{{auth()->user()->email}}" required>
        </div>
         <div class="form-group">
                <label for="password" class="label text-muted">New Password:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password">
            </div>
          <div class="form-btn">
               <button class="btn btn-primary btn-lg float-right" type="submit">Update</button>
        </div>
    </form>
       </div>
             @if($errors->count()>0)
           <ul class="alert alert-danger">
             @foreach($errors->all() as $error)
            <li>{{$error}}</li>
             @endforeach
          </ul>
    
    @endif
</modal>



