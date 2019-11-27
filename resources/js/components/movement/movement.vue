<template>
<div>
        
            <div class="jumbotron">
               <h1 align="center" >{{title}}</h1>
               <b-button size="lg" variant="dark" to="movementAdd" id="bt">Add Movement</b-button>
            </div>

            <movement-list :movements="movements" v-on:transfer-info="transferMovement" v-on:edit-movement="editMovement"></movement-list>
            <movement-edit :movement="currentMovement" v-on:edit-canceled="cancelEdit"  v-on:save-success="saveEdit" v-if="currentMovement" ></movement-edit>
            <transfer-info :movement="currentTransfer" v-if="currentTransfer"></transfer-info>
            





</div>

</template>



<script>
import MovementList from './movementList.vue';
import MovementEdit from './movementEdit.vue';
import TransferInfo from './transferInfo.vue';

    export default {
      data() {
        return {
            title: 'Movements List',
            showSuccess: false,
            successMessage: '',
            messageType: "alert-success",
            currentTransfer: null,
            currentMovement: null,
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

         transferMovement(movement){
            this.currentTransfer = movement;
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
       'transfer-info' : TransferInfo,
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
#bt{
    margin-right: 850px ;
    margin-bottom: -20px;
}


</style>
