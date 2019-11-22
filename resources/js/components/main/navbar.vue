<template>
    <div>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark" id="navbar">
            <a class="navbar-brand" href="/">Virtual Wallet</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                 <router-link class="nav-item nav-link" to="editProfile" v-if="isAuthenticated"  v-on:click.prevent="editProfile" >Edit Profile</router-link>
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
        data()  {
        return{
            name: "Navbar",
            currentUser:null,
            showSuccess:false,
        }  
    },
    methods: {
        editProfile(user){
            this.currentUser = user
            this.showSuccess = false
        },
    },
    computed: {
        isAuthenticated() {
            return this.$store.getters.isAuthenticated
        },
    }
    }
    
          
</script>

<style scoped>
.navbar-brand{
    font-size: 28px
}

#navbar{
    font-size: 20px;
    font-family: "Roboto", sans-serif;
    height:65px;
}
</style>
