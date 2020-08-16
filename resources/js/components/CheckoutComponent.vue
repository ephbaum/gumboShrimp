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

            <button @click.prevent="submitPayment" class="btn btn-success">Submit Payment</button>
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
        submitPayment() {

                // this.$v.form.$touch();

                // if (!this.$v.form.$invalid) {
                    

                    // createToken returns a Promise which resolves in a result object with
                    // either a token or an error key.
                    // See https://stripe.com/docs/api#tokens for the token object.
                    // See https://stripe.com/docs/api#errors for the error object.
                    // More general https://stripe.com/docs/stripe.js#stripe-create-token.
                    const options = {
                        name: this.name_on_card,
                    }
                    createToken(options).then(result => {

                        if(result.error) {
                            console.log(result.error);
                        }
                        
                        // create hidden input with stripe token to complete transaction
                        let hiddenInput = document.createElement('input');
                        
                        hiddenInput.setAttribute('type', 'hidden');
                        hiddenInput.setAttribute('name', 'stripeToken');
                        hiddenInput.setAttribute('value', result.token.id);

                        //append stripe token noto form
                        this.$el.appendChild(hiddenInput);

                        // build the FormData object for each form key
                        let fd = new FormData();
                        Object.keys(this.form).forEach(key => {
                            fd.append(key, this.form[key])
                        })
                        
                        // append hidden input to FormData object
                        fd.append('stripeToken', result.token.id);

                        // Make the call to our server to process donation using Stripe result.token.id 

                        fd.append('role', 'donor');
                        
                        // TODO: MAKE AXIOS CALL TO OUR SERVERS

                        console.log("TOKEN: " + result.token);

                    })
                // }
            },
    }
    
}
</script>
<style>
    .wrapper{
        margin-top: 20px;
    }
</style>