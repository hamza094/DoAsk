<script>
export default{
    data(){
        return{
        form:{email:'',password:'',name:'',username:'',password_confirmation:''},    
        feedback:'',
         errors: {}    
        }
    },
    methods:{
    register(){
    axios.post('/register',this.form)
        .then(()=>{
   location.reload();
    flash('Registering Your Account...');
    
}).catch(error=>{
    this.feedback=error.response.data;
});
}

}
}
</script>   