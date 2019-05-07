<template>
    
            <div class="card" :id="'reply-'+id">
               <div class="card-header" :class="isBest ? ' bg-success': 'bg-default'">
                          <a :href="'/profiles/'+data.owner.username"
                     v-text="data.owner.username" :class="isBest ? 'text-white': 'text-default'">
                         </a> said <span v-text="ago"></span>
               <div v-if="signedIn">
                <favorite :reply="data"></favorite>
                    </div>
                </div>
                <div class="card-body">
                   <div v-if="editing">
                     <form @submit="update">
                      <div class="form-group"  v-if="authorize('verfiedUser',reply)">
                          <wysiwyg v-model="body"></wysiwyg>
                       <!--<textarea v-model="body" class="form-control" required></textarea>-->
                       </div>
                       <button class="btn btn-sm btn-primary">Update</button>
                       <button class="btn btn-sm btn-link" @click="remainTheSame" type="button">Cancel</button>
                       </form>
                       </div>
                   <div ref="data-body" v-else v-html="body">
                       
                   </div>
                     </div>
                 <div class="card-footer level" v-if="authorize('updateReply',reply) || authorize('updateThread',reply.thread)">
             <div  v-if="authorize('updateReply',reply)">
                <button class="btn btn-sm btn-secondary mr-1" @click="editing=true">Edit</button>
                <button class="btn btn-sm btn-danger" @click="destroy">Delete</button>
                </div>
                <button class="btn btn-sm btn-light" @click="markBestReply" v-if="authorize('updateThread',reply.thread)">Best Reply?</button>
                </div>
             
            </div>
            
</template>
   <script>
    
    import Favorite from './Favorite.vue';
    import moment from 'moment';   
    
    export default {
        props: ['data'],
        components:{Favorite},
        data() {
            return {
                editing: false,
                id:this.data.id,
                body: this.data.body,
                isBest:this.data.isBest,
                reply:this.data
            };
        },
        computed:{
            ago(){
              return moment(this.data.created_at).fromNow()+'...';  
                
            },
       },
        created(){
          window.events.$on('best-reply-selected',id=>{
              this.isBest=(id===this.id);
          });  
        },
          mounted(){
            this.highlight(this.$refs['data-body']);
        },
        watch:{
            editing(){
                if(!this.editing){
                    this.$nextTick(()=>{
                       this.highlight(this.$refs['data-body']);
                    });
                }
            }
        },
        methods:{
            update(){
                axios.patch('/replies/'+this.data.id,{
                    body:this.body
                })
                .catch(error=>{
                   flash(error.response.data,'danger'); 
                });
                this.editing=false;
                flash('Updated!');
            },
            destroy(){
                axios.delete('/replies/'+this.data.id);
              this.$emit('deleted',this.data.id);
            },
            markBestReply(){
                axios.post('/replies/'+this.data.id+'/best');
                 window.events.$emit('best-reply-selected',this.data.id);
            },
            remainTheSame(){
                this.editing = false;
            this.body = this.data.body;
            }
        }


    }
</script>