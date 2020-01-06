<template>
<div>
   <div class="panel" id="panelBody">
       <div class="panel-header">
       </div>
       <div >
            <div id= "row1">
                <div>
                    <label>Movement id:</label>
                    <input id="id" v-model="filters.id" type="number">
                </div>
                <div>
                    <label for="categoryId">Choose category</label>
                    <select id="categoryId" name="categoryId" v-model="filters.category_id">
                        <option></option>
                        <option v-for="category in this.categories"  v-bind:value="category.id" >{{category.name}}</option>
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
                <div v-if="filters.source_email == '' && filters.dest_email==''">
                    <label>Type: </label>
                    <select v-model="filters.type" >
                        <option value=""></option>
                        <option value="e">Expense</option>
                        <option value="i">Income</option>
                    </select>
                </div>
                <div v-if="filters.dest_email=='' && filters.type==''">
                    <label for="sourceEmail">Choose source email</label>
                    <select id="sourceEmail" name="sourceEmail" v-model="filters.source_email">
                        <option></option>
                        <option v-for="wallet in this.wallets"  v-bind:value="wallet.id" >{{wallet.email}}</option>
                    </select>
                </div>
                <div v-if="filters.source_email=='' && filters.type==''">
                    <label id = "e" for="destEmail">Choose destination email</label>
                    <select id="destEmail" name="destEmail" v-model="filters.dest_email">
                        <option></option>
                        <option v-for="wallet in this.wallets"  v-bind:value="wallet.id" >{{wallet.email}}</option>
                    </select>
                </div>
            </div>

            <div>
                    <b-button-group id="b">
                        <b-button size="sm" variant="outline-primary" v-on:click="applyFilter()">Apply filters</b-button>
                        <b-button size="sm" variant="outline-primary" v-on:click="cleanFilter()">Clean filters</b-button>
                    </b-button-group>
            </div>
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

        cleanFilter: function () {
            this.filters.id = '';
            this.filters.type = '';
            this.filters.date1 = '';
            this.filters.date2 = '';
            this.filters.category_id = '';
            this.filters.source_email = '';
            this.filters.dest_email = '';
            this.$emit('clean-filter');
            },

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
#row1{
    margin-top:30px;
    display: flex; /* or inline-flex */
    justify-content: space-evenly;
    flex-wrap: wrap;
}
#e{
    margin-left: 15px ;
}


#b{
    margin-top: 3px ;
}

#panelBody{
    background-color: rgb(241, 241, 241);
    margin-bottom: 15px;
}
</style>
