<template>
    
            <div  :id="'reply-'+id" :class="isBest ? 'single-thread_replies_best': ''">
               <div>
                         <span class="single-thread_avatar"><img src="/storage/avatars/default.png" alt=""></span> 
                         <div v-if="signedIn">
                <favorite :reply="data" class="float-right"></favorite>
                    </div>
                          <a :href="'/profiles/'+data.owner.username"
                     v-text="data.owner.username" :class="isBest ? '': 'text-default'">
                         </a> said <span v-text="ago"></span>
                 </div>
                <div >
                   <div v-if="editing">
                     <form @submit="update">
                      <div class="form-group">
                          <wysiwyg v-model="body"></wysiwyg>
                       <!--<textarea v-model="body" class="form-control" required></textarea>-->
                       </div>
                       <button class="btn btn-sm btn-primary single-thread_btn ">Update</button>
                       <button class="btn btn-sm btn-link single-thread_btn" @click="remainTheSame" type="button">Cancel</button>
                       </form>
                       </div>
                   <div ref="data-body" v-else v-html="body">
                       
                   </div>
                     </div>
                 <div class="level" v-if="authorize('updateReply',reply) || authorize('updateThread',reply.thread)">
             <div  v-if="authorize('updateReply',reply)">
                 <button class="btn btn-sm btn-primary mr-1 " v-if="!editing" @click="editing=true"><i class="far fa-edit"></i></button>
                <button class="btn btn-sm btn-danger " @click="destroy"><i class="far fa-trash-alt"></i></button>
                </div>
                     <button class="btn btn-sm btn-light single-thread_btn" @click="markBestReply" v-if="authorize('updateThread',reply.thread) && !isBest"><b>Best Reply?</b></button>
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
                isVisible:false,
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