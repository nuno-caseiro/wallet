<template>
<div>

    <table  class="table table-striped">
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
            </tr>
        </thead>
        <tbody>
            <tr v-for="movement in movements" :key="movement.id" :class="{active: selectedMovement === movement}">
            <td>{{ movement.id }}</td>
            <td>{{ movement.type }}</td>
            <td>{{ movement.email}}</td>
            <td>{{ movement.type_payment }}</td>
            <td>{{ movement.category_id}}</td>
            <td>{{ movement.date }}</td>
            <td>{{ movement.start_balance}}</td>
            <td>{{ movement.end_balance }}</td>
            <td>{{ movement.value }}</td>
			
			<td>
                <a class="btn btn-sm btn-info" v-on:click="editMovement(movement)">Edit</a>
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
    props: ['movements'],
    data() {
        return {
			selectedMovement: null,
            userTransfer:"",
            emailTransfer:"",	
			pageNum:"",
			numberP: "",
        }
    },
   methods:{

	//    numberOfPages(movements){
	// 	   this.numberP=(movements.data.data.length)/5;
	// 	   return this.numberP;
	//    },

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
			this.selectedMovement=movement;
            this.$emit('edit-movement', movement);
		},
   }	  
    
}
</script>