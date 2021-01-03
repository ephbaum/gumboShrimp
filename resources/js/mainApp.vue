<template>    
    <b-container fluid>
        
        <br>
        <nav-bar></nav-bar>
        <br>
        
        <div class="loader" v-if="isLoading"></div>

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

        computed: mapGetters(['isAuthenticated', 'isLoading']),
        
        methods: mapActions(['login']),
        
        mounted() {
            if (window.auth.check()) {
                // here is where you can do something if the user is logged in
            }
        }
    }

</script>

<style>

    .container-fluid {
        background-color: black;
    }

    .loader {  
        border: 16px solid #f3f3f3;
    /* Light grey */
        border-top: 16px solid #fde614; 
        border-radius: 50%;
        width: 120px; 
        height: 120px;
        position: fixed;
        top: 30%; 
        left: 50%;  
        margin-top: -60px; 
        margin-left: -60px;  
        z-index: 10;  
        -webkit-animation: spin 1s linear infinite;
        animation: spin 2s linear infinite;}

        @-webkit-keyframes 
        spin { 0% {-webkit-transform: rotate(0deg); transform: rotate(0deg); } 100% {-webkit-transform: rotate(360deg); transform: rotate(360deg);  }}
        @keyframes spin {  0% {    -webkit-transform: rotate(0deg);            transform: rotate(0deg);  }  100% {    -webkit-transform: rotate(360deg);            transform: rotate(360deg);  }}
</style>