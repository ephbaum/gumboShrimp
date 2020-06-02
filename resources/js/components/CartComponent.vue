<template>
    <div>
        <h2>HEllo</h2>
        <table striped hover class="table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody v-for="cartItem in $store.state.cart" :key="cartItem.id" >
                <tr >
                    <td>{{ cartItem.item_name }}<a href=""><span class="removeBtn" @click.prevent="removeFromCart(cartItem)"> remove</span> </a> </td>
                    <td> {{ cartItem.price }}</td>
                    <td>
                        <a href=""><span class="minusBtn" @click.prevent="subtractQuantityFromCart(cartItem.id)"> - </span> </a> 
                        {{ cartItem.quantity }} 
                        <a href=""><span class="plusBtn" title="Remove from cart" @click.prevent="addQuantityToCart(cartItem.id)"> + </span></a> 
                    </td>
                    <td> {{ cartItem.totalPrice }}</td>
                </tr>
            </tbody>
        </table>
        <div >
            <b-button  block variant="primary" >  Place your order... total amount ${{ totalPrice }} </b-button>
        </div>
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
            removeFromCart(cartItem) {
            this.$store.dispatch('removeFromCart', cartItem);
        },
        addQuantityToCart(cartItem){
            console.log(cartItem);
            this.$store.dispatch('addQuantityToCart', cartItem);
        },
        subtractQuantityFromCart(cartItem){
            console.log(cartItem);
            this.$store.dispatch('subtractQuantityFromCart', cartItem);
        }
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