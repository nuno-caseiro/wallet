<template>
    <login-template>
        <div>
            <div class = "menuesquerdo">

            </div>
            <div class="principal">

                <h2>Login</h2>
                <div class="form-login"  v-if="!registo">
                    
                    <input type = "text" placeholder="E-mail" value="">
                    <input type = "text" placeholder="Senha" value="">
                    <button type = "text" class="btn"> Entrar</button>
                </div>
            </div>	    
        </div>
    </login-template>    
</template>

<script >
    import LoginTemplate from '@/templates/Login'
	export default{
        name: "Login",
        data(){
            return{
                registo: false
            }
        },

        components:{
            LoginTemplate
        }	
	}
</script>







