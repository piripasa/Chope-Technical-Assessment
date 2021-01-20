import {FETCH_ACTIVITY_HISTORY} from "../actions/ActivityAction"

const INITIAL_STATE = {
    history: [],
    pagination: {}
}

export default function (state = INITIAL_STATE, action) {
    switch (action.type) {
        case `${FETCH_ACTIVITY_HISTORY}_SUCCESS`:
            return {
                ...state,
                history: action.payload.data.data.paginate.current_page === 1 ? action.payload.data.data.history : state.history.concat(action.payload.data.data.history),
                pagination: action.payload.data.data.paginate
            }
        default:
            return state;

    }
}
