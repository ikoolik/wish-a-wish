import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import UserWishes from './pages/UserWishes.vue';
import User from './pages/User.vue';
import CreateWish from './pages/wish/Create.vue';
import ShowWish from './pages/wish/Show.vue';
import EditWish from './pages/wish/Edit.vue';

export default new VueRouter({
    mode: 'history',
    routes: [
        {path: '/:slug', component: User, name: 'user'},
        {path: '/:slug/wishes', component: UserWishes, name: 'user.wishes'},
        {path: '/wishes/create', component: CreateWish, name: 'wishes.create'},
        {path: '/wishes/:wishId', component: ShowWish, name: 'wishes.show'},
        {path: '/wishes/:wishId/edit', component: EditWish, name: 'wishes.edit'}
    ]
});