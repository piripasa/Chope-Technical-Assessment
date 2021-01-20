export const SET_LOADER = 'SET_LOADER'

export const setLoader = (value) => {

    return {
        type: SET_LOADER,
        payload: {
            value
        }
    }
}
