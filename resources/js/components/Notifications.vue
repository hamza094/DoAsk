<template>

<li class="nav-item dropdown">
 <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
   <i class="fas fa-bell"></i><span class="notification" v-if="notifications.length"></span>
    </a>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
<li v-for="notification in notifications" :key="notification.id" v-if="notifications.length">
    <a class="dropdown-item" :href="notification.data.link"  @click.prevent="markAsRead(notification)">
      <img :src="notification.data.notifier.avatar_path"
   :alt="notification.data.notifier.username">
   <span v-html="notification.data.message"></span>
    </a>
</li>
<li v-if="!notifications.length" class="dropdown-item">
    You have zero notifications
</li>

</div>
</li>

</template>
<script>
    export default {
        data(){
        return{
            notifications:false
        }
        },
            created(){
             this.fetchNotifications();
        },
          computed: {
            endpoint() {
                return `/profiles/${window.App.user.username}/notifications`;
            }
        },
        methods:{
               fetchNotifications() {
                axios.get('/profiles/' + window.App.user.name + '/notifications')
                  .then(response => this.notifications = response.data);
            },
            markAsRead(notification){
                axios.delete("/profiles/"+window.App.user.username+"/notifications/"+notification.id)
                .then(response => {
                    this.fetchNotifications();
                    document.location.replace(response.data.link);
                });
            }
        }
    }
    
</script>