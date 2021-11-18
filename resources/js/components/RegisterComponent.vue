<template>
    <b-container fluid>
      <b-card  bg-variant="dark" text-variant="white" title="register">
        <b-form @submit="register">
            <b-form-group id="nameInputGroup"
                        label="Name"
                        label-for="name">
                <b-form-input id="name"
                            type="name"
                            v-model="form.name"
                            :state="!$v.form.name.$invalid"
                            aria-describedby="nameLiveFeedback"
                            placeholder="Name" />
                <b-form-invalid-feedback id="nameLiveFeedback">
                    Please enter a valid First Name
                </b-form-invalid-feedback>
            </b-form-group>

            <b-form-group id="emailInputGroup"
                        label="Email"
                        label-for="email">
                <b-form-input id="email"
                            type="email"
                            v-model="form.email"
                            :state="!$v.form.email.$invalid"
                            aria-describedby="emailLiveFeedback"
                            placeholder="Enter Email" />
                <b-form-invalid-feedback id="emailLiveFeedback">
                    Please enter a valid Email
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-group id="passwordLoginGroup"
                        label="Password"
                        label-for="password">
                <b-form-input id="password"
                                type="password"
                                :state="!$v.form.password.$invalid"
                                v-model="form.password" />
                <b-form-invalid-feedback id="input2LiveFeedback">
                    Your password must be at least 8 characters
                </b-form-invalid-feedback>
            </b-form-group>
            <b-button type="submit" @click.prevent="register" variant="dark" size="lg" :disabled="$v.form.$invalid">
                Register
            </b-button>
        </b-form>
      </b-card>
    </b-container>
</template>


<script>
import { mapActions, mapGetters } from "vuex";
import { validationMixin } from "vuelidate";
import { required, minLength, email } from "vuelidate/lib/validators";

export default {
    name: "register",
    data() {
      return {
        
        form: {
            name: "",
            email: "",
            password: "",
        }
      }
    },
    mixins: [
      validationMixin
    ],
    validations: {
      form: {
        name: {
        required
        },
        password: {
          required
        },
        email: {
          required,
          email
        }
      }
    },
    methods: {
      register() {

        const formData = {
            name: this.form.name,
            email: this.form.email,
            password: this.form.password,
		    };
		
		// this is out of scope in catch -- set this to self
		  let self=this;

        axios.post("/api/register", formData).then(({data}) => {

            this.$cookie.set('token', data.token)
            this.$cookie.set('user', data.user.email)
            auth.setAuthToken(data.token)
            auth.register(data.token, data.user.email);
    
			this.$router.push({path: 'shop'});
			
			self.$notify({
				group: 'notifications',
				type: 'success',
				title: 'Success!',
				text: 'You are now logged in',
				duration: '15000',
				width: '100%'
			});
        })
        .catch(function (error) {

			self.$notify({
				group: 'notifications',
				type: 'error',
				title: error,
				text: 'INVALID CREDENTIALS - PLEASE TRY AGAIN.',
				duration: '15000',
				width: '100%'
			});
        });
        
      },
      register() {
        console.log("[RegisterComponent]->register")
      }
    },
    computed: mapGetters(['isAuthenticated']),
}

</script>
