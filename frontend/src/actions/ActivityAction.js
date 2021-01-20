export const FETCH_ACTIVITY_HISTORY = 'FETCH_ACTIVITY_HISTORY'

export const fetchActivityHistory = (query) => {
    return {
        type: FETCH_ACTIVITY_HISTORY,
        payload: {
            request: {
                method: 'get',
                url: `activity?${query}`
            }
        }
    }
}
