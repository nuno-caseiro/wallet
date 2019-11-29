
<template  >
<div>
    <table class="table table-striped" >
        <thead>
            <tr>
                <th>User Type</th>
                <th>Name</th>
                <th>Photo</th>
                <th>E-Mail</th>
                <th>Account Status</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody >

            <tr v-for="user in users" :key="user.id" >
            <td v-if="user.type==='a'">{{"Admin"}}</td>
            <td v-if="user.type==='o'">{{"Operator"}}</td>
            <td v-if="user.type==='u'">{{"User"}}</td> 
            <td>{{ user.name }}</td>
            <td><img  v-bind:src="itemImageURL(user.photo)" width="30" height="30" alt=""></td>
			<td>{{ user.email }}</td>
            <td>
            <a v-if="user.type==='u'" >{{ user.active === 1 ? 'Active' : ' Inactive ' }}</a>
            <a v-if="user.type==='a' ">{{ ' - ' }}</a>
            <a v-if="user.type==='o' ">{{ ' - ' }}</a>
            </td>

            <td>
            <a v-if="user.type==='u'" >{{ user.balance_user === 0 ? 'Empty' : ' Has Money ' }}</a>
            <a v-if="user.type==='a' ">{{ ' - ' }}</a>
            <a v-if="user.type==='o' ">{{ ' - ' }}</a>
            </td>
            
           




            <!-- <td>
                <b-button-group>
                <b-button  variant="warning" @click.prevent="editMovement(movement)">Edit</b-button>
                <b-button  variant="info" @click.prevent="transferInfo(movement)">Info</b-button>
                </b-button-group>
            </td>  -->

        </tr>
      </tbody>
    </table>
</div>
</template>


<script type="text/javascript">
import axios from 'axios';
export default {
    data() {
        return {
            selectedMovement: null,
            users:[]
        }      
    },
   methods:{
        getUsers(){
           axios.get('api/users/')
           .then(response=>{
                console.log(response);
                this.users=response.data.data;
            }).catch(function(err){
                console.log(err);
            });
        },
        itemImageURL(photo){
                return "storage/fotos/"+String(photo);

             },
   },


   mounted(){
       this.getUsers();

   }
    

}
</script>
<style  scoped >

</style>









