import Vue from 'vue';
import router from './router';
import store from './store';

import Search from './components/Search.vue';
import BreadCrumbs from './components/BreadCrumbs.vue';
import Logout from './components/Logout.vue';

import './filters';
import './bootstrap';

new Vue({
    router, store,
    el: '#app',
    components: { Search, BreadCrumbs, Logout }
});
