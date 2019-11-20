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
    },

    getters:{
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
    }
});
