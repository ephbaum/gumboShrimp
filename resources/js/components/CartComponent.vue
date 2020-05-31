<template>
    <div>   
        <li v-for="thing in cart" :key="thing.id">{{ thing.item_name }}</li>
    </div>
</template>
 
<script>
import { mapGetters } from 'vuex'

    export default {
        data() {
            return {
 
            }
        },
        methods: {
        },
        computed: {...mapGetters(['isAuthenticated', 'cart'])
        },
        }
</script>

<style>
</style>