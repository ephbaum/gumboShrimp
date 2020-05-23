<template>    
    <b-container fluid>
        
        <notifications group="notifications" position="bottom center" width="100%"/>

        <nav-bar></nav-bar>
        
        <br>
        
        <router-view></router-view>
    
    </b-container>
</template>

<script>

    import NavBar from './components/NavBar'
    import ShopComponent from './components/ShopComponent'
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: "mainApp",
        components: {
            NavBar,
            ShopComponent
        },
        computed: mapGetters(['isAuthenticated']),
        methods: mapActions(['login']),
        mounted() {
            if (window.auth.check()) {
                // here is where you can do something if the user is logged in
            }
        }
    }

</script>

