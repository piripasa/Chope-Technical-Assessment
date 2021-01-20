import {SET_LOADER} from "../actions/ContentAction";

const initialState = {
    loading: false
};

export default function (state = initialState, action) {
    switch (action.type) {
        case SET_LOADER:
            return {
                ...state, loading: action.payload.value
            }
        default:
            return state
    }
}
