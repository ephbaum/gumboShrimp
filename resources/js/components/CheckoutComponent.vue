<template>
    <div class="wrapper">
        <b-form id="payment-form">
              <b-form-group id="emailInputGroup"
                        label="Email"
                        label-for="email">
                <b-form-input id="email"
                            v-model="form.email"
                            :state="!$v.form.email.$invalid" 
                            aria-describedby="emailLiveFeedback"
                            placeholder="Enter Email" />
                <b-form-invalid-feedback id="emailLiveFeedback">
                    Please enter a valid Email
                </b-form-invalid-feedback>
            </b-form-group>

             <b-form-group id="nameInputGroup" label="Name On Card" label-for="name">
                <b-form-input id="name"
                    type="text"
                    v-model="form.name"
                  
                    aria-describedby="nameLiveFeedback"
                    placeholder="Enter Name on Card">
                </b-form-input>
                <b-form-invalid-feedback id="nameLiveFeedback">
                    Please enter a valid Name
                </b-form-invalid-feedback>
            </b-form-group>

             <b-form-group id="addressInputGroup" label="Address" label-for="address">
                <b-form-input id="address"
                    type="text"
                    v-model="form.address"
                  
                    aria-describedby="addressLiveFeedback"
                    placeholder="Enter Address">
                </b-form-input>
                <b-form-invalid-feedback id="addressLiveFeedback">
                    Please enter a valid Address
                </b-form-invalid-feedback>
            </b-form-group>

             <b-form-group id="cityInputGroup" label="City" label-for="city">
                <b-form-input id="city"
                    type="text"
                    v-model="form.city"
                  
                    aria-describedby="cityLiveFeedback"
                    placeholder="Enter City">
                </b-form-input>
                <b-form-invalid-feedback id="cityLiveFeedback">
                    Please enter a valid City
                </b-form-invalid-feedback>
            </b-form-group>  

             <b-form-group id="stateInputGroup" label="State" label-for="state">
                <b-form-input id="state"
                    type="text"
                    v-model="form.state"
                  
                    aria-describedby="stateLiveFeedback"
                    placeholder="Enter State">
                </b-form-input>
                <b-form-invalid-feedback id="stateLiveFeedback">
                    Please enter a valid Name
                </b-form-invalid-feedback>
            </b-form-group>
              
<!--
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
                    a Stripe Element will be inserted here. -->
               

                <!-- Used to display form errors -->
                <div id="card-errors" role="alert"></div>
        

            <button @click.prevent="submitPayment" class="btn btn-success">Submit Payment</button>
        </b-form>

    </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import { validationMixin } from "vuelidate";
import { required, minLength, email } from "vuelidate/lib/validators";
import CardElement from '../components/CardElement'
import { Card, createToken, stripe } from 'vue-stripe-elements-plus'

export default {
    data() {
        return {
            form:{
                email:'',
                name:'',
                address:'',
                city:'',
                state:'',
                zip:'',
                amount:''
            }

        }
        
    },
    mixins: [
        validationMixin
    ],
    validations: {
        form: {
            email:{
                required,
                email
            },
            name:{
                required,
                minLength: minLength(3),
            },

        }
    },

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
 
    },
    computed: {
            totalPrice(){
                let total = 0;
                for(let item of this.$store.state.cart){
                    total += item.totalPrice;
                }
                return total.toFixed(2);
            },...mapGetters(['isAuthenticated', 'cart', 'cartCount'])
        }
    }
    
}
</script>
<style>
    .wrapper{
        margin-top: 20px;
    }
</style>