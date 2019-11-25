<template>
<div>
       
            <div class="jumbotron">
                <h1>{{title}}</h1>
                <a><b-button size="lg" variant="success" to="movementAdd">Movement Add</b-button></a>
            </div>

            <movement-list :movements="movements"></movement-list>




     
</div>

</template>



<script>
import MovementList from './movementList.vue';
    export default {
      data() {
        return {
            title: 'Movements List',
            showSuccess: false,
            successMessage: '',
            currentItem: null,
            movements: [],
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
    }
    },

    computed: {
         getAutenticatedUser(){
                 return this.$store.getters.getAuthUser
    }
    },    

    components:{
       'movement-list' : MovementList,
    },

    mounted() {
        this.getMovements();
    },
    }
</script>

<style scoped>

</style>
