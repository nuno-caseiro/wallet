<template>
    <div>
        <br>
        <div class="alert" :class="typeofmsg" v-if="showMessage">             
            <strong>{{ message }}</strong>
        </div>
        <div class="jumbotron">
            <h2>Do you really want to logout?</h2>
            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="logout">Confirm</a>
                <a class="btn btn-primary" v-on:click.prevent="">Go back</a>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">    
    export default {
        data: function(){
            return { 
                typeofmsg: "alert-success",
                showMessage: false,
                message: ""
            }
        },
        methods: {
            logout() {
                this.showMessage = false;
                axios.post('api/logout')
                    .then(response => {
                        //this.$socket.emit('user_exit', this.$store.state.user);
                        this.$store.commit('clearUserAndToken');
                        this.typeofmsg = "alert-success";
                        this.message = "User has logged out correctly";
                        this.showMessage = true;
                        setTimeout(() => {
                            this.$router.push("/")
                        }, 1000);
                    })
                    .catch(error => {
                        this.$store.commit('clearUserAndToken');
                        this.typeofmsg = "alert-danger";
                        this.message = "Logout incorrect. But local credentials were discarded";
                        this.showMessage = true;
                        console.log(error);
                    })            
                }
        }
    }
</script>
<style scoped>
.btn-primary{
    background-color: orange;
    border-color: orange;
}
</style>