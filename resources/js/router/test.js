// resources/assets/js/router/index.js
import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        // {
        //     name: 'test',
        //     path: '/test',
        //     component: resolve => void(require(['../components/ceshi.vue'], resolve))
        // },
        {
            path: '/',
            name: 'home',
            component: resolve => void(require(['../components/Head/Home.vue'], resolve)),
            meta: {title: 'home'}
        },
        {
            path: '/school',
            name: 'school',
            component: resolve => void(require(['../components/Head/School.vue'], resolve)),
            meta: {title: 'school'}
        },
        {
            path: '/course',
            name: 'course',
            component: resolve => void(require(['../components/Head/Course.vue'], resolve)),
            meta: {title: 'course'}
        }
    ]
});
