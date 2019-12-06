<template>
    <div class="login-page">
            <div class="jumbotron">
                <h2>Movement Edit - [{{movement.id}}]</h2>

                    <div class="form-group">
                        <label for="categoryId">Choose category</label>
                        <select class="form-control" id="categoryId" name="categoryId" v-model="movement.category_id">
                            <option></option>
                            <option v-for="category in this.categories"  v-bind:value="category.id" >{{category.name}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="categoryId">Change description</label>
                        <input type="text" class="form-control" id="description" name="description" v-model="movement.description" >
                        
                    </div>

                    <div class="form-group">
                        <b-button-group>
                        <b-button  variant="outline-success" @click.prevent="saveEdit()">Save</b-button> 
                        <b-button  variant="outline-danger" @click.prevent="cancelEdit()">Cancel</b-button>
                        </b-button-group>
                    </div>
            </div>
        </div>

</template>

<script type="text/javascript">
	module.exports={
        props: ['movement'],
        data(){
            return{
                message:'',
                messageType:'',
                showMessage:false,
                categories:[],
                selectedMovement:"",
            }

    },

    methods:{
        cancelEdit(){
			  axios.get('api/movements/id/'+this.movement.id)
                .then(response=>{
                    Object.assign(this.movement, response.data.data);
                    this.$emit('edit-canceled', this.movement);
                });
                this.getCategories();
        },
        
        saveEdit(){
            axios.put('api/movements/id/' + this.movement.id, this.movement)
            .then(response=>{
                console.log(response)
                Object.assign(this.movement, response.data.data);
                this.$emit('save-success', this.movement);
            })
            this.getCategories();
        },

        getCategories(){
            axios.get('api/categories/type/' + this.movement.type).then(response => {
                    this.categories = response.data.data;
                }).catch(error => {
                    console.log(error);
                });
        }
        
    },

    mounted(){
       this.getCategories();
    }

    }
</script>
<style scoped>
#formButton{
    margin-bottom: 40px;
}
</style>