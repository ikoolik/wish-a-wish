import Vue from 'vue';
import moment from 'moment';

Vue.filter('date', string => {
    return moment(string).format('Y-MM-DD')
});