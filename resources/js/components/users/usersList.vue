
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
                <th>Admin Actions</th>
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
            <a v-if="user.type==='u'" >{{ user.balance_status == '0.00' ? 'Empty' : 'Has Money' }}</a>
            <a v-if="user.type==='a' ">{{ ' - ' }}</a>
            <a v-if="user.type==='o' ">{{ ' - ' }}</a>
            </td>
            
           
            <td v-if="user.type==='u' ">
                <b-button-group >
                <b-button v-if="user.active==1 && user.balance_status === '0.00' " variant="danger" @click.prevent="unactivateUser(user)" >Unactivate  </b-button>
                <b-button v-if="user.active == 0 && user.balance_status === '0.00' " variant="success" @click.prevent="activateUser(user)" >Activate</b-button>
                <b-button v-if="user.type==='u' && !(user.balance_status == '0.00') " variant="danger" disabled >Unactivate  </b-button>
                </b-button-group>
            </td>  



            <td v-if="!isAuthUser(user) && user.type==='a'   "><b-button  variant="danger" @click.prevent="deleteUser(user)">Delete  </b-button></td>
            <td v-if="user.type==='o'"> <b-button  variant="danger" @click.prevent="deleteUser(user)">Delete  </b-button></td>
            <td v-if="isAuthUser(user)">Your Account</td>

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
            users:[],
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

        isAuthUser(user) {
            return user.email == this.$store.getters.getAuthUser.email ? true : false
        },

        unactivateUser(user) {
            // console.log(user.balance_status);
            axios.patch('api/user/unactivate/' + user.id )
            .then(response => {
                this.getUsers();
            })
        },

        activateUser(user) {
            axios.patch('api/user/activate/' + user.id )
            .then(response => {
                console.log(response);
                this.getUsers();
            })
        },

        deleteUser(user){
            axios.delete('api/users/' + user.id)
            .then(response => {
                console.log(response);
                this.getUsers();
            })
        }


             
   },


   mounted(){
       this.getUsers();

   },

//    computed:{
//             isAuthenticated() {
//                  return this.$store.getters.isAuthenticated;
//             },
//    }
    

}
</script>
<style  scoped >
</style>









