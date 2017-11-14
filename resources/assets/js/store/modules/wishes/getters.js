import {filter} from 'lodash';

export const wishesByUserId = state => id => filter(state.items, wish => wish.user_id === id);