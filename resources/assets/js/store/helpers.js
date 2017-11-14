import Vue from 'vue';
import {findIndex, map, filter} from 'lodash'

export const removeItemByKey = (state, val, key = 'id', node = 'items') => {
    Vue.set(state, node, filter(state[node], el => el[key] !== val));
};

export const addOrUpdateItem = (state, item, key = 'id', node = 'items') => {
    if (itemExists(state[node], item, key)) {
        Vue.set(state, node, listWithUpdatedItem(state[node], item, key));
    } else {
        Vue.set(state, node, [...state[node], item]);
    }
};

const listWithUpdatedItem = (items, item, key) => {
    return map(items, existing => {
        if (existing[key] === item[key]) {
            return Object.assign(existing, item)
        }
        return existing;
    })
};

const itemExists = (items, item, key) => {
    return findIndex(items, existing => existing[key] === item[key]) > -1;
};