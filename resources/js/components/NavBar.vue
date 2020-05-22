<template> 
    <div id="navig">

    
        <b-container fluid class="col-md-12 ">
            <div>
              <b-navbar toggleable="md" type="dark" variant="dark" fixed="top">
            <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
            <b-collapse is-nav id="nav_collapse">
                <b-navbar-brand to="#"><i class="fas fa-shopping-cart"></i> changocart</b-navbar-brand>
                <b-navbar-brand>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">login</button>
                </b-navbar-brand>
                <b-navbar-nav>
                    <b-nav-item v-if="isAuthenticated" to="items/">Add Item</b-nav-item>
                </b-navbar-nav>
                     
                  
                <b-navbar-nav class="ml-auto"  v-if="isAuthenticated" >
                   <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#"> <i class="far fa-user-circle" style="color: green;"></i> Hi, Chango_______</a>
                        <a class="dropdown-item" href="#"><i class="far fa-address-card" style="color: green;"></i> Your Account</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-tasks" style="color: green;"></i> Your Orders</a>
                        <a class="dropdown-item" href="#"></a>
                        <a class="dropdown-item" href="#" v-if="isAuthenticated"  @click="logout" right> <i class="far fa-address-book" style="color: red;"></i> Logout </a>
                        
                      </div>
                    </li>

                      <b-nav-item type="light" to="/"><button type="button" class="btn btn-primary"><i class="fas fa-shopping-basket" right></i> Basket</button></b-nav-item>
                     
                    <b-nav-item v-if="isAuthenticated && currentUser" @click="logout" right> Logout - {{ currentUser.name }}
                    </b-nav-item>

                   
                </b-navbar-nav>
                  <!-- <b-navbar-nav class="ml-auto">
                                      

                </b-navbar-nav> -->
            </b-collapse>
        </b-navbar>
              <!-- <b-navbar type="dark" variant="dark" text="white">
                <b-navbar-nav>
                    <b-navbar-brand href="#">NavBar</b-navbar-brand>
                  
                  <b-nav-item-dropdown text="User" right>
                    <b-dropdown-item href="#">Account</b-dropdown-item>
                    <b-dropdown-item href="#">Settings</b-dropdown-item>
                  </b-nav-item-dropdown>
                </b-navbar-nav>
              </b-navbar> -->
            </div>
            
           

          </b-container>

          
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
        
        computed: mapGetters(['isAuthenticated', 'currentUser']),
        routeName() {
            console.log("ROUTE: " + this.$route.name)
            return this.$route.name;
        }
            
    }
</script>
<style >
.b-img {
  display: block;
  max-width: 100%;
  height: auto;
}

</style>

