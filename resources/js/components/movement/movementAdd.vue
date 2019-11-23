<template>
    <div class="login-page">
        <div class="form">
            <div class="alert" :class="messageType" v-if="showMessage">
                <strong>{{ message }}</strong>
            </div>
            <div class="jumbotron">
                <h2>Movement</h2>
                <v-select :wallets="wallets"></v-select>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['wallets'],
        data(){
            return{
                wallet_email:'',
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
                 }

                }

            },

    }
</script>

<style scoped>

</style>
