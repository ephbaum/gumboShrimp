<template>    
    <b-container fluid>
        
        <nav-bar></nav-bar>
        
        <br>
        
        <router-view name="header" v-if="!isAuthenticated"/>
        <router-view name="body"/>

        <notifications group="notifications" position="bottom center" width="100%"/>
    
    </b-container>
</template>

<script>

    import NavBar from './components/NavBar'
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: "mainApp",

        components: {
            NavBar,
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

<style>

</style>