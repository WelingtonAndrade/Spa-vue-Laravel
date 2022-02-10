require('./bootstrap');
import Vue from 'vue';
import App from './components/mainapp'
import router from './router'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import commom from "./commom";
Vue.use(ViewUI);
Vue.mixin(commom);
const app = new Vue ({
    el: '#app',
    router,
    render: h => h(App)
})
