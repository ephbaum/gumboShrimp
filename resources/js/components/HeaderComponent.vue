<template>
    <b-container fluid>
        <!-- <b-img class="headImage col-md-12" fluid src="../images/fruits.jpeg" alt="Image 1"></b-img> -->
        <div class="banner"><p>Chango Cart</p></div>
        <div class="subtitle">A place to buy stuff.</div>
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

    mixins: [
      validationMixin
    ],


    

    computed: mapGetters(['isAuthenticated']),  
    

        mounted() {
            console.log('Component mounted.')
        }
}

</script>

<style>
.headImage {
    max-height: 375px;
    margin-top: 60px;
}

.banner {
    text-align: center;
    font-size: 8rem;
}

.subtitle {
    text-align: center;
    font-size: 2rem;
}
</style>