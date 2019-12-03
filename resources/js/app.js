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
import VirtualWalletComponent from "./components/virtualWallet/virtualWallet.vue";
import MovementAddComponent from "./components/virtualWallet/movementAdd.vue";
import MovementListComponent from "./components/virtualWallet/movementList.vue";
import MovementEditComponent from "./components/virtualWallet/movementEdit.vue";
import TransferInfoComponent from "./components/virtualWallet/transferInfo.vue";
import UsersComponent from "./components/users/users.vue";
import UsersListComponent from "./components/users/usersList.vue";
import UserAddComponent from "./components/users/userAdd.vue";
import MovementFilterComponent from "./components/virtualWallet/movementsFilter.vue"
import StatisticsComponent from "./components/statistics/statistics.vue"




const navbar = Vue.component('navbar',NavbarComponent);
const login = Vue.component('login', LoginComponent);
const logout = Vue.component('logout', LogoutComponent);
const welcome = Vue.component('wellcome', WelcomeComponent);
const notFound = Vue.component('notFound', NotFoundComponent);
const register = Vue.component('register', RegisterComponent);
const editProfile= Vue.component('editProfile',EditProfileComponent);
const virtualWallet=Vue.component('virtualWallet',VirtualWalletComponent);
const movementAdd= Vue.component('movementAdd',MovementAddComponent);
const movementList=Vue.component('movementList',MovementListComponent);
const movementEdit=Vue.component('movementEdit',MovementEditComponent);
const transferInfo=Vue.component('transferInfo',TransferInfoComponent);
const users=Vue.component('users',UsersComponent);
const usersList=Vue.component('usersList',UsersListComponent);
const movementFilter= Vue.component('movementsFilter',MovementFilterComponent);
const userAdd= Vue.component('movementsFilter',UserAddComponent);
const statistics = Vue.component('statistics',StatisticsComponent);









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
        path:"/virtualWallet",
        name: "virtualWallet",
        component: virtualWallet
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
    {
        path:"/filter",
        name: "movementFilter",
        component: movementFilter
    },

    {
        path:"/userAdd",
        name: "userAdd",
        component: userAdd
    },

    {
        path:"/statistics",
        name: "statistics",
        component: statistics
    }




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
          //TODO enviar mail
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




