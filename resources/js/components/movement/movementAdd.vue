<template>
    <div class="login-page">
        <div class="form">
            <div class="alert" :class="messageType" v-if="showMessage">
                <strong>{{ message }}</strong>
            </div>
            <div class="login-form">
                <h2>Register</h2>
                <input type="text" placeholder="name" v-model="user.name" >
                <input type="text" placeholder="email" v-model="user.email" >
                <input type="text" placeholder="NIF" v-model="user.nif">

                <input type="password" placeholder="password" v-model="user.password">
                <input type="password" placeholder="confirm password" v-model="user.password_confirmation">
                <button v-on:click.prevent="register">Register</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['movement'],
        data(){
            return{

                }

            },

    }
</script>

<style scoped>

</style>
