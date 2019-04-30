<script>
    import Replies from '../components/Replies.vue';
    import Subscribe from '../components/Subscribe.vue';
    export default{
            props:['thread'],
            components:{Replies,Subscribe},
        data(){
        return{
        repliesCount:this.thread.replies_count,
        locked:this.thread.locked,
        pinned:this.thread.pinned,    
        editing:false,
        form:{
            title:this.thread.title,
            body:this.thread.body
        }    
        };
        },
        mounted(){
            this.highlight(this.$refs['thread-body']);
        },
        watch:{
            editing(){
                if(!this.editing){
                    this.$nextTick(()=>{
                       this.highlight(this.$refs['thread-body']);
                    });
                }
            }
        },
        methods:{
            toogleLock(){
                axios[(this.locked ? 'delete' : 'post')]('/locked-threads/'+this.thread.slug);
                this.locked= ! this.locked;
            },
            tooglePinned(){
                 axios[(this.pinned ? 'delete' : 'post')]('/pinned-threads/'+this.thread.slug);
                this.pinned= ! this.pinned;
            },
            Update(){
                axios.patch('/threads/'+this.thread.channel.slug+'/'+this.thread.slug,{
                    title:this.form.title,
                    body:this.form.body
                }).then(()=>{
                    this.editing=false;
                    flash('Thread Updated Successfully');
                });
            },
            cancel(){
                this.form={
                    title:this.thread.title,
                    body:this.thread.body
                };
                this.editing=false;
            }
        }
    }
</script>