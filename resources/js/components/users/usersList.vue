
<template  >
<div>
    <table v-if="!view" class="table table-striped" >
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Tranfer Email</th>
                <th>Payment Type</th>
                <th>Category</th>
                <th>Date</th>
                <th>Start Balance</th>
                <th>End Balance</th>
                <th>Value</th>
                <th>Actions</th>

            </tr>
        </thead>
        <tbody >
            <tr v-for="movement in movements" :key="movement.id" :class="{active: selectedMovement === movement}">
            <td>{{ movement.id }}</td>
            <td v-if="movement.type ==='e'">{{ movement.type ==='e'? 'Expense': '' }}</td>
            <td v-if="movement.type ==='i'">{{ movement.type ==='i'? 'Income': '' }}</td>
            <td>{{ movement.transfer===1 ? movement.wallet_email : ''}}</td>
            <td v-if="movement.type_payment==='c' && movement.transfer===0">{{movement.type_payment==='c'? 'Cash' : ''}}</td>
            <td v-if="movement.type_payment==='mb'&& movement.transfer===0">{{movement.type_payment==='mb'? 'MB payment' : ''}}</td>
            <td v-if="movement.type_payment==='bt'&& movement.transfer===0">{{movement.type_payment==='bt'? 'Bank Transfer' : ''}}</td>
            <td v-if="movement.type_payment===null">{{movement.type_payment===null? '':''}}</td>
            <td>{{ movement.category_name}}</td>
            <td>{{ movement.date }}</td>
            <td>{{ movement.start_balance}}</td>
            <td>{{ movement.end_balance }}</td>
            <td>{{ movement.value }}</td>

			<td>
                <b-button-group>
                <b-button  variant="warning" @click.prevent="editMovement(movement)">Edit</b-button>
                <b-button  variant="info" @click.prevent="transferInfo(movement)">Info</b-button>
                </b-button-group>
            </td> 

        </tr>
      </tbody>
    </table>

   <div class="overflow-auto">
    <b-pagination-nav :link-gen="linkGen" :number-of-pages="10" use-router></b-pagination-nav>
  </div>
</div>
</template>


<script type="text/javascript">
import axios from 'axios';
import pagination from '../main/pagination.vue';
import movementVue from './movement.vue';
export default {
    data() {
        return {
            selectedMovement: null,
            selectedMovementTransfer:null,
            view: false,
        }
    },
   methods:{
        getUsers(){
           axios.get('api/users/' + url)
           .then(response=>{
                console.log(response);
                this.movements=response.data.data;
            }).catch(function(err){
                console.log(err);
            })
        },

		linkGen(pageNum) {
        return pageNum === 1 ? '?' : `?page=${pageNum}`
	  },

	  	paginate(pageNum){
        axios.get('/api/users?page=' + pageNum)
        .then(function(response){
            movements=response.data.data;

        })
        .catch(function(error){
            console.log(error);
        });
		   },
		editMovement(movement){
			
            this.$emit('edit-movement', movement);
        },
        transferInfo(movement){
			
            this.$emit('transfer-info', movement);
        },

   },

   computed:{
            isUser(){
                return this.$store.getters.isUser;
            },
}

}
</script>
<style  scoped >

</style>









