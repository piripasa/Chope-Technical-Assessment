export const AUTH_LOGIN = 'AUTH_LOGIN'
export const AUTH_REGISTER = 'AUTH_REGISTER'
export const AUTH_LOGOUT = 'AUTH_LOGOUT'

export const authLogin = (data) => {
    return {
        type: AUTH_LOGIN,
        payload: {
            client: 'auth',
            request: {
                method: 'post',
                url: `login`,
                data
            }
        }
    }
}

export const authRegister = (data) => {
    return {
        type: AUTH_REGISTER,
        payload: {
            client: 'auth',
            request: {
                method: 'post',
                url: `register`,
                data
            }
        }
    }
}

export const authLogout = () => {
    return {
        type: AUTH_LOGOUT,
        payload: {
            request: {
                method: 'post',
                url: `logout`
            }
        }
    }
}
