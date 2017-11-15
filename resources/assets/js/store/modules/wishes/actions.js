import axios from 'axios';
import {map} from 'lodash';
import {processUser} from '../users/actions';
import * as mutations from '../../mutation-types';

export const processWish = (store, wish) => {
    if(wish.user) processUser(store, wish.user);
    delete wish.user;

    if(wish.booked_by && wish.booked_by.constructor === Object) {
        processUser(store, wish.booked_by);
        wish.booked_by = wish.booked_by.id
    }

    store.commit(mutations.ADD_OR_UPDATE_WISH, wish);

    return wish;
};

export const fetchUserWishes = (store, slug) => {
    return axios.get(`/api/users/${slug}/wishes`).then(res => {
        return map(res.data, wish => processWish(store, wish));
    })
};

export const createWish = (store, wish) => {
    return axios.post(`/api/wishes`, wish).then(res => {
        return processWish(store, res.data);
    })
};

export const fetchWish = (store, id) => {
    return axios.get(`/api/wishes/${id}`).then(res => {
        processWish(store, res.data)
    })
};

export const bookWish = (store, id) => {
    return axios.post(`/api/bookings`, {id}).then(res => {
        return processWish(store, res.data)
    })
};

export const unbookWish = (store, id) => {
    return axios.delete(`/api/bookings/${id}`).then(res => {
        return processWish(store, res.data)
    })
};

export const archiveWish = (store, id) => {
    return axios.post(`/api/archived`, {id}).then(res => {
        return processWish(store, res.data)
    })
};

export const deleteWish = (store, id) => {
    return axios.delete(`/api/wishes/${id}`).then(() => {
        store.commit(mutations.DELETE_WISH_BY_ID, id);
        return id;
    })
};