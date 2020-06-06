import Vue from 'vue'
import VueRouter from 'vue-router'
import mainApp from './mainApp'
import NavBar from './components/NavBar'
import ShopComponent from './components/ShopComponent'
import AddItemComponent from './components/AddItemComponent'
import LoginComponent from './pages/LoginComponent'
import RegisterComponent from './components/RegisterComponent'
import HeaderComponent from './components/HeaderComponent'
import SpacerComponent from './components/SpacerComponent'
import CartComponent from './components/CartComponent'
import UserComponent from './components/UserComponent'


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
                    components: {body: LoginComponent, header: SpacerComponent},
                },

                {
                    path: 'add-item',
                    components: {body: AddItemComponent}
                },

                {
                    path: 'cart',
                    components: {body: CartComponent}
                }
            ]
        },
    ]
})