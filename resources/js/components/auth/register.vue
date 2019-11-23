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
                <input class="form-data" name="photo" accept="image/*" type="file" @change="onFileSelected">
                <input type="password" placeholder="password" v-model="user.password">
                <input type="password" placeholder="confirm password" v-model="user.password_confirmation">
                <button v-on:click.prevent="register">Register</button>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import axios from 'axios';
    export default {
        name : 'Register',
        data() {
            return {
                user:{
                    name: '',
                    email: '',
                    type:'',
                    active:'',
                    nif: '',
                    photo: null,
                    password: '',
                    password_confirmation: '',
                },
                wallet:{
                    id:'',
                    email:'',
                    balance:'',

                },
                errors:{
                    name:[],
                    email: [],
                    password: [],
                    password_confirmation: [],
                },
                messageType: "alert-success",
                showMessage: false,
                message: "",
            }
        },
        methods:{
            onFileSelected(event){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(event.target.files[0]);
                fileReader.onload=(event)=>{
                    this.user.photo=event.target.result;
                }

            },
            register(){
                if(this.user.password===this.user.password_confirmation){
                    this.user.active=1;
                    this.user.type='u';
                    console.log(this.user);
                    axios.post('/api/users', this.user)
                        .then(response => {

                            Object.assign(this.user, response.data);
                            this.$emit('item-saved', this.user);
                            this.showMessage = true;
                            this.message = 'Account created';
                            console.log(this.user.id);

                        }).then(response=>{
                        this.wallet.id=this.user.id;
                        this.wallet.email=this.user.email;
                        this.wallet.balance=0;

                        axios.post('/api/wallets',this.wallet).then(response=>{
                            console.log(this.wallet.id);
                            Object.assign(this.wallet, response.data);
                            this.$router.push("/");

                        }).catch(error=>{
                            console.log(error);
                        });

                    }).catch(error=>{
                        console.log(error);
                    });
                }else{
                    this.showMessage=true;
                    this.message="Your passwords don't match";
                }


            },
        }


    }
</script>



<style scoped lang="scss">
    @import url(https://fonts.googleapis.com/css?family=Roboto:300);

    .login-page {
        width: 360px;
        padding: 8% 0 0;
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
        margin: 0 0 15px;
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
</style>
