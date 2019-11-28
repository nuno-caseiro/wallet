<template>
<div>
            <div class="jumbotron">
               <h1 align="center" >{{title}}</h1>
               <b-button size="lg" variant="dark" to="movementAdd" id="bt">Add User</b-button>
            </div>
</div>

</template>

<script>


    export default {
      data() {
        return {
            title: 'Users List',
            showSuccess: false,
            successMessage: '',
            messageType: "alert-success",
            
        }
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
