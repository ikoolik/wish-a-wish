import * as types from '../../mutation-types';
import {addOrUpdateItem} from '../../helpers';

export default {
    [types.ADD_OR_UPDATE_WISH]: (state, wish) => addOrUpdateItem(state, wish)
}