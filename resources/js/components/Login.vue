
   

<script>
export default{
    data(){
        return{
        form:{email:'',password:''},    
        feedback:''    
        }
    },
    methods:{
    login(){
    axios.post('/login',this.form)
        .then(()=>{
    location.reload();
    flash('You are Logging In...');
    
}).catch(error=>{
    this.feedback=error.response.data;
});
},
        register(){
        this.$modal.hide("login");
        this.$modal.show("register");
    }
}
}
</script>          