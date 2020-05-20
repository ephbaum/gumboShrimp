import Vue from 'vue'
import VueRouter from 'vue-router'
import mainApp from './mainApp'
import NavBar from './components/NavBar'
import ShopComponent from './components/ShopComponent'
import ItemComponent from './components/ItemComponent'
import LoginComponent from './components/LoginComponent'
import RegisterComponent from './components/RegisterComponent'
import UserComponent from './components/UserComponent'


Vue.use(VueRouter)
export const router = new VueRouter({ 
    mode: 'history', 
    
    routes: [ 
        {
            path: '/', 
            component: mainApp,
            props: {loginComponent: LoginComponent},
    
            children: [
                {
                    path: 'items',
                    component: ItemComponent

                },
                {
                path: 'navBar',
                component: NavBar

                },
                {
                    path: 'shop',
                    component: ShopComponent

                },

            ]
        },
    ]
})