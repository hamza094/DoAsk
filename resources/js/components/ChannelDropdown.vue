<template>
       <li class="nav-item dropdown">
        <a href="#" id="navbarDropdown" class="nav-link dropdown-toggle"  @click.prevent="toggle= !toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
        Channels <span class="caret"></span>
        </a>
        
        <div class="dropdown-menu dropdown-menu-right channel-dropdown" aria-labelledby="navbarDropdown" v-show="toggle">
        <div class="input-wrapper">
                <input type="text" class="form-control" v-model="filter" placeholder="Filter Channels..."/>
            </div>
            <ul class="list-group channel-list">
                <li class="list-group-item" v-for="channel in filterThreads">
                    <a :href="`/threads/${channel.slug}`" v-text="channel.name"></a>
                </li>
            </ul>
    </div>
    </li>
</template>
<style lang="scss">
 .channel-dropdown{
        padding:0;
    }
    .input-wrapper{
        padding:.5rem 1rem;
    }
    .channel-list{
        max-height: 400px; overflow:auto;
        margin-bottom:0;
        .list-group-item{
            border-radius:0;
            border-left: none;
            border-right: none;
        }
    }
</style>

<script>
    export default {
        props:['channels'],
       data(){
         return{
             toggle:false,
             filter:''
         }  
       },
        computed:{
            filterThreads(){
                return this.channels.filter(channel =>{
                    return channel.name.toLowerCase().startsWith(this.filter.toLowerCase())
                })
            }
        }
    }
</script>


