import { createStore, applyMiddleware } from 'redux'
import rootReducer from './reducers'
import axios from 'axios';
import {multiClientMiddleware} from 'redux-axios-middleware'
import apiInterceptorMiddleware from "./lib/apiInterceptorMiddleware";
import {BASE_URL} from './config'
import auth from "./lib/auth";

const clients = {
    default: {
        client: axios.create({
            baseURL: `${BASE_URL}`,
            responseType: 'json',
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${auth.getToken()}`,
            }
        })
    },
    auth: {
        client: axios.create({
            baseURL: `${BASE_URL}`,
            responseType: 'json',
            headers: {
                "Content-Type": "application/json",
            }
        })
    }
}

const store = createStore(rootReducer, applyMiddleware(
    multiClientMiddleware(clients),
    apiInterceptorMiddleware
))

export default store
