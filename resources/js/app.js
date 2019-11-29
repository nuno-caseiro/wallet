require('./bootstrap');
import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import VueSocketIO from "vue-socket.io";
import VueRouter from 'vue-router';
import Toasted from 'vue-toasted';



window.Vue = require('vue');

Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.use(new VueSocketIO({
    debug:true,
    connection: 'http://127.0.0.1:8080'
}));

Vue.use(Toasted,{
    theme: "bubble",
    position: 'top-right', //pode ser top-right, top-center, top-left, bottom-right, bottom-center, bottom-left
    duration: 5000,
    type: 'info',
})


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
import MovementEditComponent from "./components/movement/movementEdit.vue";
import TransferInfoComponent from "./components/movement/transferInfo.vue";
import UsersComponent from "./components/users/users.vue";
import UsersListComponent from "./components/users/usersList.vue";






const navbar = Vue.component('navbar',NavbarComponent);
const login = Vue.component('login', LoginComponent);
const logout = Vue.component('logout', LogoutComponent);
const welcome = Vue.component('wellcome', WelcomeComponent);
const notFound = Vue.component('notFound', NotFoundComponent);
const register = Vue.component('register', RegisterComponent);
const editProfile= Vue.component('editProfile',EditProfileComponent);
const movement=Vue.component('movement',MovementComponent);
const movementAdd= Vue.component('movementAdd',MovementAddComponent);
const movementList=Vue.component('movementList',MovementListComponent);
const movementEdit=Vue.component('movementEdit',MovementEditComponent);
const transferInfo=Vue.component('transferInfo',TransferInfoComponent);
const users=Vue.component('users',UsersComponent);
const usersList=Vue.component('usersList',UsersListComponent);










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
        path:"/movementAdd",
        name: "movementAdd",
        component: movementAdd
    },

    {
        path:"/movementList",
        name:"MovementList",
        component:movementList
    },

    {
        path:"/users",
        name: "users",
        component: users
    },


];

const router = new VueRouter({
    routes:routes,

 });

const app = new Vue({
    router,
    store,
    sockets:{
      connect(){
          console.log(`Socket connected with ID: ${this.$socket.id}`);
          if(store.state.user){
              this.$socket.emit('user_enter', store.state.user);
          }
      },
        message_from_user(dataFromServer){
        console.log('Receiving this message from Server: "'+dataFromServer+'"');
        let name=dataFromServer[1]===null? 'Unknown':dataFromServer[1].name;
        this.$toasted.show('Message "'+dataFromServer[0]+ '"sent from"'+name+'"');

        },
        message_unavailable(destUser){
          this.$toasted.error('User"'+destUser.name+ '"is not available');
        },
        message_sent(dataFromServer){
          this.$toasted.success('Message"'+dataFromServer[0]+'"was sent to"'+dataFromServer[1].name+'"');
        }
    },
    components:{
        navbar
    }

}).$mount('#app');




