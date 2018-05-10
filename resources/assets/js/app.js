require('./bootstrap');

import App from './components/App'
Vue.config.productionTip = false;
import Vue from 'vue'
import router from './router'
import VueSocketio from 'vue-socket.io';
Vue.use(VueSocketio, 'http://localhost:3000');

const app = new Vue({
    el: '#app',
    router,
    render: h=> h(App)
});