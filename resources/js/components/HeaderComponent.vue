<template>
    <b-container fluid>
        <!-- <b-img class="headImage col-md-12" fluid src="../images/fruits.jpeg" alt="Image 1"></b-img> -->
        <div class="banner center"><p>Chango Cart</p></div>
        <div class="subtitle center">A place to buy stuff.</div>
    </b-container>
</template>

<script>

import { mapActions, mapGetters } from "vuex";
import { validationMixin } from "vuelidate";
import { required, minLength, email } from "vuelidate/lib/validators";

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