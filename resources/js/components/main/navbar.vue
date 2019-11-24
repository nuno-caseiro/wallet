<template>
    <div>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark" id="navbar">
            <a class="navbar-brand" href="/">Virtual Wallet</a>
            <!-- <a class="navbar-brand" href="/"><img src = https://www.pnc.com/content/dam/pnc-com/images/personal/Checking/VirtualWallet/overview/vw_overview_intro.svg > </a> -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <b-dropdown text="Movements" variant="outline-warning" class="m-2" v-if="isAuthenticated">
                <b-dropdown-item>Add Movement</b-dropdown-item>
                <b-dropdown-item><router-link class="nav-item nav-link" to="movementList">Movement List</router-link></b-dropdown-item>
                <b-dropdown-item>Third Action</b-dropdown-item>
                <!-- <b-dropdown-divider></b-dropdown-divider> -->
                <!-- <b-dropdown-item active>Active action</b-dropdown-item>
                <b-dropdown-item disabled>Disabled action</b-dropdown-item> -->
            </b-dropdown>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">    
                    

                </ul>
                     <ul class="navbar-nav">
                         <a  v-if="isAuthenticated" class="navbar-brand" href="#">
                            <img  v-bind:src="itemImageURL(getAutenticatedUser.photo)" width="30" height="30" alt="">
                         </a>
                         <li v-if="isAuthenticated" class="navbar-item">
                             <router-link class="nav-item nav-link" to="edit">User Name: {{getAutenticatedUser.name}}</router-link>
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

             }
         },
         methods: {
            itemImageURL(photo){
                return "storage/fotos/"+String(photo);
             
             },
         },
         computed: {
             isAuthenticated() {
                 return this.$store.getters.isAuthenticated;
             },
             getAutenticatedUser(){
                 return this.$store.getters.getAuthUser;
             }

             },
         }


     </script>

     <style  scoped lang="scss">
      @import url(https://fonts.googleapis.com/css?family=Roboto:300);

     #navbar{
         font-family: "Roboto", sans-serif;
     }
     </style>
