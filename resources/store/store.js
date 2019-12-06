import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: {},
        tokenType: "",
        token: "",
        expiration: 0,
    },
    mutations: {
        setToken(state, {token, tokenType, expiration}) {
            state.token = token;
            state.tokenType = tokenType;
            state.expiration = expiration;
            localStorage.setItem('token_type', tokenType);
            localStorage.setItem('access_token', token);
            localStorage.setItem('expiration_time', expiration);
            axios.defaults.headers.common.Authorization = "Bearer " + token;
        },

        clearUserAndToken(state) {
            state.user = null;
            state.token = "";
            state.expiration = 0;
            localStorage.removeItem('user');
            localStorage.removeItem('token_type')
            localStorage.removeItem('access_token');
            localStorage.removeItem('expiration_time')
            axios.defaults.headers.common.Authorization = undefined;
        },
        setAuthUser(state,user){
            state.user=user;
            localStorage.setItem('user', JSON.stringify(user));
        },

        
    
        //--------------------Items setters-------------------------------
        setItems(state, users){
            state.users = users;
        },

    },

    getters:{
        
        users(state){
            return state.users;
        },

        getToken(state) {
            let token = localStorage.getItem('access_token')
            let tokenType = localStorage.getItem('token_type')
            let expiration = localStorage.getItem('expiration_time')

            if (!token || !tokenType || !expiration) {
                return null;
            }

            if (Date.now() > parseInt(expiration)) {
                state.token = "";
                state.tokenType = "";
                localStorage.removeItem('token_type')
                localStorage.removeItem('access_token')
                localStorage.removeItem('expiration_time')
                localStorage.removeItem('user')
                axios.defaults.headers.common.Authorization = undefined;
                return null;
            }

            return token;
        },
        getTokenType(state) {
            let tokenType = localStorage.getItem('token_type')

            if (!tokenType) {
                return null;
            }

            return tokenType;
        },
        getExpiration(state) {
            let expiration = localStorage.getItem('expiration_time')

            if (!expiration) {
                return null;
            }

            return expiration;
        },
        getAuthUser(state) {
            let user = localStorage.getItem('user')

            if (!user) {
                return null;
            }

            return JSON.parse(user);
        },

        isAuthenticated(state) {
            if(state.user && state.token && state.tokenType ){
               return true;
            }
            return false;
        },
        isUser(state){
            if(state.user){
                return state.user.type =="u" ? true : false;
            }
            return false;
        },
        isOperator(state){
            if(state.user){
                return state.user.type =="o" ? true : false;
            }
            return false;
        },
        isAdmin(state){
            if(state.user){
                return state.user.type =="a" ? true : false;
            }
            return false;
        }
    },
    actions:{
        setAuthUser({commit},data){
            commit('setAuthUser',data);
        },
    //     loadUsers(context){
    //         axios.get('api/users/')
    //         .then(response=>{
    //              context.commit('setUser',response.data.data);
             
    //     })
    // },
    }
});
