import axios from 'axios';
import {each} from 'lodash';
import {processWish} from '../wishes/actions';
import * as mutations from '../../mutation-types';

export const processUser = (store, user) => {
    if(user.wishes) each(user.wishes, wish => processWish(store, wish));
    delete user.wishes;

    store.commit(mutations.ADD_OR_UPDATE_USER, user);
};

export const fetchUser = (store, slug) => {
    axios.get(`/api/users/${slug}`).then(res => {
        processUser(store, res.data)
    })
};