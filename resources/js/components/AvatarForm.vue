<template>
    <div>
    <img :src="avatar" width="75" height="75" class="mt-3 rounded">

<h1> 
    {{user.name}}
    (<small class="text-muted" v-text="user.username"></small>)
</h1>
<span>Points: <b>{{user.reputation}}XP</b></span>
<br><br>
<form v-if="canUpdate"  method="POST" enctype="multipart/form-data">
    <input type="file" name="avatar" accept="image/*" @change="onChange">
    </form>

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