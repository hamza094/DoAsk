<template>
   
       <div class="container">
      <div class="row">
          <div class="col-md-10">
              <div class="card">
                  <div class="card-header">
                      <span>All Channels</span>
                      <span class="btn btn-primary btn-sm float-right" @click="newModal">Add Channel +</span>
                  </div>
                  <div class="card-body">
                      <table class="table table-hover">
  <thead>
    <tr>
      <th>Sr.No</th>
      <th>Name</th>
      <th>Threads</th>
      <th>Color</th>
      <th>Created_at</th>
      <th>Action</th>
      <th>Status</th>
      
    </tr>
  </thead>
  <tbody>
     <tr v-for="channel in channels.data" :key="channel.id">
      
       <td>{{channel.id}}</td>
       <td>{{channel.name | upText}}</td>
       <td>{{channel.threads_count}}</td>
       <td>{{channel.color}}</td>
       <td>{{channel.created_at | myDate}}</td>
       <td>
        <button class="btn btn-sm btn-link" @click="editModal(channel)">Edit</button>
       <a href="#" class="btn btn-sm btn-danger" @click="destroy(channel.id)">Delete</a>
       </td>
         <td v-if="!channel.archived" class="badge badge-success">Active</td>
         <td v-if="channel.archived" class="badge badge-warning">Archived</td>
    </tr>
  </tbody>
    </table>
                  </div>
                  <div class="card-footer">
                      <pagination :data="channels" @pagination-change-page="getResults"></pagination>
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              
          </div>
      </div>
<div class="modal fade" id="AddChannel" tabindex="-1" role="dialog" aria-labelledby="AddChannelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddChannel" v-show=!editing>Create New Channel</h5>
        <h5 class="modal-title" id="AddChannel" v-show=editing>Update Channel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  @submit.prevent="editing ? updateChannel() : createChannel()">
      <div class="modal-body">
        <div class="form-group">
           <label for="name">Name:</label>
            <input type="text" v-model="form.name" name="name" class="form-control"
             :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
        </div>
        
         <div class="form-group">
           <label for="color">Color:</label>
            <input type="text" v-model="form.color" name="color" class="form-control"
             :class="{ 'is-invalid': form.errors.has('color') }">
      <has-error :form="form" field="color"></has-error>
        </div>
        
        <div class="form-group">
          <label for="archived">Status:</label>
          <select v-model="form.archived" name="archived" id="archived"
          class="form-control" :class="{ 'is-invalid': form.errors.has('archived') }">
          <option value="" selected>Select Channel Status...</option>
          <option value="0">Active</option>
          <option value="1">Archived</option>
              </select>
      <has-error :form="form" field="type"></has-error>
    </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" v-show=!editing>Create</button>
        <button type="submit" class="btn btn-primary" v-show=editing>Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
        </form>
    </div>
  </div>
</div>
    </div>
    
</template> 

<script>
export default{
    data(){
        return {
            editing:false,
            channels:{},
            form:new Form({
                id:'',
                name:'',
                archived:'',
                color:''
            })
        }
    },
    methods:{
        loadChannel(){
          axios.get('/admin/allchannel').then(({data})=>(this.channels=data));  
        },
        newModal(){
            this.editing=false;
            this.form.reset();
            $('#AddChannel').modal('show');
        },
        editModal(channel){
            this.editing=true;
            $('#AddChannel').modal('show');
            this.form.fill(channel);
        },
        createChannel(){
            this.form.post('channels')
                .catch(error=>{
                flash(error.response.data,'danger');
            }).then(({data})=>{
                this.$emit('AfterCreate');
                $('#AddChannel').modal('hide');
                flash('Channel Created Successfully.');
            });
        },
        updateChannel(id){
           this.form.patch('/admin/channels/'+this.form.id)
            .catch(error=>{
                flash(error.response.data,'danger');
            }).then(({data})=>{
                this.$emit('AfterCreate');
               $('#AddChannel').modal('hide');
               flash('Channel Updated Successfully.'); 
            });    
        },
        destroy(id){
            this.form.delete('/admin/channels/'+id)
           .then(({data})=>{
                this.$emit('AfterCreate');
               flash('Channel Deleted Successfully.'); 
            }).catch(error=>{
                flash(error.response.data,'danger');
            });
            
        },
        getResults(page=1){
            axios.get('/admin/allchannel?page=' + page)
				.then(response => {
					this.channels = response.data;
				});
        }
    },
    created(){
        this.loadChannel();
        this.$on('AfterCreate',()=>{
           this.loadChannel(); 
        });
    },
}
</script>       