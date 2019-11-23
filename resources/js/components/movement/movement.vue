<template>

    <movement-add :wallets="wallets"></movement-add>

</template>

<script>
    import MovementAdd from "./movementAdd";
    export default {
        components: {

            'movement-add':MovementAdd
        },
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
