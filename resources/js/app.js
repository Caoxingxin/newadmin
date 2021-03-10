import axios from 'axios'
Vue.prototype.axios = axios;

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import router from "./router/test"
import App from './App.vue';
import Vue from 'vue';


const app = new Vue({
    el:"#app",
    router,
    components: {App},
    template: '<App/>'
});
