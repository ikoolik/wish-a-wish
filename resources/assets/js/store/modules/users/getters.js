import {find} from 'lodash';

export const userBySlug = state => slug => find(state.items, user => user.slug === slug);