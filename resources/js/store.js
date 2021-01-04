import Vue from 'vue' 
import Vuex from 'vuex'
import VueCookie from 'vue-cookie'
import { router } from './router'
import axios from 'axios'

Vue.use(Vuex)
Vue.use(VueCookie)

export default new Vuex.Store({
    state() {
        let userToken = Vue.cookie.get('token');
        let user = Vue.cookie.get('user');
        let currentUser = JSON.stringify(user);
        let cart = window.localStorage.getItem('cart');
        let cartCount = window.localStorage.getItem('cartCount');


        return {
            token: userToken ? userToken : null,
            user: user ? user : null,
            currentUser: currentUser ? currentUser : null,
            cart: cart ? JSON.parse(cart) : [],
            cartCount: cartCount ? parseInt(cartCount) : 0,
            isLoading: false,
        }
    },
    getters: { 
        isAuthenticated: state => !!state.token,
        currentUser: state => state.user,
        cart: state => state.cart,
        cartCount: state => state.cartCount,
        isLoading: state => state.isLoading
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
            this.commit('saveCart');
        },
        saveCart(state) {
            window.localStorage.setItem('cart', JSON.stringify(state.cart));
            window.localStorage.setItem('cartCount', state.cartCount);
        },
        removeFromCart(state, item){
            let index = state.cart.indexOf(item);
            if(index > -1){
                let product = state.cart[index];
                state.cartCount -= product.quantity;
                state.cart.splice(index, 1);
            }
            
            this.commit('saveCart');
        },
        addQuantityToCart(state, cartItem){
            let found = state.cart.find(product => product.id == cartItem);
            if(found){
                found.quantity ++;
                found.totalPrice = found.quantity * found.price;
            }  
            state.cartCount++;
            this.commit('saveCart');
        },
        subtractQuantityFromCart(state, cartItem){
            let found = state.cart.find(product => product.id == cartItem);
            if(found){
                found.quantity --;
                found.totalPrice = found.quantity * found.price;
            }  
            state.cartCount--;
            this.commit('saveCart');
        },
        emptyCart(state){

            state.cart = [];
            
            state.cartCount = 0;

            this.commit('saveCart');
        },
        isLoading(state){
            state.isLoading = true;
        },
        stopLoading(state){
            state.isLoading = false;
        },
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
        addToCart(context, cartItem) {
            context.commit('addToCart', cartItem);
        },
        removeFromCart(context, cartItem){
            context.commit('removeFromCart', cartItem);
        },
        addQuantityToCart(context, cartItem){
            context.commit('addQuantityToCart', cartItem);
        },
        subtractQuantityFromCart(context, cartItem){
            context.commit('subtractQuantityFromCart', cartItem);
        },
        purchaseSuccess(context){
            Vue.$notify({
				group: 'notifications',
				type: 'success',
				title: "success",
				text: 'Your purchase was successful.',
				duration: '15000',
				width: '100%'
            });
            
            context.commit('emptyCart');
            context.commit('stopLoading');
        },
        isLoading(context){
            context.commit('isLoading');
        }

    }
})
