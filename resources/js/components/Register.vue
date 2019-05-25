<script>
export default{
    data(){
        return{
        form:{email:'',password:'',name:'',username:'',password_confirmation:''},    
        feedback:'',
        loading:false,
         errors: {}    
        }
    },
    methods:{
    register(){
    this.loading=true;
    axios.post('/register',this.form)
        .then(()=>{
   location.reload();
    flash('Registering Your Account...');
        
}).catch(error=>{
    this.feedback=error.response.data;
    this.loading=false;
});
}

}
}
</script>   