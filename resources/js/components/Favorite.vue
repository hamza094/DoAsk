<template>
    <button type="submit" :class="classes" class="float-right" @click="toggle">
    <span class="glyphicon glyphicon-heart"></span>
    <span v-text="favoriteCount"></span>
    </button>
</template>
   <script>
    export default {
        props:['reply'],
         data(){
             return{
                favoriteCount:this.reply.favoritesCount,
                 isFavorited:this.reply.isFavorited
             }
         },
        computed:{
          classes(){
              return['btn',this.isFavorited ? 'btn-success': 'btn-primary'];
          }
        },
        methods:{
            toggle(){
                if(this.isFavorited){
               this.destroy();
                }else{
                this.create();       
                }
            },
            destroy(){
                 axios.get('/replies/'+this.reply.id+'/unfavorites');
                    this.isFavorited = false;
                    this.favoriteCount--;
            },
            create(){
                axios.get('/replies/'+this.reply.id+'/favorites');
                    this.isFavorited = true;
                    this.favoriteCount++;
            }
        }
    }
</script>