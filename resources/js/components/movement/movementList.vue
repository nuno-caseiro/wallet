<template  >
<div>
    <ul class="pagination">
            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" 
            class="page-item"><a class="page-link" href="#"
            @click="getMovements(pagination.prev_page_url)">Previous</a></li>
            
            <li class="page-item disabled"><a class="page-link" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

            <li v-bind:class="[{disabled: !pagination.next_page_url}]" 
            class="page-item"><a class="page-link" href="#"
            @click="getMovements(pagination.next_page_url)">Next</a></li>
        </ul>
    <table class="table table-striped" >
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
</div>
</template>



<script type="text/javascript">
import axios from 'axios';
export default {
   // props: ['movements'],
    data() {
        return {
            selectedMovement: null,
            currentMovement:{},
            id:"",
            pagination: {},
            movements: [],
        }
    },
   methods:{
		editMovement(movement){
			
            this.$emit('edit-movement', movement);
        },
        transferInfo(movement){
			
            this.$emit('transfer-info', movement);
        },

         getMovements(url) {
             
                var id=this.$store.state.user.id
                let page_url = url || '/api/movements/id/' + id
               axios.get(page_url)
                .then(response => {
                    this.movements = response.data.data
                    this.makePagination(response.data.meta, response.data.links)
                })
        },
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
            }
            this.pagination = pagination
        },
   },

   computed:{
            isUser(){
                return this.$store.getters.isUser;
            },
    },

    mounted() {
        this.getMovements();
    }

}
</script>
<style  scoped >

</style>