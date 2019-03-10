import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import App from './App';
import router from './router';
import store from './store';

Vue.use(BootstrapVue);
import '../css/app.scss';

new Vue({
    template: '<App/>',
    components: { App },
    router,
    store
}).$mount('#app');