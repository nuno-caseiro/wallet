<template>
<div>
   <div class="panel">
       <div class="panel-body">
        <input v-model="filters.id" type="number">
       </div>
       <div class="panel-footer">
           <button v-on:click="applyFilter()">Hello World</button>
       </div>
   </div>
</div>

</template>

<script>
    export default {
    data(){
        return {
            filters:{
                id:'',

            }
        }
    },
        methods: {

        applyFilter: function () {
            this.$emit('apply-Filter', this.filters);
            }
        }




    }
</script>

<style scoped>

</style>
