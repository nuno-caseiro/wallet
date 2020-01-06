<template>
    <div class="login-page">
        <div class="form">
            <div class="alert" :class="messageType" v-if="showMessage">
                <strong>{{ message }}</strong>
            </div>

            <div class="alert-danger" :class="messageType" v-if="showMessageDanger">
            <strong>{{ messageDanger }}</strong>
        </div>

            <div class="login-form">
                <h2>Register</h2>


                <div class="div">
                    <label>Name</label>
                    <input type="text" placeholder="name" v-model="$v.user.name.$model" >
                    <div v-if="$v.user.name.$error">
                        <div class="error" v-if="!$v.user.name.required">Field is required</div>
                        <div class="error" v-if="!$v.user.name.minLength">Name must have at least. {{$v.user.name.$params.minLength.min}} letters.</div>
                        <div class="error" v-if="!$v.user.name.nameValid">Name have only have letters.</div>
                    </div>
                </div>

                <div  class="div">
                    <label>E-mail</label>
                    <input type="text" placeholder="email" v-model="$v.user.email.$model" >
                    <div v-if="$v.user.email.$error">
                        <div class="error" v-if="!$v.user.email.required">Field is required</div>
                        <div class="error" v-if="!$v.user.email.email">E-mail must be valid</div>
                    </div>
                </div>

                <div  class="div">
                    <label>NIF</label>
                    <input type="number" placeholder="NIF" v-model="$v.user.nif.$model">
                    <div v-if="$v.user.nif.$error">
                        <div class="error" v-if="!$v.user.nif.required">Field is required</div>
                        <div class="error" v-if="!$v.user.nif.minLength">NIF must have 9 numbers.</div>
                        <div class="error" v-if="!$v.user.nif.maxLength">NIF must have 9 numbers.</div>
                    </div>
                </div>

                <div class="div">
                    <label>Select a photo from your computer storage</label>
                    <input class="form-data" name="photo" accept="image/*" type="file" @change="onFileSelected">
                </div>

                <div class="div">
                    <label>Password</label>
                    <input type="password" placeholder="password" v-model="$v.user.password.$model">
                    <div v-if="$v.user.password.$error">
                    <div class="error" v-if="!$v.user.password.required">Field is required</div>
                    <div class="error" v-if="!$v.user.password.minLength">Password must have at least {{$v.user.password.$params.minLength.min}} digits.</div>
                    </div>
                </div>

                <div class="div">
                    <label>Password Confirmation</label>
                    <input type="password" placeholder="confirm password" v-model="$v.password_confirmation.$model">
                    <div v-if="$v.password_confirmation.$error">
                        <div class="error" v-if="!$v.password_confirmation.required">Field is required</div>
                        <div class="error" v-if="!$v.password_confirmation.sameAsPassword">Don´t match with password you entered before.</div>
                    </div>
                </div>

                <div class= "div">
                   <button v-on:click.prevent="register">Register</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import axios from 'axios';
    import { numeric,email, required, minLength, sameAs, maxLength } from 'vuelidate/lib/validators';
    const regex = /^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/
    export default {
        name : 'Register',
        data() {
            return {
                user:{
                    id:'',
                    name: '',
                    email: '',
                    type:'',
                    active:'',
                    nif: '',
                    photo: null,
                    password: '',



                },
                password_confirmation: '',
                wallet:{
                    id:'',
                    email:'',
                    balance:'',

                },
                submitStatus: null,
                messageType: "",
                showMessage: false,
                showMessageDanger: false,
                message: "",
                messageDanger: "",
            }
        },
        validations:{
            user:{
                name: {
                    required,
                    minLength: minLength(4),
                    nameValid(name) {
                      return regex.test(name);
                    },
                },

                email: {
                    required,
                    email,
                },

                nif: {
                    required,
                    numeric,
                    minLength: minLength(9),
                    maxLength: maxLength(9)
                },


                password: {
                    required,
                    minLength: minLength(3)
                },

            },
            password_confirmation: {
                    required,
                    sameAsPassword: sameAs(function(password){
                      return this.user.password;
                    }),
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
                console.log('submit!');
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.submitStatus = 'ERROR';
                } else {
                        if(this.user.password===this.password_confirmation){
                            this.user.active=1;
                            this.user.type='u';
                            console.log(this.user);
                            axios.post('/api/users', this.user)
                                .then(response => {

                                    Object.assign(this.user, response.data);
                                    this.$emit('user-saved', this.user);
                                    this.showMessage = true;
                                    this.messageType= "alert-success",
                                    this.message = 'Register completed with success';
                                    console.log(this.user.id);

                                }).then(response=>{
                                console.log(this.user.id);
                                this.wallet.id=this.user.id;
                                this.wallet.email=this.user.email;
                                this.wallet.balance=0;

                                axios.post('/api/wallets',this.wallet).then(response=>{
                                    console.log(this.wallet.id);
                                    Object.assign(this.wallet, response.data);
                                    setTimeout(() => {
                                this.$router.push("login")
                            }, 1000);

                                }).catch(error=>{
                                    console.log(error);
                                });

                            }).catch(error=>{
                                console.log(error.response);
                                if(error.response.data.errors.email && error.response.data.errors.nif){
                                    //this.$emit('user-saved', this.user);
                                    this.showMessage = true;
                                    this.messageType = "alert-danger"
                                    this.message = 'Email and NIF already exists';
                                }else{
                                    if(error.response.data.errors.email){
                                        //this.$emit('user-saved', this.user);
                                        this.showMessage = true;
                                        this.messageType = "alert-danger"
                                        this.message = 'Email already exists';
                                }else{
                                    if(error.response.data.errors.nif){
                                        //this.$emit('user-saved', this.user);
                                        this.showMessage = true;
                                        this.messageType = "alert-danger"
                                        this.message = 'NIF already exists';
                                    }
                                }
                                } 
                            });
                            this.submitStatus = 'PENDING';
                    setTimeout(() => {
                        this.submitStatus = 'OK'
                    }, 500)
                }
                        }
                // else{
                //     this.showMessageDanger=true;
                //     this.messageDanger="Your passwords don't match";
                // }


            },
        }


    }
</script>



<style scoped lang="scss">
    @import url(https://fonts.googleapis.com/css?family=Roboto:300);

    .login-page {
        width: 500px;
        padding: 1% 0 0;
        margin: auto;
    }
    .form {
        position: relative;
        z-index: 1;
        background: #FFFFFF;
        max-width: 500px;
        // margin: 0 auto 100px;
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
        margin:auto;
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
        margin-top: 23px;
    }




</style>
