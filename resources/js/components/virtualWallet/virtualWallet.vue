<template>
<div>

            <div class="jumbotron">
               <h1 align="center" >{{title}}</h1>
               <b-button size="lg" variant="dark" to="movementAdd" id="bt">Add Movement</b-button>
            </div>

            <div v-if="!editingMovement" id="wallet">
               <!-- <h5 align="center"> Virtual Wallet Balance: {{this.wallet.balance}} </h5> -->
               <b-button size="lg" align="center" disabled variant="dark"> Virtual Wallet Balance: {{this.wallet.balance}}</b-button>
            </div>
            

            <!-- <movement-list :movements="movements" v-on:transfer-info="transferMovement" v-on:edit-movement="editMovement"></movement-list> -->
            <movement-list v-if="!editingMovement"  v-on:refresh-wallet="getWallet" v-on:transfer-info="transferMovement" v-on:edit-movement="editMovement"></movement-list>
            <movement-edit :movement="currentMovement" v-on:edit-canceled="cancelEdit"  v-on:save-success="saveEdit" v-if="currentMovement" ></movement-edit>
            <transfer-info :movement="currentTransfer" v-on:exit-info="exitInfo" v-if="currentTransfer"></transfer-info>






</div>

</template>



<script>
import MovementList from './movementList.vue';
import MovementEdit from './movementEdit.vue';
import TransferInfo from './transferInfo.vue';
import MovementFilter from './movementsFilter.vue';

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
            id:"",
            wallet:''

        }
    },
    methods: {
         getWallet(){
           let url = this.$store.state.user.id;
           axios.get('api/wallets/' + url)
           .then(response=>{
                console.log(response);
                this.wallet=response.data.data;
                Object.assign(this.wallet,response.data.data);
            }).catch(function(err){
                console.log(err);
            })
        },

        // getMovements(){
        //    let url = this.$store.state.user.id;
        //    axios.get('api/movements/id/' + url)
        //    .then(response=>{
        //         console.log(response);
        //         Object.assign(this.movements,response.data.data);
        //     }).catch(function(err){
        //         console.log(err);
        //     })
        // },

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
            this.editingMovement = false;
        },

        saveEdit(){
            this.currentMovement = false;
            this.showSuccess=true;
            this.successMessage='Movement Edited with Success';
            this.editingMovement = false;
        },

        exitInfo(){
            this.currentTransfer = false;
            this.showSuccess=false;
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

       this.getWallet();

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

/* h5 {
 background-color: rgb(241, 241, 241);
 } */

#wallet{

     text-align:center;
   
}

</style>
