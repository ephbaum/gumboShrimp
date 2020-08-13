<template>
    <div>
        <table striped hover class="table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody v-for="cartItem in cart" :key="cartItem.id" >
                <tr >
                    <td>{{ cartItem.item_name }}<a href=""><span class="removeBtn" @click.prevent="removeFromCart(cartItem)" v-if="cartItem.quantity  == 0"> remove</span> </a> </td>
                    <td><img :src=cartItem.image alt="cart item" height="50"></td>
                    <td> ${{ cartItem.price }}</td>
                    <td><b-input-group>
                        <b-btn v-if="cartItem.quantity  > 1" id="minusButton" variant="outline-info" @click.prevent="subtractQuantityFromCart(cartItem.id)" >-</b-btn>
                        <b-btn v-if="cartItem.quantity  == 1" id="minusButton" variant="outline-info" @click.prevent="removeFromCart(cartItem)" >-</b-btn>
                        <b-button  v-if="cartItem.quantity  >= 1" variant="info">{{cartItem.quantity}}</b-button>

                        <b-btn variant="outline-secondary" @click.prevent="addQuantityToCart(cartItem.id)">+</b-btn>
                    </b-input-group></td>
                    <td> ${{ cartItem.totalPrice }}</td>
                </tr>
            </tbody>
        </table>
        <b-form>
            <div class="form-group">
                <label for="card-element">Card Information</label>
                <card-element></card-element>
            </div>
        </b-form>
        <div >
            <b-button  block variant="primary" >  Place your order... total amount ${{ totalPrice }} </b-button>
        </div>
    </div>
</template>
 
<script>
import { mapGetters } from 'vuex'
import CardElement from '../components/CardElement'

    export default {
        data() {
            return {
                 
            }
        },
        components: {
            CardElement
        },
        methods: {
            removeFromCart(cartItem) {
                if(confirm("Are you sure you want to delete " + cartItem.item_name + "?")) {
                    this.$store.dispatch('removeFromCart', cartItem);
                }
                
            },
            addQuantityToCart(cartItem){
                this.$store.dispatch('addQuantityToCart', cartItem);
            },
            subtractQuantityFromCart(cartItem){

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
            },...mapGetters(['isAuthenticated', 'cart', 'cartCount'])
        },
    }
</script>

<style>
</style>