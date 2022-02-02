import App from "../components/App";

require('./bootstrap');
import Vue from 'vue';

import VueRouter from "vue-router";
import {routes} from "./routes";
Vue.use(VueRouter);
const  router = new VueRouter({
    mode: 'history',
    routes
})

//Criando Instancia de Vue

const app = new Vue ({
    el: '#app',
    router,
    render: h => h(App)
})
