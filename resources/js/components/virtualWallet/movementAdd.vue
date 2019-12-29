<template>
    <div class="login-page">
        <div class="form">
            <div class="alert" :class="messageType" v-if="showSuccess">
                <strong>{{ successMessage }}</strong>
            </div>
            <div class="jumbotron">
                <h2>Movement</h2>

                <div class="form-group">
                    <label for="movementType">Movement type</label>
                    <select class="form-control" id="movementType" name="movementType" v-model="$v.movement.type.$model" @change="getCategories()"  >
                        <option v-if="isOperator"  value="i">Income</option>
                        <option v-if="isUser" value="e">Expense</option>
                    </select>
                    <div v-if="$v.movement.type.$error">
                        <div class="error" v-if="!$v.movement.type.required">Field is required</div>
                    </div>

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
                    <input type="number" class="form-control" v-model="$v.movement.value.$model" name="value" id="value" step="0.01" @input="setFinalBalance()">
                    <div v-if="$v.movement.value.$error">
                    <div class="error" v-if="!$v.movement.value.required">Field is required</div>
                    </div>
                </div>


                <div v-if="movement.transfer===false" class="form-group">
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

                <div v-if="movement.transfer===true" class="form-group">
                    <label for="descriptionSource">Description</label>
                    <input type="text" class="form-control" id="descriptionSource" name="descriptionSource" v-model="movement.source_description" >
                </div>

                <div v-if="movement.type_payment==='bt'" class="form-group">
                    <label for="iban">IBAN</label>
                    <input type="text" class="form-control" v-model="$v.movement.iban.$model" name="iban" id="iban">
                    <div v-if="$v.movement.iban.$error">
                        <div class="error" v-if="!$v.movement.iban.required">Field is required</div>
                        <div class="error" v-if="!$v.movement.iban.ibanValid">EX: PT50 1234 4321 12345678901 72</div>
                    </div>
                </div>

                <div v-if="movement.type_payment==='mb'" class="form-group">
                    <label for="mbCode">MB entity code</label>
                    <input type="number" class="form-control" v-model="movement.mb_entity_code" name="mbCode" id="mbCode">
                    <div v-if="$v.movement.mb_entity_code.$error">
                        <div class="error" v-if="!$v.movement.mb_entity_code.required">Field is required</div>
                        <div class="error" v-if="!$v.movement.mb_entity_code.mb_ec_valid">12345</div>
                    </div>    
                </div>
                <div v-if="movement.type_payment==='mb'" class="form-group">
                    <label for="mbPaymentReference">MB payment Reference </label>
                    <input type="number" class="form-control" v-model="movement.mb_payment_reference" name="mbPaymentReference" id="mbPaymentReference">
                    <div v-if="$v.movement.mb_payment_reference.$error">
                        <div class="error" v-if="!$v.movement.mb_payment_reference.required">Field is required</div>
                        <div class="error" v-if="!$v.movement.mb_payment_reference.mb_pr_valid">123456789</div>
                    </div>   
                </div>


                <div class="form-group">
                    <label for="categoryId">Choose category</label>
                    <select class="form-control" id="categoryId" name="categoryId" v-model="movement.category_id">
                        <option></option>
                        <option v-for="category in this.categories"  v-bind:value="category.id" >{{category.name}}</option>
                    </select>
                </div>

                <div class="form-group">
                    <b-button size="lg" variant="outline-success" @click.prevent="saveMovement()">Save</b-button>
                    <b-button size="lg" variant="outline-danger" @click.prevent="cancelAdd()">Cancel</b-button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import { helpers,required, minLength, between, requiredIf } from 'vuelidate/lib/validators'
    const regexEntityCode = /^[0-9]{5}$/g
    const regexPaymentReference = /^[0-9]{9}$/g
    const regexIban = /^[a-zA-Z]{2}[0-9]{2} [0-9]{4} [0-9]{4} [0-9]{11} [0-9]{2}$/g
    export default {
        data(){
            return{

                wallets:[],
                wallet_source:{
                    id:'',
                    balance:'',
                },
                wallet_dest:{
                    id:'',
                    balance:''
                },
                movement:{
                    id:'',
                    wallet_id:'',
                    type:'',
                    transfer:false,
                    transfer_movement_id:'',
                    transfer_wallet_id:'',
                    type_payment:null,
                    category_id:null,
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
                movement_dest:{
                    id:'',
                    wallet_id:'',
                    type:'',
                    transfer:false,
                    transfer_movement_id:'',
                    transfer_wallet_id:'',
                    type_payment:null,
                    category_id:null,
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
                showSuccess: false,
                successMessage: '',
                messageType: "alert-success",
                submitStatus: null,
            }

        },
        validations:{

            movement:{
                value:{
                    required,
                },
                type:{
                    required,
                },
                iban:{
                    required: requiredIf(function(movement){
                        return this.movement.type_payment==='bt';
                    }),
                    ibanValid:(iban)=>{
                        return regexIban.test(iban)
                        }
                },
                mb_entity_code:{

                    required: requiredIf(function(movement){
                        return this.movement.type_payment==='mb';
                    }),
                    mb_ec_valid:(mb_entity_code)=>{
                        return(
                            regexEntityCode.test(mb_entity_code)
                        );
                    }
                },


                mb_payment_reference:{
                    required: requiredIf(function(movement){
                        return this.movement.type_payment==='mb';
                    }),

                    mb_pr_valid:(mb_payment_reference)=>{
                        return regexPaymentReference.test(mb_payment_reference)

                    }
                }


            }
        },
        methods: {
            getWallets(){
                axios.get('api/wallets').then(response=>{
                    this.wallets=response.data.data;
                })
            },
            getSourceWallet: function () {

                axios.get('api/wallets/'+this.$store.state.user.id).then(response=>{
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
                    if(this.isUser && this.movement.transfer===true ){
                        if (this.wallets[i.toString()].id == event.target.value) {
                            this.movement.transfer_wallet_id = this.wallets[i.toString()].id;
                            this.wallet_dest.id=this.wallets[i.toString()].id;
                            this.wallet_dest.balance=this.wallets[i.toString()].balance;
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
                if(this.movement.type==='i'){
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
            sendMessageTo:function(userID){
                let userDest='';
                axios.get('api/users/'+userID).then(response=>{
                    console.log(response);
                    userDest=response.data.data;
                    Object.assign(userDest, response.data.data);
                    console.log(userDest);

                    let msg = ('Income of ' + this.movement.value + ' euros was sent to your wallet');
                    this.$socket.emit('message_from_user_income',msg,this.$store.state.user,userDest);

                });


            },
            saveMovement: function () {
                console.log('submit!');
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.submitStatus = 'ERROR';
                } else {
                        if(this.movement.type==='i' && this.isOperator){
                            axios.post('api/movements/', this.movement).then(response => {
                                console.log(response.data);
                            }).then(response => {
                                this.wallet_dest.id = this.movement.wallet_id;
                                this.wallet_dest.balance = this.movement.end_balance;
                                axios.put('api/wallets/' + this.wallet_dest.id, this.wallet_dest).then(response => {
                                    console.log(response.data);
                                    this.sendMessageTo(this.movement.wallet_id);
                                    this.successMessage = "Movement saved with success";
                                    this.showSuccess = true;
                                    ///redireciona para a pagina movements
                                    setTimeout(() => {
                                        this.$router.push("/")}, 1000);
                                }).catch(error => {
                                    console.log(error);
                                });
                            })
                                .catch(error => {
                                    console.log(error);
                                });
                        }

                        if(this.movement.type==='e' && this.isUser){
                            axios.post('api/movements/', this.movement).then(response => {
                                console.log(response.data);
                                Object.assign(this.movement, response.data);
                                console.log(this.movement.id);
                                this.wallet_source.balance = this.movement.end_balance;
                                return axios.put('api/wallets/' + this.wallet_source.id, this.wallet_source);
                            }).then(response => {
                                console.log(response.data);
                                if(this.movement.transfer===true){
                                this.saveMovimentPair();
                                }
                                this.successMessage = "Movement saved with success";
                                this.showSuccess = true;
                                ///redireciona para a pagina movements
                                setTimeout(() => {
                                    this.$router.push("/virtualWallet")}, 400);
                            }).catch(error=>{
                                console.log(error);
                            })
                        }

                        this.submitStatus = 'PENDING';
                    setTimeout(() => {
                        this.submitStatus = 'OK'
                    }, 500)
                }


            } ,
            saveMovimentPair: function () {
                    this.movement_dest.transfer=true;
                    this.movement_dest.id = '';
                    this.movement_dest.date = this.movement.date;
                //console.log(this.movement.date);
                //onsole.log(this.movement_dest.date);
                    this.movement_dest.type = 'i';
                    this.movement_dest.description = '';
                    this.movement_dest.category_id = null;
                    this.movement_dest.wallet_id = this.wallet_dest.id;
                    this.movement_dest.transfer_wallet_id = this.wallet_source.id;
                    this.movement_dest.transfer_movement_id = this.movement.id;
                    this.movement_dest.start_balance = this.wallet_dest.balance;
                    this.movement_dest.source_description = this.movement.source_description;
                    this.movement_dest.value=this.movement.value;
                    this.movement_dest.end_balance = parseFloat(this.movement_dest.start_balance) + parseFloat(this.movement_dest.value);
                    this.wallet_dest.balance = this.movement_dest.end_balance;
                    console.log("so p ver");
                    console.log(this.movement);
                    console.log(this.movement_dest);
                axios.post('api/movements/', this.movement_dest).then(response => {
                    Object.assign(this.movement_dest, response.data);
                    this.movement.transfer_movement_id=this.movement_dest.id;
                    return axios.put('api/movements/'+this.movement.id,this.movement);
                    }).then(response=>{
                    console.log(response.data);
                    return axios.put('api/wallets/'+this.wallet_dest.id,this.wallet_dest);
                    }).then(response=>{
                    this.sendMessageTo(this.movement.transfer_wallet_id);
                    console.log(response.data);
                }).catch(error=>{
                    console.log(error);
                });
                /////////////redireciona para a pagina movement
             /*   this.successMessage = "Movement saved with success";
                this.showSuccess = true;
                setTimeout(() => {
                        this.$router.push("/")}, 1000);*/

            },
            cancelAdd(){
                this.wallets=null;

                this.wallet_source.id='';
                this.wallet_source.balance='';

                this.wallet_dest.id='';
                this.wallet_dest.balance='';

                this.movement.id='';
                this.movement.wallet_id='';
                this.movement.type='';
                this.movement.transfer=false,
                this.movement.transfer_movement_id='';
                this.movement.transfer_wallet_id='';
                this.movement.type_payment=null;
                this.movement.category_id=null;
                this.movement.iban='';
                this.movement.mb_entity_code='';
                this.movement.mb_payment_reference='';
                this.movement.description='';
                this.movement.source_description='';
                this.movement.date='';
                this.movement.start_balance='';
                this.movement.end_balance='';
                this.movement.value='';

                this.movement_dest.id='';
                this.movement_dest.wallet_id='';
                this.movement_dest.type='';
                this.movement_dest.transfer=false,
                this.movement_dest.transfer_movement_id='';
                this.movement_dest.transfer_wallet_id='';
                this.movement_dest.type_payment=null,
                this.movement_dest.category_id=null;
                this.movement_dest.iban='';
                this.movement_dest.mb_entity_code='';
                this.movement_dest. mb_payment_reference='';
                this.movement_dest.description='';
                this.movement_dest.source_description='';
                this.movement_dest.date='';
                this.movement_dest.start_balance='';
                this.movement_dest.end_balance='';
                this.movement_dest.value="";
                this.categories = null;

                setTimeout(() => {
                    this.$router.push("/virtualWallet")}, 10);
            }




        },
        mounted() {
            if(this.$store.state.user.type==='u'){
                this.getSourceWallet();
            }
            this.getWallets();

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
                if((this.movement.transfer===true && this.isUser)|| this.isOperator){
                    return true;
                } else{
                    return false;
                }
            },


        }


    }
</script>

<style scoped>
    .error {
        display: block;
        color: #f57f6c;
    }
</style>
