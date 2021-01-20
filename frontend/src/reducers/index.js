import {combineReducers} from 'redux'
import LoaderReducer from "./LoaderReducer";
import ActivityReducer from "./ActivityReducer";
import AuthReducer from "./AuthReducer";

const rootReducer = combineReducers({
    loaderReducer: LoaderReducer,
    activityReducer: ActivityReducer,
    authReducer: AuthReducer,
});

export default rootReducer
