<template>
<div>
   <div class="panel" id="panelBody">
       <div  id="row1">
           <div >
               <label>  User Type: </label>
               <select v-model="filters.type" >
                   <option value="a">Administrator</option>
                   <option value="o">Operator</option>
                   <option value="u">User Platform</option>
               </select>
           </div>

           <div>
               <label id = "n">  Name : </label>
               <input id="name" v-model="filters.name" type="text">
           </div>

           <div>
               <label id="e">  Email : </label>
               <input id="email" v-model="filters.email" type="email">
           </div>

            <div v-if = "filters.type == 'u'">
               <label id="s">  Status : </label>
               <select  v-model="filters.active" >
                   <option value="1">Active</option>
                   <option value="0">Deactive</option>

               </select>
           </div>

            <div>
                <b-button-group id="b">
                    <b-button size="sm" variant="outline-primary" v-on:click="applyFilter()">Apply filters</b-button>
                    <b-button size="sm" variant="outline-primary" v-on:click="cleanFilter()">Clean filters</b-button>
                </b-button-group>   
            </div>
            
        
       </div>

       
   </div>
</div>

</template>


<script>
    export default {
    data(){
        return {
            filters:{
                type:'',
                name:'',
                email:'',
                active:'',

            },
        }
    },
       methods: {

        applyFilter: function () {
            if(this.filters.type == 'a' || this.filters.type == 'o'){
                this.filters.active = '';
            }
            this.$emit('apply-Filter', this.filters);

            },

        cleanFilter: function () {
            this.filters.type = '';
            this.filters.name = '';
            this.filters.active = '';
            this.filters.email = '';
            this.$emit('clean-filter');
            },
       }

    }

</script>

<style scoped>
#n{
    margin-left: 15px ;
}

#e{
    margin-left: 15px ;
}


#s{
    margin-left: 15px ;
}

#b{
    margin-left: 60px ;
}

#row1{
    
    background-color: rgb(241, 241, 241);
    display: flex; 
    justify-content: space-evenly;
    padding: 10px 0;
}


</style>