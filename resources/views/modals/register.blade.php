   <register inline-template>
   <modal name="register" height="auto">
   <div class="form">
    <form action="" @submit.prevent="register">
       <div class="form-group">
        <label for="name" class="label text-muted">Name</label>
        <input type="name" name="name" id="name" class="form-control" autocomplete="name" v-model="form.name" value="{{old('name')}}" required
        @keydown="errors.name = false">
         <span v-if="errors.name" v-text="errors.name[0]" class="text-danger"></span>
        </div>
        
        <div class="form-group">
        <label for="username" class="label text-muted">Userame</label>
        <input type="username" name="username" id="username" class="form-control" autocomplete="username" v-model="form.username" value="{{old('username')}}" required
        @keydown="errors.username = false">
         <span v-if="errors.username" v-text="errors.username[0]" class="text-danger"></span>
        </div>
        
        <div class="form-group">
        <label for="email" class="label text-muted">Email</label>
        <input type="Email" name="email" id="email" class="form-control" autocomplete="email" v-model="form.email" value="{{old('email')}}" required
        @keydown="errors.email = false">
         <span v-if="errors.email" v-text="errors.email[0]" class="text-danger"></span>
        </div>
        
        <div class="form-group">
        <label for="Password" class="label text-muted">Password</label>
        <input type="password" name="pasword" id="password" class="form-control" v-model="form.password" autocomplete="new-password" required @keydown="errors.password = false">
        <span v-if="errors.password" v-text="errors.password[0]" class="text-danger"></span>
        </div>
        
         <div class="form-group">
        <label for="ConfirmPassword" class="label text-muted">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" v-model="form.password_confirmation" autocomplete="new-password" required @keydown="errors.password = false">
        </div>
        <div class="form-btn">
        <button class="btn btn-success btn-lg float-right" :class="loading ? 'loader': '' ">Register</button>
        </div>
        <div v-if="feedback">
            <span class="text-danger" v-text="feedback"></span>
        </div>
    </form>
       </div>
</modal>
</register>
