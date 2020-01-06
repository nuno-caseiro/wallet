<template>
<div>
    
            <div class="alert" :class="messageType" v-if="showMessage">
                <strong>{{ message }}</strong>
            </div>

    <div class="jumbotron">
	    <h2>Add User</h2>
	    <div class="form-group">
	        <label for="inputName">Name</label>
	        <input type="text" class="form-control"  id="inputName" placeholder="Name" name="name" v-model="$v.user.name.$model"/>
            <div v-if="$v.user.name.$error">
                <div class="error" v-if="!$v.user.name.required">Field is required</div>
                <div class="error" v-if="!$v.user.name.minLength">Name must have at least {{$v.user.name.$params.minLength.min}} letters.</div> 
                <div class="error" v-if="!$v.user.name.nameValid">Name have only have letters.</div>
            </div>
        </div>
        
	    <div class="form-group">
	        <label for="inputEmail">Email</label>
	        <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="email" v-model="$v.user.email.$model"/>
            <div v-if="$v.user.email.$error">
                <div class="error" v-if="!$v.user.email.required">Field is required</div>
                <div class="error" v-if="!$v.user.email.email">E-mail must be valid</div>
            </div>
        </div>
        <div class="form-group">
            <label for="photo">Photo</label>
            <div>
            <input class="form-data" name="photo" accept="image/*" type="file" @change="onFileSelected">
            </div>
        </div>
        <div class="form-group">
                    <label for="userType">Choose user type</label>
                    <select class="form-control" id="userType" name="userType" v-model="$v.user.type.$model">
                        <option value="a">Administrator</option>
                        <option value="o">Operator</option>
                    </select>
                    <div v-if="$v.user.type.$error">
                        <div class="error" v-if="!$v.user.type.required">Field is required</div>
                    </div>
                </div>	    
        <div class="form-group">
	        <label for="inputNIF">Password</label>
	        <input type="password" class="form-control" id="inputPassword" name="nif" v-model="$v.user.password.$model"/>
            <div v-if="$v.user.password.$error">
                <div class="error" v-if="!$v.user.password.required">Field is required</div>
                <div class="error" v-if="!$v.user.password.minLength">Password must have at least {{$v.user.password.$params.minLength.min}} letters.</div> 
            </div>
        </div>
        <b-button-group>
	        <b-button variant="outline-success" @click.prevent="saveUser()">Save</b-button>
	        <b-button variant="outline-danger" @click.prevent="cancelEdit()">Cancel</b-button>
        </b-button-group>
    </div>
</div>
</template>

<script>
import { email, required, minLength, between } from 'vuelidate/lib/validators'
const regex = /^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/
export default {
    data() {
        return {
            submitStatus: null,
            messageType: "",
            showMessage: false,
            showMessageDanger: false,
            message: "",
            messageDanger: "",
            user:{
                    name: '',
                    email: '',
                    type:'',
                    active:'',
                    nif: '',
                    photo: null,
                    password: '',
                },
        }
    },
    methods: {
        onFileSelected(event){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(event.target.files[0]);
                fileReader.onload=(event)=>{
                    this.user.photo=event.target.result;
                }

        },
        saveUser() {
             console.log('submit!');
                this.$v.$touch();
                if (this.$v.$invalid) {
                    
                } else {
                    this.user.active=1;
                    axios.post('api/users', this.user)
                        .then(response => {
                            Object.assign(this.user, response.data.data);
                            this.$emit('user-created', this.user)
                            this.showMessage = true;
                            this.messageType = "alert-success"
                            this.message = 'User created with success.';
                            setTimeout(() => {
                                this.$router.push("/users")
                            }, 1000);
                        }).catch(error=>{
                                console.log(error.response);
                                if(error.response.data.errors.email){
                                    this.showMessage = true;
                                    this.messageType = "alert-danger"
                                    this.message = 'Email already exists.';
                                }
                        });

                        // this.submitStatus = 'PENDING';
                        // setTimeout(() => {
                        //     this.submitStatus = 'OK'
                        //     }, 500)
                }
        },
        cancelEdit() {
            this.user = {}
            this.showSuccess = false
            this.$router.push("/users")
        },
       
    }, 
    validations: {
        user:{
            name: {
            required,
            minLength: minLength(4),
            nameValid(name) {
                return regex.test(name);
                }
            },

            email: {
                required,
                email,
            },

            type: {
                required
            },

            password: {
                required,
                minLength: minLength(3)
            }
        }
    }

}
</script>
<style scoped>
.error {
    display: block;
    color: #f57f6c;
}
</style>
