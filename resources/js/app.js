require('./bootstrap');
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

window.Vue = require('vue');

Vue.use(BootstrapVue);

import NavbarComponent from './components/navbar.vue';
const navbar= Vue.component('navbar',NavbarComponent);


const app = new Vue({
    data:{


    },
    components:{
        navbar
    }

}).$mount('#app');






