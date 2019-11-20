<template>
    <div>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Virtual Wallet</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a><router-link class="nav-item nav-link" to="items"></router-link></a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <!-- <li v-if="isAuthenticated" class="navbar-item">
                    <a class="nav-item nav-link">{{loggedUser.name}}: {{shiftStatus}}</a>v-if="!isAuthenticated"
                </li> -->
                <li class="navbar-item">
                    <router-link class="nav-item nav-link" to="login" >Login</router-link>
                    <!-- <router-link class="nav-item nav-link" to="logout" v-else>Logout</router-link> -->
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
            name: "navbar",
        }  
    },
    methods: {

    },
    }
          
</script>

<style scoped>

</style>
