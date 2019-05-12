
   

<script>
export default{
    data(){
        return{
        form:{email:'',password:''},    
        feedback:'',
        loading:false
        }
    },
    methods:{
    login(){
    this.loading=true;
    axios.post('/login',this.form)
        .then(()=>{
    location.reload();
    flash('You are Logging In...');
    
}).catch(error=>{
    this.feedback=error.response.data;
    this.loading=false;
});
},
        register(){
        this.$modal.hide("login");
        this.$modal.show("register");
    }
}
}
</script>          