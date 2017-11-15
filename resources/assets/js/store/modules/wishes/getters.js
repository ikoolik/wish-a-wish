import {filter, find} from 'lodash';

export const wishesByUserId = state => id => filter(state.items, wish => wish.user_id === id);
export const wishById = state => id => find(state.items, wish => wish.id === id);

export const activeWishesByUserId = state => id => filter(wishesByUserId(state)(id), wish => wish.archived_at === null);