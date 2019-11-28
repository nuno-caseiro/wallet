<template>
    <div>
        <br>
        <div class="alert" :class="typeofmsg" v-if="showMessage">
            <strong>{{ message }}</strong>
        </div>
        <div class="jumbotron">
            <h2>Do you really want to logout?</h2>
            <div class="form-group">
                <b-button-group>
                <b-button variant="outline-success" v-on:click.prevent="logout">Confirm</b-button>
                <b-button variant="outline-danger" v-on:click.prevent="cancelEdit">Go back</b-button>
                </b-button-group>
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
                        this.$socket.emit('user_exit', this.$store.state.user);
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
                },

            cancelEdit(){
                this.showSuccess = false;
                this.$router.push("/")
        },
        }
    }
</script>
<style scoped>
.btn-primary{
    background-color: rgb(37, 189, 82);
    border-color: rgb(37, 189, 82);
}
</style>
