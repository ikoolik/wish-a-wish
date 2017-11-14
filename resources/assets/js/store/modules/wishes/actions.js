import axios from 'axios';
import {each} from 'lodash';
import {processUser} from '../users/actions';
import * as mutations from '../../mutation-types';

export const processWish = (store, wish) => {
    if(wish.user) processUser(store, wish.user);
    delete wish.user;

    store.commit(mutations.ADD_OR_UPDATE_WISH, wish);
};

export const fetchUserWishes = (store, slug) => {
    axios.get(`/api/users/${slug}/wishes`).then(res => {
        each(res.data, wish => processWish(store, wish))
    })
};