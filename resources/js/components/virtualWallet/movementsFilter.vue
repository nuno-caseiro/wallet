<template>
<div>
   <div class="panel">
       <div class="panel-body">
        <input v-model="this.id" type="number">
       </div>
       <div class="panel-footer">
           <button v-on:click="applyFilter"></button>
       </div>
   </div>
</div>

</template>

<script>
    export default {
    data(){
        return {
            id:'',
        }
    },
        methods: {

        applyFilter: function () {
            this.$emit('apply-Filter');
            }
        }




    }
</script>

<style scoped>

</style>
