<template>
 <div class="regist-page">
  <div class="form">
    <div class="alert" :class="messageType" v-if="showMessage">
            <strong>{{ message }}</strong>
        </div>

    <form class="login-form">
      <img  v-bind:src="itemImageURL(userLogin.photo)" width="110" height="110" alt="" >
      <h3>Edit Profile</h3><label v-text="userLogin.email"></label>
                
                <div id="div">
                    <label>Name</label>
                    <input type="text" placeholder="name" v-model="$v.user.name.$model" >
                    <div class="error" v-if="!$v.user.name.required">Field is required</div>
                    <div class="error" v-if="!$v.user.name.minLength">Name must have at least {{$v.user.name.$params.minLength.min}} letters.</div>
                </div>

                <div  id="div" v-if="userLogin.type =='u'">
                    <label>NIF</label>
                    <input type="number" placeholder="NIF" v-model="$v.user.nif.$model"> 
                    <div class="error" v-if="!$v.user.nif.required">Field is required</div>
                    <div class="error" v-if="!$v.user.nif.minLength">NIF must have at least {{$v.user.nif.$params.minLength.min}} numbers.</div> 
                </div>

                <div  id="div" v-if="userLogin.type =='a' || userLogin.type =='o'">
                    <label>NIF</label>
                    <input type="number" placeholder="NIF" v-model="$v.user.nif.$model"> 
                    <div class="error" v-if="!$v.user.nif.minLength">NIF must have at least {{$v.user.nif.$params.minLength.min}} numbers.</div> 
                </div>

                <div id="div">
                    <label>Select a photo from your computer storage</label>                   
                    <input class="form-data" name="photo" accept="image/*" type="file" @change="onFileSelected">
                </div>

                <div id="div" >
                    <label>Old pasword</label>
                    <input type="password" placeholder="old password" v-model="$v.user.old_password.$model">
                    
                    <div class="error" v-if="!$v.user.old_password.required ">Field is required</div>
                    <!-- <div class="error" v-if="!$v.user.old_password.sameAsPass">Don´t match with your old password.</div> -->
                    <div class="error" v-if="!$v.user.old_password.minLength">Password must have at least {{$v.user.old_password.$params.minLength.min}} digits.</div> 

                </div>
                <div id="div">
                    <label>New password</label>
                    <input type="password" placeholder="new password" v-model="$v.user.password.$model">
                    <div class="error" v-if="!$v.user.password.required ">Field is required</div>
                    <div class="error" v-if="!$v.user.password.minLength">Password must have at least {{$v.user.password.$params.minLength.min}} digits.</div> 
                </div>
                <div id="div">
                    <label>Confirm new password</label>
                    <input type="password" placeholder="confirm password" v-model="$v.user.password_confirmation.$model">
                    
                    <div class="error" v-if="!$v.user.password_confirmation.required ">Field is required</div>
                    <div class="error" v-if="!$v.user.password_confirmation.sameAsPassword">Don´t match with password you entered before.</div>
                </div>

              <div id="div">
              <button @click.prevent="saveUser()">Save Profile</button>
              </div>

    </form>
  </div>
</div>
</template>
<script type="text/javascript">
import axios from 'axios';
import {maxLength, email, required, minLength, sameAs, requiredIf } from 'vuelidate/lib/validators'
export default {
    name : 'Edit',
    data() {
      return {
        user: {
          name: '',
          email:'',
          nif:'',
          password: '',
          password_confirmation: '',
          old_password: '',        
        },
        currentUser:"",
        messageType: "alert-success",
        showMessage: false,
        message: "",
      }
      },
      validations:{
          user:{
            name: {
                    required,
                    minLength: minLength(4),
                },

                nif: {
                    required,
                    minLength: minLength(9),
                },
                old_password: {                       
                        minLength: minLength(3),

                        required: requiredIf(function(user){
                      return this.user.password != '' && this.user.password_confirmation != '';
                    }),

                        sameAsPass: sameAs(function(userLogin){
                      return this.userLogin.password;
                    }),
                },

                password: {
                    required: requiredIf(function(user){
                      return this.user.old_password != '' && this.user.password_confirmation != '';
                    }),

                    minLength: minLength(3)
                },
                
                password_confirmation: {
                    required: requiredIf(function(user){
                      return this.user.old_password != '' && this.user.password != '';
                    }),
                    
                    sameAsPassword: sameAs('password')
                }
      },
                
      },
                
      methods:{

         onFileSelected(event){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(event.target.files[0]);
                fileReader.onload=(event)=>{
                    this.userLogin.photo=event.target.result;
                }

            },
        itemImageURL(photo){
                return "storage/fotos/"+String(photo);

             },
        saveUser(){
              this.user.name = this.userLogin.name;
              this.user.email = this.userLogin.email;
              this.user.nif = this.userLogin.nif;
              console.log(this.user)
              axios.patch('/api/users/'+this.userLogin.id, this.user)
                .then(response => {
                                    
                    console.log(response)
                    this.showMessage = true;
                    this.message = 'Edit completed with success';
                    }).catch(error=>{
                                console.log(error);
                            });
                                setTimeout(() => {
                            this.$router.push("/")
                        }, 1000);                
            //  if(this.userLogin.password===this.repeatPassword && this.newPassword===this.confirmPassword){


            //             this.newPassword = this.userLogin.password;
                         
            //             this.userLogin.active=1;
            //             console.log(this.currentUser);
            //             axios.put('/api/users/' + this.userLogin.id, this.userLogin)
            //                 .then(response => {
                                
            //                     Object.assign(this.currentUser, response.data);
            //                     this.showMessage = true;
            //                     this.message = 'Edit completed with success';

            //                 }).catch(error=>{
            //                     console.log(error);
            //                 });
            //                     setTimeout(() => {
            //                 this.$router.push("/")
            //             }, 1000);                

            //  }

        },
         cancelEdit(){
             this.showSuccess = false;
            this.editingUser = false;
            axios.get('api/users/'+this.currentUser.id)
                .then(response=>{
                    console.dir (this.currentUser);
                     // Copies response.data.data properties to this.currentUser
                     // without changing this.currentUser reference
                     Object.assign(this.currentUser, response.data.data);
                     console.dir (this.currentUser);
                     this.currentUser = null;
                 });
         },
},
      computed: {
        userLogin() {
            return this.$store.state.user;
        },
        autenticatedUser() {
            return this.$store.getters.getAuthUser
        },

        
      },
      mounted(){
          this.user.name = this.$store.state.user.name;
          this.user.nif= this.$store.state.user.nif;
        }
}
</script>

<style scoped lang="scss">
 @import url(https://fonts.googleapis.com/css?family=Roboto:300);

.login-page {
  width: 500px;
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 2;
  background: #FFFFFF;
  max-width: 500px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
  width: 450px;
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
  padding: 2px;
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

    #div{
        margin-top: 23px;
    }

</style>
