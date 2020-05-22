import Vue from 'vue' 
import VueRouter from 'vue-router'
import { router } from './router'
import BootstrapVue from 'bootstrap-vue'
import Notifications from 'vue-notification'
import Auth from './auth.js';
import VueCookie from 'vue-cookie';
import store from './store'
import 'bootstrap/dist/css/bootstrap.css'
import Vuelidate from 'vuelidate'



require('./bootstrap');
Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(VueCookie)
Vue.use(Notifications)
Vue.use(Vuelidate)
window.Vue = require('vue');
window.auth = new Auth();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('main-app', require('./mainApp.vue'))
Vue.component('login-component', require('./components/LoginComponent.vue'))
Vue.component('register-component', require('./components/RegisterComponent.vue'))
Vue.component('shop-component', require('./components/ShopComponent.vue').default);
Vue.component('item-component', require('./components/ItemComponent.vue').default);
Vue.component('nav-bar', require('./components/NavBar.vue'))
Vue.component('header-component', require('./components/HeaderComponent.vue'))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.addEventListener('load', function () { 
    const app = new Vue({
        el: '#app',
        template: '<router-view></router-view>',
        router,
        store
    })
})

