import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        // {path: '/login', component: Login},
        // {path: '/:slug/wishes', component: UserWishes},
        // {path: '/:slug/wishes/:wishId', component: Wish},
        // {path: '*', component: Index}
    ]
});