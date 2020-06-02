<template>
    <div>   
        <b-table striped hover :items="$store.state.cart" :fields="fields"></b-table>
    </div>
</template>
 
<script>
import { mapGetters } from 'vuex'

    export default {
        data() {
            return {
                fields: ['item_name', 'price', 'quantity', 'totalPrice'],
            }
        },
        methods: {
        },
        computed: {
            totalPrice(){
                let total = 0;
                for(let item of this.$store.state.cart){
                    total += item.totalPrice;
                }
                return total.toFixed(2);
            },...mapGetters(['isAuthenticated', 'cart'])
        },
    }
</script>

<style>
</style>