<template>    
   <div>
        <nav-bar ></nav-bar>
        <b-container fluid class="p-4 bg-dark">
            <b-row>             
                <b-col>
                    <login-component class="col-md-8" v-if="!isAuthenticated" :is="loginComponent" ></login-component>
                </b-col>
                <b-col>
                    <register-component class="col-md-8" ></register-component>
                </b-col>
            </b-row>
        <router-view v-if="isAuthenticated" ></router-view>
            <shop-component class="col-md-11"></shop-component>
            </b-container>
</div>
   
</template>

<script>
    import NavBar from './components/NavBar'
    import RegisterComponent from './components/RegisterComponent'
    import ShopComponent from './components/ShopComponent'
    import { mapGetters, mapActions } from 'vuex';
    export default {
        name: "mainApp",
        components: {
            NavBar,
            RegisterComponent,
            ShopComponent,
            
        },
        props: ["loginComponent"],
        computed: mapGetters(['isAuthenticated']),
        methods: mapActions(['login']),
        mounted() {
            // if (window.auth.check()) {
            //     this.$router.push('shop');
            // }
        }
    }
</script>
