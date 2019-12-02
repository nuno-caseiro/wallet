<template>
<div>
   <div class="panel">
       <div class="panel-header">
<h3>Filters</h3>
       </div>
       <div class="panel-body">
          <div>
              <label>Movement id:</label>
              <input id="id" v-model="filters.id" type="number">
          </div>
           <div>
               <label>Type: </label>
               <select v-model="filters.type" >
                   <option value="e">Expense</option>
                   <option value="i">Income</option>
               </select>
           </div>
           <div>
               <label>Date1 :</label>
               <input id="date1" v-model="filters.date1" type="date">
           </div>

           <div>
               <label>Date2 :</label>
               <input id="date2" v-model="filters.date2" type="date">
           </div>

           <div>
               <label for="categoryId">Choose category</label>
               <select id="categoryId" name="categoryId" v-model="filters.category_id">
                   <option></option>
                   <option v-for="category in this.categories"  v-bind:value="category.id" >{{category.name}}</option>
               </select>
           </div>

           <div>
               <h6>Transfer</h6>
               <div>
                   <label for="sourceEmail">Choose source email</label>
                   <select id="sourceEmail" name="sourceEmail" v-model="filters.source_email">
                       <option></option>
                       <option v-for="wallet in this.wallets"  v-bind:value="wallet.id" >{{wallet.email}}</option>
                   </select>
               </div>

               <div>
                   <label for="destEmail">Choose destination email</label>
                   <select id="destEmail" name="destEmail" v-model="filters.dest_email">
                       <option></option>
                       <option v-for="wallet in this.wallets"  v-bind:value="wallet.id" >{{wallet.email}}</option>
                   </select>
               </div>
           </div>
       </div>

       <div class="panel-footer">
           <button v-on:click="applyFilter()">Apply filters</button>
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
                type:'',
                date1:'',
                date2:'',
                category_id:'',
                source_email:'',
                dest_email:'',

            },
            categories:[],
            wallets:[],
        }
    },
        methods: {

        applyFilter: function () {
            this.$emit('apply-Filter', this.filters);
            },

            getCategories: function () {
                axios.get('api/categories').then(response => {
                    this.categories = response.data.data;
                }).catch(error => {
                    console.log(error);
                });

            },
            getWallets: function () {
                axios.get('api/wallets').then(response => {
                    this.wallets = response.data.data;
                }).catch(error => {
                    console.log(error);
                });

            },

        },
        mounted() {
        this.getCategories();
        this.getWallets();
        }


    }
</script>

<style scoped>

</style>
