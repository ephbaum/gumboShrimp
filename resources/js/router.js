import Vue from 'vue'
import VueRouter from 'vue-router'
import mainApp from './mainApp'
import NavBar from './components/NavBar'
import ShopComponent from './components/ShopComponent'
import ItemComponent from './components/ItemComponent'
import LoginComponent from './components/LoginComponent'
import RegisterComponent from './components/RegisterComponent'
import HeaderComponent from './components/HeaderComponent'
import UserComponent from './components/UserComponent'


export const router = new VueRouter({ 
    mode: 'history', 
    
    routes: [ 
        {
            path: '/', 
            component: mainApp,
    
            children: [
                {
                    path: 'register',
                    component: RegisterComponent

                },

                {
                    path: 'create',
                    component: LoginComponent
                },

                {
                    path: 'add-item',
                    component: ItemComponent
                }
            ]
        },
    ]
})