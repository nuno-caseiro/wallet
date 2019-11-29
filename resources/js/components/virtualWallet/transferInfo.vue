<template>
    <div class="login-page">
            <div class="jumbotron">
                    <th><b-button size="lg"  variant="outline-danger" @click="exitInfo">Close</b-button></th>
                    <th><label>{{movement.user_photo}}</label></th>
                    <table class="table table-striped" >
                    <thead>
                        <tr>
                        <th>Movements Info</th>
                        
                        </tr>
                    </thead>
                    <tbody >
                        
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
        
        
    },

    }
</script>
