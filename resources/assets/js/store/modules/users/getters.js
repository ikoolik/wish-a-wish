import {find} from 'lodash';

export const userBySlug = state => slug => find(state.items, user => user.slug === slug);
export const userById = state => id => find(state.items, user => user.id === id);