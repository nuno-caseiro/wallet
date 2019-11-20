require('./bootstrap');
import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import VueRouter from 'vue-router';




window.Vue = require('vue');

Vue.use(BootstrapVue);
Vue.use(VueRouter);
import store from './store.js';
import NavbarComponent from './components/main/navbar.vue';
import LoginComponent from './components/auth/login.vue';
import WellcomeComponent from './components/main/wellcome.vue';
import NotFoundComponent from './components/notFound.vue';
import RegisterComponent from './components/auth/register.vue';

const navbar = Vue.component('navbar',NavbarComponent);
const login = Vue.component('login', LoginComponent);
const wellcome = Vue.component('wellcome', WellcomeComponent);
const notFound = Vue.component('notFound', NotFoundComponent);
const register = Vue.component('register', RegisterComponent);


// // Para manter o utilizador logado depois de refrescar a pagina
store.state.user = store.getters.getAuthUser;
store.state.token = store.getters.getToken;
store.state.tokenType = store.getters.getTokenType;
store.state.getExpiration = store.getters.getExpiration;
axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.getters.getToken;



const routes = [
    { path: "/", 
    name:"Home", 
    component : wellcome},

    { path: "/login",
     component : login}, 

    { path: "/register",
     component : register}, 

    { path: "*", 
    component : notFound}
    
];

const router = new VueRouter({
    routes:routes,

 });

const app = new Vue({
    router,
    store,
    components:{
        navbar
    }

}).$mount('#app');






