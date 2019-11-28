
<template  >
<div>
    <table class="table table-striped" >
        <thead>
            <tr>
                <th>Name</th>
                <th>Photo</th>
                <th>E-Mail</th>
                <th>Account Status</th>
                <th>Balance</th>

            </tr>
        </thead>
        <tbody >
            <tr v-for="user in users" :key="user.id" >
            <td>{{ user.name }}</td>
            <td><img  v-bind:src="itemImageURL(user.photo)" width="30" height="30" alt=""></td>
			<td>{{ user.email }}</td>
            <td>{{ user.active === 1 ? 'Active' : 'Inactive' }}</td>
            <td v-if="user.balance_status===0">{{ 'Empty' }}</td>
            <td v-if="user.balance_status>0">{{ 'Has money' }}</td>

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









