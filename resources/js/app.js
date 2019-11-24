require('./bootstrap');
import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import VueRouter from 'vue-router';

window.Vue = require('vue');


Vue.use(BootstrapVue);
Vue.use(VueRouter);
import store from '../store/store.js';
import NavbarComponent from './components/main/navbar.vue';
import LoginComponent from './components/auth/login.vue';
import LogoutComponent from './components/auth/logout.vue';
import WelcomeComponent from './components/main/welcome.vue';
import NotFoundComponent from './components/notFound.vue';
import RegisterComponent from './components/auth/register.vue';
import EditProfileComponent from "./components/auth/editProfile.vue";
import MovementComponent from "./components/movement/movement.vue";

import MovementAddComponent from "./components/movement/movementAdd.vue";

import MovementListComponent from "./components/movement/movementList.vue";



const navbar = Vue.component('navbar',NavbarComponent);
const login = Vue.component('login', LoginComponent);
const logout = Vue.component('logout', LogoutComponent);
const welcome = Vue.component('wellcome', WelcomeComponent);
const notFound = Vue.component('notFound', NotFoundComponent);
const register = Vue.component('register', RegisterComponent);
const editProfile= Vue.component('editProfile',EditProfileComponent);
const movement=Vue.component('movement',MovementComponent);

const movementAdd= Vue.component('movementAdd',MovementAddComponent);

const movementList=Vue.component('movement',MovementListComponent);



// // Para manter o utilizador logado depois de refrescar a pagina
store.state.user = store.getters.getAuthUser;
store.state.token = store.getters.getToken;
store.state.tokenType = store.getters.getTokenType;
store.state.getExpiration = store.getters.getExpiration;
axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.getters.getToken;



const routes = [
    { path: "/",
    name:"Home",
    component : welcome},

    { path: "/login",
    name:"Login",
     component : login},

    { path: "/logout",
    name:"Logout",
     component : logout},

    { path: "/register",
    name:"Register",
     component : register},

    { path: "*",
    component : notFound},

    {path:"/edit",
        name:"Edit",
    component:editProfile},

    {
        path:"/movement",
        name: "movement",
        component: movement
    },

    {
        path:"/movementList",
        name:"MovementList",
        component:movementList},


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






