import Vue from 'vue' 
import Vuex from 'vuex'
import VueCookie from 'vue-cookie'

// to make API calls
import { router } from './router'
import axios from 'axios'

Vue.use(Vuex)
Vue.use(VueCookie)

export default new Vuex.Store({
    state() {
        let userToken = Vue.cookie.get('token');
        let user = Vue.cookie.get('user');
        let currentUser = JSON.stringify(user);
        
        return {
            token: userToken ? userToken : null,
            user: user ? user : null,
            currentUser: currentUser ? currentUser : null,
            cart: [],
            cartCount: 0,
        }
    },
    getters: { 
        
        isAuthenticated: state => !!state.token,
        currentUser: state => state.user,
        cart: state => state.cart
    },


    mutations: {
        // mutations are committed by actions, and are the ONLY way to manipulate state

        setLoginCred(state, payload) {
            state.token = payload.token;
            state.user = payload.user;
            
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + payload.token
        },
        setUser(state, user) {
            state.currentUser = user;
        },
        logout(state) {
            state.token = null;
            state.user = null;
            Vue.cookie.delete('token');
            Vue.cookie.delete('user');
        },
        addToCart(state, item) {
            let found = state.cart.find(product => product.id == item.id);
            if(found){
                found.quantity ++;
                found.totalPrice = found.quantity * found.price;
            }else{
                state.cart.push(item);
                Vue.set(item, 'quantity', 1);
                Vue.set(item, 'totalPrice', item.price);
            }
            state.cartCount++;
        }
    },
    actions: {
        // actions are dispatched, they commit mutations

        setLoginCred(context, payload) {
            context.commit('setLoginCred', payload)

            axios.call("get", "/api/user").then((userData) => {
                let user = userData.data.data
                context.commit('setUser', user)
            })
        },
        refreshUserData(context) {
            axios.call("get", "/api/user").then((userData) => {
                let user = userData.data.data
                context.commit('setUser', user)
            })
        },
        logout( { commit }) {
        
            axios.post("/api/logout").then((userData) => {        
                commit('logout');
                router.push({ path: '/' });
            })
        },
        addToCart(context, item) {
            context.commit('addToCart', item);
        },
        removeFromCart(state, item){
            let index = state.cart.indexOf(item);
            if(index > -1){
                let product = state.cart[index];
                state.cartCount -= product.quantity;
                state.cart.splice(index, 1);
            }
        }
    }
})
