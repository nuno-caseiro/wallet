<template>
<div>
        
            <div class="jumbotron">
               <h1>{{title}}</h1>
                <b-button size="lg" variant="success" to="movementAdd">Add Movement</b-button>

            </div>

            <movement-list :movements="movements" v-on:edit-movement="editMovement" v-if="isUser" ></movement-list>
            <movement-edit :movement="currentMovement" v-on:edit-canceled="cancelEdit"  v-on:save-success="saveEdit" v-if="currentMovement" ></movement-edit>
            
            





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
            messageType: "alert-success",
            currentMovement: null,
            currentCategory: null,
            movements: [],
            editingMovement: false,
            
        }
    },
    methods: {
         getMovements(){
           let url = this.$store.state.user.id;
           axios.get('api/movements/id/' + url)
           .then(response=>{
                console.log(response);
                this.movements=response.data.data;
            }).catch(function(err){
                console.log(err);
            })
        },

        editMovement(movement){
            this.currentMovement = movement;
            this.editingMovement = true;
            this.showSuccess = false;
        },
        getAutenticatedUser(){
            return this.$store.getters.getAuthUser
        },
        
        cancelEdit(){
            this.currentMovement = false;
            this.showSuccess=false;
        },

        saveEdit(){
            this.currentMovement = false;
            this.showSuccess=true;
            this.successMessage='Movement Edited with Success';
        },

    },

    computed: {
          isUser(){
                return this.$store.getters.isUser;
            },  
    },

    components:{
       'movement-list' : MovementList,
       'movement-edit' : MovementEdit,
    },

    mounted() {
        this.getMovements();

        if(!this.isUser){
            setTimeout(() => {
                        this.$router.push("/movementAdd")}, 1);  
        }
        
    },
    }
</script>

<style scoped>
.h1{
    text-align: center;
}
</style>
