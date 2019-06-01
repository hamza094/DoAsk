<template>
   <div>
    <button type="submit" class="btn fav"  @click="toggle">
    <i class="fas" :class="classes"></i>
     </button>
    
        <span v-text="favoriteCount" class="fav-count" ></span>
        </div>
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
              return['fa-heart',this.isFavorited ? 'favorite': 'unfavorite'];
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