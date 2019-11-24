<template>
<div>
    <nav aria-label="Page navigation example">
        <div>
            <a class="btn btn-info" @click.prevent="getMovements()">All</a>
        </div>
        <hr>
        <ul class="pagination">
        </ul>
    </nav>
    <table class="table">
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
        <tbody v-for="movement in movements" v-bind:key="movement.id">
            <td>{{ movement.id }}</td>
            <td>{{ movement.type }}</td>
            <td>{{ movement.category_id }}</td>
            <td>{{ movement.type_payment }}</td>
            <td>{{ movement.category_id}}</td>
            <td>{{ movement.date }}</td>
            <td>{{ movement.start_balance}}</td>
            <td>{{ movement.end_balance }}</td>
            <td>{{ movement.value }}</td>

        </tbody>
    </table>
</div>
</template>


<script type="text/javascript">
import axios from 'axios';
export default {
    data() {
        return {
            movements: "",
            pagination: {},
        }
    },
    methods: {

       getMovements(){
           let url = this.getAutenticatedUser.id
           axios.get('api/movements/id/' + url)
           .then(response=>{
                console.log(response);
                this.movements=response.data.data;
            }).catch(function(err){
                console.log(err);
            })
        },

        

    },

    computed: {
         getAutenticatedUser(){
                 return this.$store.getters.getAuthUser
             }

        
    },

    mounted() {
        this.getMovements();

    },

}
</script>