<template> 

        <b-container fluid class="col-md-12 bg-dark">
            <div>
              <b-navbar type="dark" variant="dark" text="white">
                <b-navbar-nav>
                    <b-navbar-brand href="#">NavBar</b-navbar-brand>
                  
                  <b-nav-item-dropdown text="User" right>
                    <b-dropdown-item href="#">Account</b-dropdown-item>
                    <b-dropdown-item href="#">Settings</b-dropdown-item>
                  </b-nav-item-dropdown>
                </b-navbar-nav>
              </b-navbar>
            </div>
            
            <b-row>
               
                <b-col  class="col-md-6" >
                 <b-img thumbnail fluid src="../img/fruits.jpeg" alt="Image 1"></b-img>
                </b-col>
                <b-col class="col-md-6" >
                 <b-img thumbnail fluid src="../img/fruits.jpeg" alt="Image 1"></b-img>

                </b-col>

            </b-row>

          </b-container>

</template>

<script>
    import { mapActions, mapGetters } from "vuex";
import { validationMixin } from "vuelidate";
import { required, minLength, email } from "vuelidate/lib/validators";
    export default {
        name: "navBar",
        data(){
            return {
            }
        },
        methods: {
           
            logout() {
                this.$store.dispatch('logout');
            }
        },
        
        computed: mapGetters(['isAuthenticated']),
            
    }
</script>
<style >
.b-img {
  display: block;
  max-width: 100%;
  height: auto;
}

</style>

