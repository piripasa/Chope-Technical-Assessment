import auth from "./auth";

function isAxiosErrorResponse(action) {
    return !!(action.error && action.error.request);
}

function isAxiosSuccessResponse(action) {
    if (typeof action.payload !== 'undefined') {
        return !!(!action.error && action.payload.data)
    }
    return false

}

const apiInterceptorMiddleware = ({dispatch}) => next => (action) => {
    const result = next(action);

    if (isAxiosSuccessResponse(action)) {
        //console.log(action)
    } else if (isAxiosErrorResponse(action)) {
        const statusCode = (action.error.data && action.error.data.status) ||
            (action.error.response && action.error.response.status);
        if (statusCode === 401 && action.type !== "AUTH_LOGIN_FAIL") {
            auth.logout();
            window.location.href = '/login';
        }
    }

    return result;
};

export default apiInterceptorMiddleware;
