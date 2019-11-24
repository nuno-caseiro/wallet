<template>
    <div class="login-page">
        <div class="form">
            <div class="alert" :class="messageType" v-if="showMessage">
                <strong>{{ message }}</strong>
            </div>
            <div class="jumbotron">
                <h2>Movement</h2>

                <div class="form-group">
                    <label for="movementType">Movement type</label>
                    <select class="form-control" id="movementType" name="movementType" v-model="movement.type" @change="getCategories()"  >
                        <option></option>
                        <option v-if="isOperator"  value="i">Income</option>
                        <option v-if="isUser" value="e">Expense</option>
                    </select>
                </div>

                <div class="form-group" v-if="isUser">
                    <label for="transfer">Transfer</label>
                    <input type="checkbox" id="transfer" v-model="movement.transfer">
                </div>

                <div v-if="this.isToShowDestination" class="form-group">
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

                <div v-if="movement.transfer==0" class="form-group">
                    <label for="typePayment">Payment type</label>
                    <select class="form-control" id="typePayment" name="typePayment" v-model="movement.type_payment">
                        <option value="c" v-if="isOperator">Cash</option>
                        <option value="bt">Bank Transfer</option>
                        <option value="mb" v-if="isUser">MB</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" v-model="movement.description" >
                </div>

                <div v-if="movement.transfer==1" class="form-group">
                    <label for="descriptionSource">Description</label>
                    <input type="text" class="form-control" id="descriptionSource" name="descriptionSource" v-model="movement.source_description" >
                </div>

                <div v-if="movement.type_payment==='bt'" class="form-group">
                    <label for="iban">IBAN</label>
                    <input type="number" class="form-control" v-model="movement.iban" name="iban" id="iban">
                </div>

                <div v-if="movement.type_payment==='mb'" class="form-group">
                    <label for="mbCode">MB entity code</label>
                    <input type="number" class="form-control" v-model="movement.mb_entity_code" name="mbCode" id="mbCode">
                </div>
                <div v-if="movement.type_payment==='mb'" class="form-group">
                    <label for="mbPaymentReference">MB payment Reference </label>
                    <input type="number" class="form-control" v-model="movement.mb_payment_reference" name="mbPaymentReference" id="mbPaymentReference">
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
                wallet_source:{
                    'id':'',
                    'balance':'',
                },
                wallet_dest:{
                    'id':'',
                    'balance':''
                },
                movement:{
                    wallet_id:'',
                    type:'',
                    transfer:false,
                    transfer_movement_id:'',
                    transfer_wallet_id:'',
                    type_payment:null,
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

        },
        methods: {
            getSourceWallet: function () {
              axios.get('api/wallets/'+this.currentUser.id).then(response=>{
                  this.wallet_source=response.data.data;
                  this.movement.wallet_id=this.wallet_source.id;
                  this.movement.start_balance=this.wallet_source.balance;
                  }
              )
            }

            ,getWalletInfo: function (event) {
                console.log("aqui" + event.target.value);
                for (let i = 0; i < this.wallets.length; i++) {
                    //TODO OTIMIZAR CODIGO REPETIDO
                    if(this.isOperator){
                    if (this.wallets[i.toString()].id == event.target.value) {
                        this.movement.wallet_id = this.wallets[i.toString()].id;
                        this.movement.start_balance = this.wallets[i.toString()].balance;
                        console.log(this.wallets[i.toString()].id);
                        }
                    }
                    if(this.isUser && this.movement.transfer==1 ){
                        if (this.wallets[i.toString()].id == event.target.value) {
                            this.movement.transfer_wallet_id = this.wallets[i.toString()].id;
                            console.log(this.wallets[i.toString()].id);
                        }
                    }

                }
                console.log(this.movement);
            },
            setTransfer: function(){
              this.movement.transfer=1;
            },

            setFinalBalance: function () {
                if(this.movement.type=='i'){
                    this.movement.end_balance = parseFloat(this.movement.start_balance) + parseFloat(this.movement.value);
                }else{
                    this.movement.end_balance = parseFloat(this.movement.start_balance) - parseFloat(this.movement.value);
                }
            },
            getCategories: function () {
                axios.get('api/categories/type/' + this.movement.type).then(response => {
                    this.categories = response.data.data;
                }).catch(error => {
                    console.log(error);
                });

            },
            saveMovement: function () {
                let newDate = new Date();
                let dataFormatada= newDate.getFullYear()+'-'+newDate.getMonth()+'-'+newDate.getDate()+' '+newDate.getHours()+':'+newDate.getMinutes()+':'+newDate.getSeconds();
                this.movement.date = dataFormatada;

                if(this.movement.type==='i' && this.isOperator){
                    axios.post('api/movements/', this.movement).then(response => {
                        console.log(response.data);
                    }).then(response => {
                        this.wallet_dest.id = this.movement.wallet_id;
                        this.wallet_dest.balance = this.movement.end_balance;
                        axios.put('api/wallets/' + this.wallet_dest.id, this.wallet_dest).then(response => {
                            console.log(response.data);
                        }).catch(error => {
                            console.log(error);
                        });
                    })
                        .catch(error => {
                            console.log(error);
                        });
                    }

                if(this.movement.type==='e' && this.isUser && this.movement.transfer===false){
                    axios.post('api/movements/', this.movement).then(response => {
                        console.log(response.data);
                    }).then(response => {
                        this.wallet_source.balance = this.movement.end_balance;
                        axios.put('api/wallets/' + this.wallet_source.id, this.wallet_source).then(response => {
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
        },
        mounted() {
            if(this.currentUser.type==='u'){
                this.getSourceWallet();
            }
        },
        computed:{
            isUser(){
                return this.$store.getters.isUser;
            },
            isOperator(){
                return this.$store.getters.isOperator;
            },
            isAdmin(){
                return this.$store.getters.isAdmin;
            },
            isToShowDestination(){
              if((this.movement.transfer==1 && this.isUser)|| this.isOperator){
                  return true;
              } else{
                  return false;
              }
            },
            currentUser(){
                return this.$store.getters.getAuthUser;
            }

        }


    }
</script>

<style scoped>

</style>
