import React, {Component} from 'react'
import {Switch, Route} from 'react-router-dom'
import Page404 from "../pages/Errors/Page404";
import Login from "../pages/Auth/Login";
import Register from "../pages/Auth/Register";
import Dashboard from "../pages/Dashboard/Dashboard";
import AuthRoute from "../../lib/AuthRoute";
import Activity from "../pages/Activity/Activity";

class Content extends Component {
    render() {
        return (
            <Switch>
                <Route exact path="/login" name="List" component={Login} />
                <Route exact path="/register" name="List" component={Register} />
                <AuthRoute exact path='/dashboard' component={Dashboard}/>
                <AuthRoute exact path='/activity' component={Activity}/>
                <Route path="*" component={Page404} />
            </Switch>
        )
    }
}

export default Content
