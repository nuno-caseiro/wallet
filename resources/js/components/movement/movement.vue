<template>
<div>
       
            <div class="jumbotron">
               <h1>{{title}}</h1>
                <b-button size="lg" variant="success" to="movementAdd">Add Movement</b-button>
            </div>

            <movement-list :movements="movements"></movement-list>

             <div class="alert alert-success" v-if="showSuccess">
                <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
                <strong>@{{ successMessage }}</strong>
            </div>

            <movement-edit :movement="currentMovement" v-if="currentMovement"></movement-edit>  
    




     
</div>

</template>



<script>
import MovementList from './movementList.vue';
import MovementEdit from './movementEdit.vue';

    export default {
      data() {
        return {
            title: 'Movements List',
            showSuccess: false,
            successMessage: '',
            currentMovement: null,
            movements: [],
            editingMovement: false,
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

        editMovement: function(movement){
            this.currentMovement = movement;
            this.editMovement = true;
            this.showSuccess = false;
        },
    },

    computed: {
         getAutenticatedUser(){
                 return this.$store.getters.getAuthUser
    }
    },    

    components:{
       'movement-list' : MovementList,
       'movement-edit' : MovementEdit,
    },

    mounted() {
        this.getMovements();
    },
    }
</script>

<style scoped>

</style>
