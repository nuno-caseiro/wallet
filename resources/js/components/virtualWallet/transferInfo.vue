<template>
    <div class="login-page">
            <div class="jumbotron">
                    <th><b-button size="lg"  variant="outline-danger" @click="exitInfo">Close</b-button></th>
                    <table class="table table-striped" >
                    <thead>
                        <tr>
                        <th>Information about movement [{{movement.id}}] : </th>
                        
                        </tr>
                    </thead>
                    <tbody >
                            <tr v-if="movement.transfer === 1 ">Destination Transfer User Photo:<img  v-bind:src="itemImageURL(!movement.photo_transfer=='' ? movement.photo_transfer : 'unknown.png')" width="50" height="50" alt=""></tr>

                            <tr>Description: {{movement.description}}</tr>
                            
                            <tr>Source Description: {{movement.source_description}}</tr>
                            
                            <tr>IBAN: {{movement.iban}}</tr>
                            
                            <tr>MB entity code: {{movement.mb_entity_code}}</tr>

                            <tr>MB payment reference: {{movement.mb_payment_reference}}</tr>
                        
                    </tbody>
                    </table>
            </div>
    </div>

</template>

<script type="text/javascript">
	module.exports={
        props: ['movement'],
        data(){
            return{
                selectedMovement:"",
            }

    },

    methods:{
        exitInfo(){
                    this.$emit('exit-info', this.movement);
        },
        itemImageURL(photo){
                return "storage/fotos/"+String(photo);

             },
        
        
    },

    }
</script>
