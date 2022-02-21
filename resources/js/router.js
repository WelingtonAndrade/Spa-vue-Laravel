import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
import firstPage from './components/pages/myFirstVuePage'
import newRoutePage from './components/pages/newRoutePage'
import hooks from './components/pages/basic/hooks.vue'
import methods from './components/pages/basic/methods.vue'

// project pages
import home from './components/pages/home'
import tags from './admin/pages/tag.vue'
import category from "./admin/pages/category";


const routes = [
    //projects routes....

    {
        path: '/',
        component: home,

    },
    {
        path: '/tags',
        component: tags,

    },
    {
        path: '/category',
        component: category,

    },


    {
        path: '/my-new-vue-route',
        component: firstPage,

    },


]



export default new Router({
    mode: 'history',
    routes

})
