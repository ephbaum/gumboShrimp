<template>
    <div class="wrapper">
        <b-form  id="payment-form">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email">
            </div>

            <div class="form-group">
                <label for="name_on_card">Name on Card</label>
                <input type="text" class="form-control" id="name_on_card" name="name_on_card">
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="State">State</label>
                        <input type="text" class="form-control" id="state" name="state">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="postalcode">Postal Code</label>
                        <input type="text" class="form-control" id="postalcode" name="postalcode">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label for="card-element">Credit Card</label>
                <div id="card-element">
                    <!-- a Stripe Element will be inserted here. -->
                    <card-element></card-element>
                </div>

                <!-- Used to display form errors -->
                <div id="card-errors" role="alert"></div>
            </div>

            <button type="submit" @click="pay()" class="btn btn-success">Submit Payment</button>
        </b-form>

    </div>
</template>
<script>
import CardElement from '../components/CardElement'
import { Card, createToken, stripe } from 'vue-stripe-elements-plus'

export default {

    components: {
        CardElement
    },

    methods: {
        pay(){
            alert("hello");
        }
 
    }
    
}
</script>
<style>
    .wrapper{
        margin-top: 20px;
    }
</style>