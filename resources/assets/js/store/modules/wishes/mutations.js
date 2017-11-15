import * as types from '../../mutation-types';
import {addOrUpdateItem, removeItemByKey} from '../../helpers';

export default {
    [types.ADD_OR_UPDATE_WISH]: (state, wish) => addOrUpdateItem(state, wish),
    [types.DELETE_WISH_BY_ID]: (state, id) => removeItemByKey(state, id)
}