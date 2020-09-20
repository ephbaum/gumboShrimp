<template>
    
        <div>
            <b-navbar toggleable="md" type="light" variant="dark" fixed="top">
            <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
                <b-collapse is-nav id="nav_collapse">
                    
                    <b-navbar-brand to="/"><i class="fas fa-shopping-cart"></i> changocart</b-navbar-brand>

                    <b-navbar-nav>
                        <b-nav-item v-if="isAuthenticated" to="add-item">Add Item</b-nav-item>
                        <b-nav-item v-if="!isAuthenticated" to="login">Login</b-nav-item>                
                    </b-navbar-nav>

                    <b-navbar-nav class="ml-auto"  v-if="isAuthenticated">
                        <b-nav-item v-if="isAuthenticated" @click="logout" right> 
                            logout
                        </b-nav-item>
                    </b-navbar-nav>

                </b-collapse>

                <b-navbar-nav class="ml-auto">
                    <b-nav-item type="light" to="cart" v-if="cartCount > 0"><button><i class="fas fa-shopping-basket" right> Cart <span v-if="cartCount != 0"> {{ cartCount }}</span></i></button></b-nav-item>
                </b-navbar-nav>
                
            </b-navbar>
        </div>
    
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
        
        computed: mapGetters(['isAuthenticated', 'currentUser', 'cartCount']),            
    }
</script>

<style >
    .b-img {
        display: block;
        max-width: 100%;
        height: auto;
    }

    .container {
        margin-bottom: 10px;
    }
</style>

