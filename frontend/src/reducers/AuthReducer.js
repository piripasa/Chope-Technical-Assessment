import {AUTH_LOGIN, AUTH_LOGOUT, AUTH_REGISTER} from '../actions/AuthAction'

const initialState = {
    success: false,
    errors: []
};

export default function api(state = initialState, action) {
    switch (action.type) {
        case `${AUTH_LOGIN}_SUCCESS`:
            return {
                ...state, success: true, errors: []
            }
        case `${AUTH_LOGIN}_FAIL`:
            return {
                ...state, errors: action.error.response.data.data
            }
        case `${AUTH_REGISTER}_SUCCESS`:
            return {
                ...state, errors: []
            }
        case `${AUTH_REGISTER}_FAIL`:
            return {
                ...state, errors: action.error.response.data.data
            }
        case `${AUTH_LOGOUT}_SUCCESS`:
            return {
                ...state, success: false, errors: []
            }
        default:
            return state;
    }
}
