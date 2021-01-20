import React from 'react';
import { Route, Redirect } from 'react-router-dom';
import auth from '../lib/auth'


const AuthRoute = ({component: Component,  ...rest}) => (
    <Route
        {...rest}
        render={props => {
            return auth.isLoggedIn()
                ? <Component {...props} />
                : <Redirect to={{
                    pathname:"/login",
                    state: { from: props.location }
                }} />
        }}
    />
);

export default AuthRoute;
