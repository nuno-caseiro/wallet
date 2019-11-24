<template>
    <div class="login-page">
        <div class="form">
            <div class="alert" :class="messageType" v-if="showMessage">
                <strong>{{ message }}</strong>
            </div>
            <div class="jumbotron">
                <h2>Movement</h2>

                <div class="form-group">
                    <label for="wallets_email">Choose email of account</label>
                    <select class="form-control" id="wallets_email" name="wallets_email" @change="getWalletInfo($event)">
                        <option></option>
                        <option v-for="wallet in wallets" :key="wallet.id" v-bind:value="wallet.id" >{{wallet.email}}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="value">Value</label>
                <input type="number" class="form-control" v-model="movement.value" name="value" id="value" step="0.01" @input="setFinalBalance()">
                </div>

                <div class="form-group">
                    <label for="typePayment">Payment type</label>
                    <select class="form-control" id="typePayment" name="typePayment" v-model="movement.type_payment">
                        <option></option>
                        <option value="c">Cash</option>
                        <option value="bt">Bank Transfer</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" v-model="movement.source_description" >
                </div>

                <div v-if="movement.type_payment==='bt'" class="form-group">
                    <label for="iban">IBAN</label>
                    <input type="number" class="form-control" v-model="movement.iban" name="iban" id="iban">
                </div>

                <div class="form-group">
                    <label for="categoryId">Choose category</label>
                    <select class="form-control" id="categoryId" name="categoryId" v-model="movement.category_id">
                        <option></option>
                        <option v-for="category in this.categories"  v-bind:value="category.id" >{{category.name}}</option>
                    </select>
                </div>

                <div class="form-group">
                    <a class="btn btn-success" @click.prevent="saveMovement()">Save</a>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['wallets'],
        data(){
            return{
                wallet:{
                    'id':'',
                    'balance':''
                },
                movement:{
                    wallet_id:'',
                    type:'',
                    transfer:'',
                    transfer_movement_id:'',
                    transfer_wallet_id:'',
                    type_payment:'',
                    category_id:'',
                    iban:'',
                    mb_entity_code:'',
                    mb_payment_reference:'',
                    description:'',
                    source_description:'',
                    date:'',
                    start_balance:'',
                    end_balance:'',
                    value:'',
                },
                categories:[],
                showMessage: false,

            }

        },mounted() {
            console.log(this.wallets);
        },methods: {

            getWalletInfo: function (event) {
                console.log("aqui" + event.target.value);
                for (let i = 0; i < this.wallets.length; i++) {
                    //console.log(this.wallets[i.toString()].id);
                    if (this.wallets[i.toString()].id == event.target.value) {
                        this.movement.wallet_id = this.wallets[i.toString()].id;
                        this.movement.start_balance = this.wallets[i.toString()].balance;
                        console.log(this.wallets[i.toString()].id);
                        this.movement.type = 'i'; //TODO sera aqui?
                        this.movement.transfer = 0;
                        this.getCategories();
                    }
                }
                console.log(this.movement);
            },

            setFinalBalance: function () {
                this.movement.end_balance = parseFloat(this.movement.start_balance) + parseFloat(this.movement.value);
            },
            getCategories: function () {
                axios.get('api/categories/type/' + this.movement.type).then(response => {
                    console.log(response);
                    this.categories = response.data.data;
                    console.log(this.categories);
                }).catch(error => {
                    console.log(error);
                });
            },
            saveMovement: function () {
                var newDate = new Date();
                var dataFormatada= newDate.getFullYear()+'-'+newDate.getMonth()+'-'+newDate.getDate()+' '+newDate.getHours()+':'+newDate.getMinutes()+':'+newDate.getSeconds();

                this.movement.date = dataFormatada;
                axios.post('api/movements/', this.movement).then(response => {
                    console.log(response.data);
                }).then(response => {
                    this.wallet.id = this.movement.wallet_id;
                    this.wallet.balance = this.movement.end_balance;
                    axios.put('api/wallets/' + this.wallet.id, this.wallet).then(response => {
                        console.log(response.data);
                    }).catch(error => {
                        console.log(error);
                    });
                })
                    .catch(error => {
                        console.log(error);
                    });
            }

        }


    }
</script>

<style scoped>

</style>
