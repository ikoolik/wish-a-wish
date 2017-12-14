import Vue from 'vue';
import axios from 'axios';
import {each} from 'lodash';
import {processWish} from '../wishes/actions';
import * as mutations from '../../mutation-types';

export const processUser = (store, user) => {
    if(user.wishes) each(user.wishes, wish => processWish(store, wish));
    delete user.wishes;

    store.commit(mutations.ADD_OR_UPDATE_USER, user);

    return user;
};

export const fetchUser = (store, slug) => {
    return axios.get(`/api/users/${slug}`).then(res => {
        return processUser(store, res.data)
    })
};

export const updateUser = (store, user) => {
    return axios.patch(`/api/users/${user.current_slug}`, user).then(res => {
        return processUser(store, res.data);
    })
};