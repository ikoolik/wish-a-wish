import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import UserWishes from './pages/UserWishes.vue';
import User from './pages/User.vue';

export default new VueRouter({
    mode: 'history',
    routes: [
        {path: '/:slug', component: User},
        {path: '/:slug/wishes', component: UserWishes},
        {path: '/:slug/wishes/create'},
        {path: '/:slug/wishes/:wishId'}
        // {path: '/login', component: Login},
        // {path: '/:slug/wishes/:wishId', component: Wish},
        // {path: '*', component: Index}
    ]
});