<template>
    <b-container fluid>
        <div class="banner center">Chango Cart</div>
        <div class="subtitle center">A place to buy stuff.</div>
    </b-container>
</template>

<script>

import { mapGetters } from "vuex";

export default {
    name: "headerComponent",
    
    data() {
        return {
            
        }
    },

    computed: mapGetters(['isAuthenticated']),  

        mounted() {
            console.log('Header Component mounted.')
        }
}
</script>

<style scoped>

    * {
        font-family: 'Staatliches', cursive;
    }

    .headImage {
        max-height: 375px;
        margin-top: 60px;
    }

    .banner {
        background-image: linear-gradient(red, yellow);
        font-size: 8rem;
    }

    .subtitle {
        background-image: linear-gradient(yellow, white);
        font-size: 2rem;
    }
</style>