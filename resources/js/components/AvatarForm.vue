<template>
    <div>
    <div class="row">
    <div class="col-md-3">
    <img :src="avatar" width="95" height="95" class="mt-3 profiles_avatar">
    </div>
    <div class="col-md-9 mt-4">
<h1> 
    {{user.name}}
    <i><small class="text-muted" v-text="user.username"></small></i>
</h1>
<form v-if="canUpdate"  method="POST" enctype="multipart/form-data" class="pt-1">
    <input type="file" name="avatar" accept="image/*" @change="onChange">
    </form>
    </div>
</div>
   
    </div>
</template>

<script>
    export default{
        props:['user'],
        data(){
            return{
                avatar:this.user.avatar_path
            };
        },
        computed:{
            canUpdate(){
            return this.authorize(user=>user.id===this.user.id)
            },
            reputation(){
                return this.user.reputation + "XP"
            }
        },
        methods:{
            onChange(e){
                if(! e.target.files.length) return;
                let file=e.target.files[0];
                let reader=new FileReader();
                reader.readAsDataURL(file);
                reader.onload=e=>{
                    this.avatar=e.target.result;  
                };
                this.persist(file);
            },
            persist(file){
                let data=new FormData();
                data.append('avatar',file);
                axios.post('/api/users/$(this.user.username)/avatar',data)
                .then(()=>flash('Avatar Uploaded!'));
            }
        }
    }
</script>