<template>
 <div class="regist-page">
  <div class="form">
    <div class="alert" :class="messageType" v-if="showMessage">
            <strong>{{ message }}</strong>
        </div>

    <form class="login-form">
      <img  v-bind:src="itemImageURL(userLogin.photo)" width="110" height="110" alt="" >
      <h3>Edit Profile</h3><label v-text="userLogin.email"></label>

                <div class="div">
                    <label>Name</label>
                    <input type="text" placeholder="name" v-model="$v.user.name.$model" >
                    <div v-if="$v.user.name.$error">
                      <div class="error" v-if="!$v.user.name.required">Field is required</div>
                      <div class="error" v-if="!$v.user.name.minLength">Name must have at least {{$v.user.name.$params.minLength.min}} letters.</div>
                      <div class="error" v-if="!$v.user.name.nameValid">Name have only have letters.</div>
                    </div>
                </div>

                <div  class="div" v-if="userLogin.type =='u'">
                    <label>NIF</label>
                    <input type="number" placeholder="NIF" v-model="$v.user.nif.$model">
                    <div v-if="$v.user.nif.$error">
                      <div class="error" v-if="!$v.user.nif.required">Field is required</div>
                      <div class="error" v-if="!$v.user.nif.minLength">NIF must have 9 digits.</div>
                      <div class="error" v-if="!$v.user.nif.maxLength">NIF must have 9 digits.</div>
                    </div>
                </div>

                <div  class="div" v-if="userLogin.type =='a' || userLogin.type =='o'">
                    <label>NIF</label>
                    <input type="number" placeholder="NIF" v-model="$v.user.nif.$model">
                    <div v-if="$v.user.nif.$error">
                      <div class="error" v-if="!$v.user.nif.nifValid">NIF must have 9 digits.</div>
                    </div>
                </div>

                <div class="div">
                    <label>Select a photo from your computer storage</label>
                    <input class="form-data" name="photo" accept="image/*" type="file" @change="onFileSelected">
                </div>

                <div class="div">
                    <label for="transfer">Change Password</label>
                    <input type="checkbox" id="transfer" v-model="change">
                </div>

                <div class="div" v-if='change === true'>
                    <label>Old pasword</label>
                    <input type="password" placeholder="old password" v-model="$v.user.old_password.$model">
                    <div v-if="$v.user.old_password.$error">
                      <div class="error" v-if="!$v.user.old_password.required ">Field is required</div>
                      <div class="error" v-if="!$v.user.old_password.minLength">Password must have at least {{$v.user.password.$params.minLength.min}} digits.</div>
                    </div>
                </div>
                <div class="div" v-if='change === true'>
                    <label>New password</label>
                    <input type="password" placeholder="new password" v-model="$v.user.password.$model">
                    <div v-if="$v.user.password.$error">
                      <div class="error" v-if="!$v.user.password.required ">Field is required</div>
                      <div class="error" v-if="!$v.user.password.minLength">Password must have at least {{$v.user.password.$params.minLength.min}} digits.</div>
                    </div>
                </div>
                <div class="div" v-if='change === true'>
                    <label>Confirm new password</label>
                    <input type="password" placeholder="confirm password" v-model="$v.user.password_confirmation.$model">
                    <div v-if="$v.user.password_confirmation.$error">
                      <div class="error" v-if="!$v.user.password_confirmation.required ">Field is required</div>
                      <div class="error" v-if="!$v.user.password_confirmation.sameAsPassword">Don´t match with password you entered before.</div>
                    </div>
                </div>

              <div class="div">
              <button @click.prevent="saveUser()">Save Profile</button>
              </div>

              <div class="div">
              <button @click.prevent="cancelEdit()">Cancel</button>
              </div>

    </form>
  </div>
</div>
</template>
<script type="text/javascript">
import axios from 'axios';
import {helpers, maxLength, email, required, minLength, sameAs, requiredIf } from 'vuelidate/lib/validators'
const regex = /^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/

export default {
    name : 'Edit',
    data() {
      return {
        change: false,
        nifRequired: false,
        user: {
          name: '',
          email:'',
          nif:'',
          old_password: '',
          password: '',
          password_confirmation: '',
          photo: '',

        },
        currentUser:"",
        messageType: "",
        showMessage: false,
        message: "",
        submitStatus: null,
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

                nif: {
                    required: requiredIf(function(nifRequired){
                      return this.nifRequired === true;
                    }),
                    minLength: minLength(9),
                    maxLength: maxLength(9),


                },
                old_password: {


                    required: requiredIf(function(change){
                    return this.change === true;
                    }),

                    minLength: minLength(3),
                },

                password: {
                    required: requiredIf(function(change){
                      return this.change === true;
                    }),

                    minLength: minLength(3)
                },

                password_confirmation: {
                    required: requiredIf(function(change){
                      return this.change === true;
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
                    this.user.photo = event.target.result;
                }

            },
        itemImageURL(photo){
                return "storage/fotos/"+String(photo);

             },
        saveUser(){
              console.log('submit!');
              this.$v.$touch();
              if (this.$v.$invalid) {
                  this.submitStatus = 'ERROR';
              } else {


                    

                    ///////////////////Pedido com Alteracao da Pass/////////////////////////////////
                    if(this.change === true){
                    axios.patch('/api/users/'+this.userLogin.id, this.user)
                    .then(response => {
                        this.messageType = "alert-success"
                        this.showMessage = true;
                        this.message = 'Success, please login AGAIN!!';
                        setTimeout(() => {
                                // this.$router.push("login")
                                this.logout();
                        }, 1500);
                        }).catch(error=>{
                          console.log(error.response.data.error)
                            if(error.response.data.error){
                                    this.showMessage = true;
                                    this.messageType = "alert-danger"
                                    this.message = 'Password Confirmation is not correct.';
                                }
                        });
                    }


                    ///////////////////Pedido sem Alteracao da Pass/////////////////////////////////
                    if(this.change === false){
                    this.$store.state.user.name = this.user.name;
                    this.$store.state.user.nif=this.user.nif;

                    axios.put('/api/withoutPass/users/'+this.userLogin.id,  this.$store.state.user)
                    .then(response => {
                        console.log(response);
                        this.messageType = "alert-success";
                        this.showMessage = true;
                        this.message = 'Success, please login AGAIN!!';
                        setTimeout(() => {
                                //this.$router.push("login")
                                this.logout();
                        }, 1500);
                        }).catch(error=>{
                          this.messageType = "alert-danger";
                            this.message = "";
                            this.showMessage = true;
                                    console.log(error);
                                });
                    }



                    this.submitStatus = 'PENDING';
                    setTimeout(() => {
                        this.submitStatus = 'OK'
                    }, 500)
                }

        },

        logout() {
                this.showMessage = false;
                axios.post('api/logout')
                    .then(response => {
                        this.$socket.emit('user_exit', this.$store.state.user);
                        this.$store.commit('clearUserAndToken');
                        this.typeofmsg = "alert-success";
                        this.message = "User has logged out correctly";
                        this.showMessage = true;
                        this.$router.push("/login")

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
          this.user = null;
                  setTimeout(() => {
                             this.$router.push("/")
                  }, 100);
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
          this.user.email = this.$store.state.user.email;
          if(this.$store.state.user.type === 'u'){
            this.nifRequired = true;
          }else{
            this.nifRequired = false;
          }
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

  .div{
    margin-top: 23px;
    }

</style>
