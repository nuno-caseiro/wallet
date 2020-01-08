
<template  >
<div>
     <div class="form-group">
        <filter-view @apply-Filter="applyFilter"  v-on:clean-filter="cleanFilter"></filter-view>
    </div>
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
        <tbody  v-for="user in users" :key="user.id" >

            <td v-if="user.type==='a'">{{"Admin"}}</td>
            <td v-if="user.type==='o'">{{"Operator"}}</td>
            <td v-if="user.type==='u'">{{"User"}}</td> 
            <td>{{ user.name }}</td>
            <td><img  v-bind:src="itemImageURL(!user.photo == '' ? user.photo : 'unknown.png')" width="30" height="30" alt=""></td>
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
                <b-button v-if="user.active == 1 && user.balance_status === '0.00' " variant="danger" @click.prevent="deactivateUser(user)" >Deactivate </b-button>
                <b-button v-if="user.active == 0 && user.balance_status === '0.00' " variant="success" @click.prevent="activateUser(user)" >Reactivate</b-button>
                <b-button v-if="user.active == 1 && !(user.balance_status == '0.00') " variant="danger" disabled >Deactivate </b-button>
                <b-button v-if="user.active == 0 && !(user.balance_status == '0.00') " variant="success" @click.prevent="activateUser(user)" >Reactivate</b-button>
                </b-button-group>
            </td>  



            <td v-if="!isAuthUser(user) && user.type==='a'   "><b-button  variant="danger" @click.prevent="deleteUser(user)">Delete  </b-button></td>
            <td v-if="user.type==='o'"> <b-button  variant="danger" @click.prevent="deleteUser(user)">Delete  </b-button></td>
            <td v-if="isAuthUser(user)">Your Account</td>

        </tbody>
        </table>


        <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]"
                    class="page-item"><a class="page-link" href="#"
                                        @click="getUsers(pagination.prev_page_url,'previous')">Previous</a></li>

                <li class="page-item disabled"><a class="page-link" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]"
                    class="page-item"><a class="page-link" href="#"
                                        @click="getUsers(pagination.next_page_url,'next')">Next</a></li>
        </ul>


    </div>
</template>


<script type="text/javascript">
import axios from 'axios';
import UsersFilter from './usersFilter.vue';
export default {
    data() {
        return {
            users:[],
            filters:null,
            pagination:{},
            filters:'',
        }      
    },
   methods:{
        getUsers(url, action){
        if(action==="next"){
            if(this.pagination.next_page_url.includes("filter")){
                    this.applyFilter(this.filters,'next');
            }
        }else if(action==="previous"){
            if(this.pagination.prev_page_url.includes("filter")){
                     this.applyFilter(this.filters,'previous');
                 }
        }

        if(this.filters===''){
            let page_url = url || 'api/users/';
            axios.get(page_url)
            .then(response=>{
                console.log(response);
                this.users=response.data.data;
                this.makePagination(response.data.meta, response.data.links);
            }).catch(function(err){
                console.log(err);
            });
        }
        /// este foi o erro apagado
        // if(this.filters!=''){
        //     let page_url = url || 'api/users/';
        //     axios.get(page_url)
        //     .then(response=>{
        //         console.log(response);
        //         this.users=response.data.data;
        //         this.makePagination(response.data.meta, response.data.links);
        //     }).catch(function(err){
        //         console.log(err);
        //     });
        // }
        },
        itemImageURL(photo){
                return "storage/fotos/"+String(photo);

             },

        isAuthUser(user) {
            return user.email === this.$store.state.user.email ? true : false
        },

        deactivateUser(user) {
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
        },

        applyFilter(filters, action){
            this.filters=filters;
            //string builder
            let stringFilter='?';
            if(filters.type!=''){
                if(stringFilter!='?'){
                    stringFilter+='&';
                }
                stringFilter+='type='+filters.type;
            }
            if(filters.name!=''){
                if(stringFilter!='?'){
                    stringFilter+='&';
                }
                stringFilter+='name='+filters.name;
            }

            if(filters.email!=''){
                if(stringFilter!='?'){
                    stringFilter+='&';
                }
                stringFilter+='email='+filters.email;
            }

            if(filters.active!=''){
                if(stringFilter!='?'){
                    stringFilter+='&';
                }
                stringFilter+='active='+filters.active;
            }
         
            if(action==="next"){
                if(this.pagination.next_page_url.includes("page") ){
                    let substring = this.pagination.next_page_url.split("?");
                    console.log(substring);
                    stringFilter+='&'+substring[1];
                    console.log(stringFilter);
                }
            }
            if(action==="previous"){
                if(this.pagination.prev_page_url.includes("page") ){
                    let substring = this.pagination.prev_page_url.split("?");
                    //console.log(substring[0]);
                    stringFilter+='&'+substring[1];
                    console.log(stringFilter);
                }
            }
            

        console.log(stringFilter);
            axios.get('api/users/1/filter/'+stringFilter)
                .then(response => {
                    console.log(response);
                    this.users = response.data.data;
                    this.makePagination(response.data.meta, response.data.links);
                })


        },

        cleanFilter(){
            this.filters='';
            this.getUsers();
        },

        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
            };
            this.pagination = pagination
        },


             
   },


   mounted(){
       this.getUsers();
       

   },

   components:{
        'filter-view' :UsersFilter
    }
    

}
</script>
<style  scoped >
</style>









