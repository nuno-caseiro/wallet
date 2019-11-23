<template>

    <movement-add></movement-add>

</template>

<script>
    import MovementAdd from "./movementAdd";
    export default {
        components: {MovementAdd},
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

        }
    }
</script>

<style scoped>

</style>
