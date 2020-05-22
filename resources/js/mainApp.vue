<template>    
   <div>
        <nav-bar ></nav-bar>   
        <router-view v-if="isAuthenticated"></router-view>

        <header-component></header-component>
        <b-container fluid class="p-4 ">
            <b-row>  
             
                <b-col>
                        <!-- Modal -->
                        <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog"  aria-hidden="true" >
                        <div class="modal-dialog modal-dialog-centered " role="document">
                            <div class="modal-content"  >
                            <!-- <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div> -->
                            <!-- <div class="modal-body"> -->
                                                <login-component class="col-lg-12" v-if="!isAuthenticated" :is="loginComponent" >
                                        
                                            </login-component>  
                                <!-- <span aria-hidden="true">&times;</span> -->

                            </div>
                                <!-- <div class="modal-footer"> -->
                                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                <!-- </div> -->
                            <!-- </div> -->
                        </div>
                        </div>
                 <!-- <login-component class="col-md-8" v-if="!isAuthenticated" :is="loginComponent" >
                   
                    </login-component>            -->
                   
                </b-col>
                <!-- <b-col>
                    <register-component class="col-md-8" v-if="!isAuthenticated"  ></register-component>
                </b-col> -->
            </b-row>
            <router-view v-if="isAuthenticated" ></router-view>
            <shop-component class="col-md-11"></shop-component>
        </b-container>
    </div>   
</template>

<script>
    import NavBar from './components/NavBar'
    import LoginComponent from './components/LoginComponent'
    import RegisterComponent from './components/RegisterComponent'
    import HeaderComponent from './components/HeaderComponent'
    import ShopComponent from './components/ShopComponent'
    import { mapGetters, mapActions } from 'vuex';
    export default {
        name: "mainApp",
        components: {
            NavBar,
            RegisterComponent,
            ShopComponent,
            LoginComponent,
            HeaderComponent,
            
        },
        props:  {loginComponent: LoginComponent, register:RegisterComponent},
        computed: mapGetters(['isAuthenticated'], ['currentUser']),
        methods: mapActions(['login']),
        mounted() {
            // if (window.auth.check()) {
            //     this.$router.push('shop');
            // }
        }
    }
</script>
