<template>
    <div>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark" id="navbar" v-if="renderComponent">
            <a class="navbar-brand" href="/">Virtual Wallet</a>
            <!-- <a class="navbar-brand" href="/"><img src = https://www.pnc.com/content/dam/pnc-com/images/personal/Checking/VirtualWallet/overview/vw_overview_intro.svg > </a> -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a><b-button size="lg" variant="secondary" to="virtualWallet"  v-if="isAuthenticated && isUser && (this.$store.state.user.active)===1">
                Virtual Wallet</b-button></a>
            <a><b-button size="lg" variant="secondary" to="users"  v-if="isAuthenticated && isAdmin">Users</b-button></a>
            <a><b-button size="lg" variant="secondary" to="movementAdd"  v-if="isAuthenticated && isOperator">Add Movements</b-button></a>
            <a id="statistics"><b-button size="lg" variant="secondary" to="statistics"  v-if="isAuthenticated &&(this.$store.state.user.active)===1 && isAdmin">
                Statistics</b-button></a>
            <a id="userStatistics"><b-button size="lg" variant="secondary" to="userStatistics"  v-if="isAuthenticated &&(this.$store.state.user.active)===1 && isUser">
                Statistics</b-button></a>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">

                </ul>
                     <ul class="navbar-nav">
                         <a  v-if="isAuthenticated" class="navbar-brand" href="#">
                            <img  v-bind:src="itemImageURL(!this.$store.state.user.photo == '' ? this.$store.state.user.photo : 'unknown.png')" width="30" height="30" alt="">
                         </a>
                         <li v-if="isAuthenticated" class="navbar-item">
                             <router-link class="nav-item nav-link" to="edit">{{this.$store.state.user.name}}</router-link>
                         </li>
                     </ul>
                 <ul class="navbar-nav">
                     <li class="navbar-item">
                         <router-link class="nav-item nav-link" to="login" v-if="!isAuthenticated">Login</router-link>
                         <router-link class="nav-item nav-link" to="logout" v-else>Logout</router-link>
                     </li>
                     <li class="navbar-item">
                         <router-link class="nav-item nav-link" to="register" v-if="!isAuthenticated">Register</router-link>
                     </li>
                 </ul>
               </div>
             </nav>
         </div>
     </template>
     <script type="text/javascript">

         export default {
             data: function() {
             return{
                 name: "Navbar",
                 renderComponent:true,

             }
         },
         methods: {
            itemImageURL(photo){
                return "storage/fotos/"+String(photo);

             },
             forceRerender(){
                this.renderComponent=false;

                this.nextTick(()=>{
                    this.renderComponent=true;
                });
             },
             getAutenticatedUser(){

                 return this.$store.getters.getAuthUser;
             }
         },
         computed: {
            isAuthenticated() {
                 return this.$store.getters.isAuthenticated;
            },
            isUser(){
                return this.$store.getters.isUser;
            },
            isOperator(){
                return this.$store.getters.isOperator;
            },
            isAdmin(){
                return this.$store.getters.isAdmin;
            },


             },
         }


     </script>

     <style  scoped lang="scss">
      @import url(https://fonts.googleapis.com/css?family=Roboto:300);

    #navbar{
         font-family: "Roboto", sans-serif;
    }

    #statistics{
        margin-left: 10px;
    }


     </style>
