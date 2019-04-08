<template>
   <div>
    <div v-for="(reply,index) in items" :key=reply.id>
       <br>
        <reply :data="reply" @deleted="remove(index)"></reply>
    </div>
    <br>
    <paginator :dataSet="dataSet" @changed="fetch"></paginator>
    <h4 class="text-center" v-if="$parent.locked">
        This Thread has been locked no more subscription or replies are allowed
    </h4>
    <new-reply @created="add" v-else="! $parent.locked"></new-reply>
    </div>
</template>


<script>
    import Reply from './Reply.vue';
     import NewReply from './NewReply.vue';
    import collection from '../mixins/collection';
       export default {
        components:{Reply,NewReply},  
        mixins:[collection],   
        data(){
            return{
                dataSet:false
            }
        },
        created(){
               this.fetch();
           },
           methods:{
           fetch(page){
           axios.get(this.url(page))
               .then(this.refresh);
            },
            url(page){
                if(!page){
                    let query = location.search.match(/page=(\d+)/);
                    page=query ? query[1] : 1;
                }
                return `${location.pathname}/replies?page=${page}`;
            },   
               refresh({data}){
                   this.dataSet=data;
                   this.items=data.data;
                   
                   window.scrollTo(0,0);
               }
         
           }


    }

</script>