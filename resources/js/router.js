import Vue from 'vue'
import VueRouter from 'vue-router'
import mainApp from './mainApp'
import ShopComponent from './components/ShopComponent'
import AddItemComponent from './components/AddItemComponent'
import LoginComponent from './pages/LoginComponent'
import RegisterComponent from './components/RegisterComponent'
import HeaderComponent from './components/HeaderComponent'
import CartComponent from './components/CartComponent'
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
                    components: {body: RegisterComponent, header: HeaderComponent},
                },

                {
                    path: 'login',
                    components: {body: LoginComponent, header: HeaderComponent},
                },

                {
                    path: 'checkout',
                    components: {body: CheckoutComponent, header: HeaderComponent},
                },

                {
                    path: 'orders',
                    components: {body: OrdersComponent, header: HeaderComponent}
                },

                {
                    path: 'cart',
                    components: {body: CartComponent}
                },

                {
                    path: 'add-item',
                    components: {body: AddItemComponent, header: HeaderComponent},
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
            ]
        },
    ]
})