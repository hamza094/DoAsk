
<login inline-template>
   <modal name="login">
   <div class="form">
    <form action="" @submit.prevent="login">
       <div class="form-group">
        <label for="Email" class="label text-muted">Email</label>
        <input type="email" name="email" id="email" class="form-control" autocomplete="email" v-model="form.email" required>
        </div>
        <div class="form-group">
        <label for="Password" class="label text-muted">Password</label>
        <input type="password" name="pasword" id="password" class="form-control" v-model="form.password" autocomplete="current-password" required>
        </div>
       <div class="form-group">
        
        <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
          <label class="form-check-label text-muted check" for="remember">
            {{ __('Remember Me') }}
        </label>
        </div>
        </div>
       <div class="form-btn">
       <a href="#" class="btn btn-lg btn-link text-gray float-right" @click="register">or register</a>
        <button class="btn btn-success btn-lg float-right" :class="loading ? 'loader': '' ">Login</button>
         @if (Route::has('password.request'))
                                    <a class="btn btn-link float-left" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
        </div>
        <div v-if="feedback">
            <span class="text-danger" v-text="feedback"></span>
        </div>
    </form>
       </div>
</modal>
</login>

