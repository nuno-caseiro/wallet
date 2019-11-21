
<template>
  <div>
      <p class="homeText">
          Welcome to Virtual Wallet
          <img src = https://www.pnc.com/content/dam/pnc-com/images/personal/Checking/VirtualWallet/overview/vw_overview_intro.svg>
      </p>
      <p id="numberOfWallets">There are {{numberWallets}} number of wallets</p>


  </div>
</template>
<script>
export default {
  name: 'Home',
    data(){
      return{
          numberWallets: ''
      }
    },
    methods:{
        getNumber: function () {
            axios.get('api/wallets').then(response=>{
                this.numberWallets=response.data.data.length;
            })
        }
    },
    mounted(){
      this.getNumber();
    }
};
</script>
<style scoped>
.homeText{
    font-family: "Roboto", sans-serif;
    font-size: 45px;
    color: rgb(90, 90, 90);
    text-align: center;
    position: relative;
    top:100px;
    
}
#numberOfWallets{
    font-family: "Roboto", sans-serif;
    color: rgb(90, 90, 90);
    font-size: 20px;
    position: relative;
    left: 300px;
}
</style>
