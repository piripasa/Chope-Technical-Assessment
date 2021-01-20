import store from '../store'
import {setLoader} from '../actions/ContentAction'

export const beginTheLoader = () => {
    console.log('dispatching start')
    store.dispatch(setLoader(true))
}

export const endTheLoader = () => {
    console.log('dispatching end')
    store.dispatch(setLoader(false))
}
