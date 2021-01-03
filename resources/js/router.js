import Vue from 'vue'
import VueRouter from 'vue-router'
import mainApp from './mainApp'
import NavBar from './components/NavBar'
import ShopComponent from './components/ShopComponent'
import AddItemComponent from './components/AddItemComponent'
import LoginComponent from './pages/LoginComponent'
import RegisterComponent from './components/RegisterComponent'
import HeaderComponent from './components/HeaderComponent'
import CartComponent from './components/CartComponent'
import UserComponent from './components/UserComponent'
import CheckoutComponent from './components/CheckoutComponent'
import OrdersComponent from './components/OrdersComponent'


export const router = new VueRouter({ 
    mode: 'history', 
    
    routes: [ 
        {
            path: '/', 
            component: mainApp,
    
            children: [
                {
                    path: '',
                    components: {body: ShopComponent, header: HeaderComponent},
                },

                {
                    path: 'shop',
                    components: {body: ShopComponent, header: HeaderComponent}
                },

                {
                    path: 'register',
                    components: {body: RegisterComponent},
                },

                {
                    path: 'login',
                    components: {body: LoginComponent},
                },
                {
                    path: 'checkout',
                    components: {body: CheckoutComponent},
                },
                {
                    path: 'orders',
                    components: {body: OrdersComponent, header: HeaderComponent}
                },


                {
                    path: 'add-item',
                    components: {body: AddItemComponent},
                    beforeEnter: (to, from, next) => {
                        if (!window.auth.check()) {
                            next({
                                path: '/'
                            });
                            return;
                        }
                        next();
                    },
                },

                {
                    path: 'cart',
                    components: {body: CartComponent}
                }
            ]
        },
    ]
})