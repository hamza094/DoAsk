<template>
       
      <div class="new-reply">
          <div v-if="signedIn"> 
              
              <div class="form-group">
                  <wysiwyg  name="body" v-model="body" placeholder="Have something to say?" :shouldClear="completed"></wysiwyg>
                  <!--<textarea name="body"
                    id="body"
                    rows="5"
                    class="form-control"
                    required    
                    placeholder="Have something to say?"
                    v-model="body"></textarea>-->
              </div>
              <button type="submit"
               class="btn btn-primary"
               @click="addReply">Post</button>
    
    </div>
    
    <p class="text-center" v-else>Please <a href="/login">signin</a> to participate in a discussion</p>
    </div>
</template>
<script>
   
    
export default {
       data(){
        return{
        body:'',
        completed:false    
        };
    },
       mounted() {
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function(query, callback) {
                     $.getJSON("/api/users", {name: query}, function(usernames) {
                            callback(usernames)
                        });
                    }
                }
            });
        },
    methods:{
        addReply(){
            axios.post(location.pathname+'/replies',{body:this.body})
            .catch(error=>{
                flash(error.response.data,'danger');
            })
             .then(({data})=>{
                 this.body='';
                this.completed=true;
                 flash('Your reply has been posted.');
                 this.$emit('created',data);
             });
        }
    }
}
</script>
<style scoped>
    .new-reply{
        padding: 15px;
        background-color: #fff;
        border:1px solid #e3e3e3;
    }
</style>