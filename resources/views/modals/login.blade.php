<login inline-template>
   <modal name="login">
    <form action="" class="p-5" @submit.prevent="login">
       <div class="form-group">
        <label for="Email" class="text-uppercase font-weight-bold text-sm mb-1 text-muted label">Email</label>
        <input type="email" name="email" id="email" class="form-control" autocomplete="email" v-model="form.email" required>
        </div>
        <div class="form-group mt-3">
        <label for="Password" class="text-uppercase font-weight-bold text-sm mb-1 text-muted label">Password</label>
        <input type="password" name="pasword" id="password" class="form-control" v-model="form.password" autocomplete="current-password" required>
        </div>
        <div class="mt-3">
        <button class="btn btn-success btn-lg">Login</button>
        <a href="#" class="btn btn-lg btn-link text-gray" @click="register">or register</a>
        </div>
        <div v-if="feedback">
            <span class="text-danger" v-text="feedback"></span>
        </div>
    </form>
</modal>
</login>

