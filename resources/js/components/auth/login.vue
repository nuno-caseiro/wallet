<template>
    <div class="login-page">
        <div class="form">
            <div class="alert" :class="typeOfMessage" v-if="showMessage">
                <strong>{{ message }}</strong>
            </div>
            <form class="login-form">
                <h2>Login</h2>
                <div class="div">
                    <input type="text" placeholder="email" v-model="$v.user.email.$model" >
                    <div v-if="$v.user.email.$error">
                        <div class="error" v-if="!$v.user.email.email">E-mail must be valid</div>
                        <div class="error" v-if="!$v.user.email.required">Field is required</div>
                    </div>
                </div>
                <div class="div">
                    <input type="password" placeholder="password" v-model="$v.user.password.$model">
                    <div v-if="$v.user.password.$error">
                        <div class="error" v-if="!$v.user.password.required">Field is required</div>
                        <div class="error" v-if="!$v.user.password.minLength">Password must have at least {{$v.user.password.$params.minLength.min}} letters.</div>
                    </div>
                </div>

                <div class="div">

                <button v-on:click.prevent="login()">Login</button>
                </div>
                <p class="message">Not registered?<router-link to="register" class="button"> Create an account</router-link></p>
                <!-- //TODO -->
            </form>
        </div>
    </div>
</template>

<script type="text/javascript">
    import { email, required, minLength } from 'vuelidate/lib/validators'
    import axios from 'axios';
    export default {
        name : 'Login',
        data() {
            return {
                user:{
                    email: '',
                    password: '',
                },
                submitStatus: null,
                typeOfMessage: "",
                showMessage: false,
                message: "",
                users:[],
                userEmail:'',

            }
        },
        validations:{
            user:{
                email:{
                    required ,
                    email,
                },
                password:{
                    required,
                    minLength: minLength(3)
                },
            }
        },

        methods:{
            login(){
                // this.getUser();
                // if(this.userEmail.active===1){
                    console.log('submit!');
                    this.$v.$touch();
                    if (this.$v.$invalid) {
                        this.submitStatus = 'ERROR';
                    } else {
                    axios.post('/api/login',this.user)
                        .then(response=>{
                            console.log(response);
                            let tokenType = response.data.token_type;
                            let token = response.data.access_token;
                            let expiration = response.data.expires_in + Date.now();
                            this.$store.commit('setToken', {token, tokenType, expiration});
                            this.typeOfMessage = "alert-success";
                            this.message = "Login Successful";
                            this.showMessage = true;
                            setTimeout(() => {
                                this.$router.push("/")
                            }, 1000);
                        //}
                        //,response=>{
                        // if(response.status==400){
                        //     this.typeOfMessage = "alert-danger";
                        //     this.message = "Error in your credentials or you are deactivated.";
                        //     this.showMessage = true;
                        //     console.log(console.status)
                        // }
                    })
                        .catch(error=>{
                            this.typeOfMessage = "alert-danger";
                            this.message = "Error in your credentials or you are deactivated.";
                            this.showMessage = true;
                                    console.log(error);
                        })
                        .then(response=>{
                        axios.get('api/user').then(response=>{
                            let user=response.data;
                            this.$store.dispatch('setAuthUser',user);
                            this.$socket.emit('user_enter', this.$store.state.user);
                            console.log(this.$store.state.user);
                        })
                        
                    })
                        this.submitStatus = 'PENDING';
                        setTimeout(() => {
                            this.submitStatus = 'OK'
                        }, 500)
                    }
                
                // }else{
                //     this.typeOfMessage = "alert-success";
                //     this.message = "Login Blocked";
                //     this.showMessage = true;
                // }
            },

            getUser(){
                axios.get('api/user/email/' + this.user.email)
                .then(response=>{
                    this.userEmail = response.data.data;
                })
            }
        },
    }
</script>



<style scoped lang="scss">
    @import url(https://fonts.googleapis.com/css?family=Roboto:300);

    .login-page {
        max-width: 360px;
        padding: 1% 0 0;
        margin: auto;
    }
    .form {
        position: relative;
        z-index: 1;
        background: #FFFFFF;
        max-width: 360px;
        margin: 0 auto 100px;
        padding: 45px;
        text-align: center;
        box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
    }
    .form input {
        font-family: "Roboto", sans-serif;
        outline: 0;
        background: #f2f2f2;
        width: 100%;
        border: 0;
        margin: 0 0 0px;
        padding: 15px;
        box-sizing: border-box;
        font-size: 14px;
    }
    .form button {
        font-family: "Roboto", sans-serif;
        text-transform: uppercase;
        outline: 0;
        background: rgb(167, 167, 167);
        width: 100%;
        border: 0;
        padding: 15px;
        color: #FFFFFF;
        font-size: 14px;
        -webkit-transition: all 0.3 ease;
        transition: all 0.3 ease;
        cursor: pointer;
    }
    .form button:hover,.form button:active,.form button:focus {
        background: #ff9100;
    }
    .form .message {
        margin: 15px 0 0;
        color: #b3b3b3;
        font-size: 12px;
    }
    .form .message a {
        color: #ff9100;
        text-decoration: none;
    }
    .form .register-form {
        display: none;
    }
    .container {
        position: relative;
        z-index: 1;
        max-width: 300px;
        margin: 0 auto;
    }
    .container:before, .container:after {
        content: "";
        display: block;
        clear: both;
    }
    .container .info {
        margin: 50px auto;
        text-align: center;
    }
    .container .info h1 {
        margin: 0 0 15px;
        padding: 0;
        font-size: 36px;
        font-weight: 300;
        color: #1a1a1a;
    }
    .container .info span {
        color: #4d4d4d;
        font-size: 12px;
    }
    .container .info span a {
        color: #000000;
        text-decoration: none;
    }
    .container .info span .fa {
        color: #EF3B3A;
    }
    body {
        background: #ff9100; /* fallback for old browsers */
        background: -webkit-linear-gradient(right, #ff9100, #ff9100);
        background: -moz-linear-gradient(right, #ff9100, #ff9100);
        background: -o-linear-gradient(right, #ff9100, #ff9100);
        background: linear-gradient(to left, #ff9100, #ff9100);
        font-family: "Roboto", sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .error {
        display: block;
        color: #f57f6c;
    }

    .div{
        margin-top:23px;
    }

</style>
