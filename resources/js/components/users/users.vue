<template>
<div>
            <div class="jumbotron">
               <h1 align="center" >{{title}}</h1>
               <b-button size="lg" variant="dark" to="userAdd" id="bt">Add User</b-button>
               <!-- <b-button size="lg" variant="dark" to="adminStatistics" >Stats</b-button> -->
            </div>
            <users-list></users-list>

</div>

</template>

<script>
import UsersList from './usersList.vue';

    export default {
      data() {
        return {
            title: 'Users List',
            showSuccess: false,
            successMessage: '',
            messageType: "alert-success",
            
        }
    },
    components:{
        'users-list' : UsersList,
    },
    methods: {
         
    }
    }
</script>

<style scoped>
#bt{
    margin-right: 850px ;
    margin-bottom: -20px;
}


</style>
