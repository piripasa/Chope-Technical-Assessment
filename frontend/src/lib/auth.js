import * as R from 'ramda';

const context = 'context';

const getContext = () => {
    const c = localStorage.getItem(context);
    return typeof c !== 'undefined' ? (R.is(String, c) ? JSON.parse(c) : {}) : {};
};

const getToken = R.compose(c => c.hasOwnProperty('token') ? c.token : '', getContext);
const getUser = R.compose(c => c.hasOwnProperty('user') ? c.user : '', getContext);
const logout = () => localStorage.removeItem(context);
const login = (c) => {
    localStorage.removeItem(context);
    localStorage.setItem(context, JSON.stringify(c));
}

const loggedIn = (c) => !!(R.is(Object, c) && c.token);
const isLoggedIn = R.compose(loggedIn, getContext);

const authorizedRoutes = (routes) => routes.filter(({authorizeFor}) => authorizeFor === undefined);

const auth = {
    getToken,
    getUser,
    getContext,
    logout,
    login,
    isLoggedIn,
    authorizedRoutes
};

export default auth;
