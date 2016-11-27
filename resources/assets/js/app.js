import Vue from 'vue';
import VueResource from 'vue-resource';
import filePicker from './components/file-picker'
import search from './components/search';

Vue.use(VueResource);

new Vue({
    el: 'body',
    components: { filePicker, search }
});