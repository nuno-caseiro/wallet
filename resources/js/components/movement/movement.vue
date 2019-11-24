<template>
<div>
    <movement-add :wallets="wallets"></movement-add>


</div>

</template>

<script>
    export default {

        data(){
            return{
                wallets:[],

            }
        },
        methods:{
            getWallets: function () {
                axios.get('api/wallets').then(response=>{
                    this.wallets=response.data.data;

                })
            }
        },
        mounted() {
            this.getWallets();
        }
    }
</script>

<style scoped>

</style>
