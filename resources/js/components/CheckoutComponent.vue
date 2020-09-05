<template>
    <b-container class="wrapper">
        <b-row>
            <b-col>
                <b-form id="payment-form">

                    <b-form-group id="emailInputGroup"
                            label="Email"
                            label-for="email">
                        <b-form-input id="email"
                                v-model="form.email"
                                :class="{ 'has-danger': $v.form.email.$invalid && $v.form.email.$dirty, 'has-success': !$v.form.email.$invalid }"
                                aria-describedby="emailLiveFeedback"
                                placeholder="Enter Email" 
                        />
                        <b-form-invalid-feedback id="emailLiveFeedback">
                            Please enter a valid Email
                        </b-form-invalid-feedback>
                    </b-form-group>               

                    <b-form-group id="addressInputGroup" label="Address" label-for="address">
                        <b-form-input id="address"
                            type="text"
                            v-model="form.address"
                            :class="{ 'has-danger': $v.form.address.$invalid && $v.form.address.$dirty, 'has-success': !$v.form.address.$invalid }"
                            aria-describedby="addressLiveFeedback"
                            placeholder="Enter Address"
                        />
                        <b-form-invalid-feedback id="addressLiveFeedback">
                            Please enter a valid Address
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-form-group id="cityInputGroup" label="City" label-for="city">
                        <b-form-input id="city"
                            type="text"
                            v-model="form.city"
                            :class="{ 'has-danger': $v.form.city.$invalid && $v.form.city.$dirty, 'has-success': !$v.form.city.$invalid }"
                            aria-describedby="cityLiveFeedback"
                            placeholder="Enter City"
                        />
                        <b-form-invalid-feedback id="cityLiveFeedback">
                            Please enter a valid City
                        </b-form-invalid-feedback>
                    </b-form-group>  

                    <b-form-group id="stateInputGroup" label="State" label-for="state">
                        <b-form-input id="state"
                            type="text"
                            v-model="form.state"
                            :class="{ 'has-danger': $v.form.state.$invalid && $v.form.state.$dirty, 'has-success': !$v.form.state.$invalid }"
                            aria-describedby="stateLiveFeedback"
                            placeholder="Enter State"
                            minlength=2
                            maxlength=2
                        />
                        <b-form-invalid-feedback id="stateLiveFeedback">
                            Please enter a valid State
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-form-group id="zipInputGroup" label="Zip Code" label-for="zip">
                        <b-form-input id="zip"
                            type="text"
                            v-model="form.zip"
                            :class="{ 'has-danger': $v.form.zip.$invalid && $v.form.zip.$dirty, 'has-success': !$v.form.zip.$invalid }"
                            aria-describedby="zipLiveFeedback"
                            placeholder="Enter Zip Code"
                            minlength=5
                            maxlength=5
                        />
                        <b-form-invalid-feedback id="zipLiveFeedback">
                            Please enter a valid Zip Code
                        </b-form-invalid-feedback>
                    </b-form-group>
                
                    <b-form-group id="nameInputGroup" label="Name On Card" label-for="name_on_card">
                        <b-form-input id="name_on_card"
                            type="text"
                            v-model="form.name_on_card"
                            :class="{ 'has-danger': $v.form.name_on_card.$invalid && $v.form.name_on_card.$dirty, 'has-success': !$v.form.name_on_card.$invalid }"
                            aria-describedby="nameLiveFeedback"
                            placeholder="Enter Name on Card"
                        />
                        <b-form-invalid-feedback id="nameLiveFeedback">
                            Please enter the name on the card
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-form-group>
                        <label for="card-element">Credit Card</label>
                        <card-element required/>
                    </b-form-group>

                    <!-- Used to display form errors -->
                    <div id="card-errors" role="alert"></div>

                    <button @click.prevent="submitPayment" :disabled="$v.form.$invalid" class="btn btn-success">Submit Payment ${{ totalPrice }}</button>
                    
                </b-form>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import { validationMixin } from "vuelidate";
import { helpers, required, minLength, maxLength, email } from "vuelidate/lib/validators";
import CardElement from '../components/CardElement'
import { Card, createToken, stripe } from 'vue-stripe-elements-plus'

const zip = helpers.regex('zip', /(^\d{5}$)|(^\d{5}-\d{4}$)/);

export default {

    data() {
        return {
            form:{
                email:'',
                name_on_card:'',
                address:'',
                city:'',
                state:'',
                zip:'',
                amount:this.totalPrice
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
            name_on_card:{
                required,
                minLength: minLength(3)
            },
            address:{
                required
            },
            city:{
                required,
                minLength: minLength(2)
            },
            state:{
                required,
                minLength: minLength(2),
                maxLength: maxLength(2)
            },
            zip:{
                required,
                zip
            }

        }

    },

    components: {

        CardElement

    },

    methods: {

        submitPayment() {

            this.$v.form.$touch();

            if (!this.$v.form.$invalid) {
                
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
                    fd.append('amount', this.totalPrice);

                    // Make the call to our server to process donation using Stripe result.token.id 

                    fd.append('role', 'user');
                    
                    axios.post("/api/purchase", fd, {headers: {'Content-Type': 'multipart/form-data'}}).then(({data}) => {

                                console.log("SUCCESS!!!!!!");

                                this.$store.dispatch('purchaseSuccess');
                                this.resetForm();

                                this.$router.push('/');
                                
                            }).catch((error) => {
                                
                                console.log(error);
                                this.resetForm();

                            })

                    console.log("TOKEN: " + result.token.id);

                })
            }
        },

        resetForm() {

            this.form.email = '';
            this.form.name_on_card = '',
            this.form.address = '',
            this.form.city = '',
            this.form.state = '',
            this.form.zip = '',
            this.form.amount = ''
            
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
    }
}
    
</script>

<style>

    .wrapper {

        margin-top: 20px;

    }

</style>