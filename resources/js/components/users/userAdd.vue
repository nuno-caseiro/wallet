<template>
<div>
    <div class="alert alert-success" v-if="showSuccess">			 
        <strong>{{ successMessage }}</strong>
    </div>
    <div class="jumbotron">
	    <h2>Add User</h2>
	    <div class="form-group">
	        <label for="inputName">Name</label>
	        <input type="text" class="form-control"  id="inputName" placeholder="Name" name="name" v-model="user.name"/>
	    </div>
        
	    <div class="form-group">
	        <label for="inputEmail">Email</label>
	        <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="email" v-model="user.email"/>
	    </div>
        <div class="form-group">
            <label for="photo">Photo</label>
            <div>
            <input class="form-data" name="photo" accept="image/*" type="file" @change="onFileSelected">
            </div>
        </div>
        <div class="form-group">
                    <label for="userType">Choose user type</label>
                    <select class="form-control" id="userType" name="userType" v-model="user.type">
                        <option value="a">Administrator</option>
                        <option value="o">Operator</option>
                    </select>
                </div>	    
        <div class="form-group">
	        <label for="inputNIF">Password</label>
	        <input type="password" class="form-control" id="inputPassword" name="nif" v-model="user.password"/>
	    </div>
        <b-button-group>
	        <b-button variant="outline-success" @click.prevent="saveUser()">Save</b-button>
	        <b-button variant="outline-danger" @click.prevent="cancelEdit()">Cancel</b-button>
        </b-button-group>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            showSuccess: false,
            successMessage: '',
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
            this.user.active=1;
            axios.post('api/users', this.user)
                    .then(response => {
                        Object.assign(this.user, response.data.data);
                        this.$emit('user-created', this.user)
                        this.showSuccess = true;
                        this.successMessage = 'User created with success';
                        setTimeout(() => {
                            this.$router.push("/users")
                        }, 1000);
                    })
        },
        cancelEdit() {
            this.user = {}
            this.showSuccess = false
            this.$router.push("/users")
        }
    },
}
</script>
