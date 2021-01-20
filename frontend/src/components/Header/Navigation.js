import React, {Component} from 'react'
import {Link} from 'react-router-dom'
import auth from "../../lib/auth";
import Logout from "../Auth/Logout";

class Navigation extends Component {

    render() {
        return (
            <div className="collapse navbar-collapse" id="navbarSupportedContent">
                <ul className="navbar-nav ml-auto">
                    {
                        !auth.isLoggedIn() ?
                            <React.Fragment>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/login">Login</Link>
                                </li>

                                <li className="nav-item">
                                    <Link className="nav-link" to="/register">Register</Link>
                                </li>
                            </React.Fragment> :
                            <React.Fragment>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/dashboard">Dashboard</Link>
                                </li>

                                <li className="nav-item">
                                    <Link className="nav-link" to="/activity">Activity Log</Link>
                                </li>
                                <li className="nav-item">
                                    <Logout/>
                                </li>
                            </React.Fragment>
                    }

                </ul>
            </div>
        )
    }
}

export default Navigation
