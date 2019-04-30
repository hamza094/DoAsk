let user=window.App.user;
module.exports={
    updateReply(reply){
        return reply.user_id === user.id;
    },
     updateThread(thread){
        return thread.user_id === user.id;
    },
    isAdmin(){
        return user.isAdmin;
    },
     verfiedUser(user){
        return user.email_verified_at.length == 0;
    },
};

