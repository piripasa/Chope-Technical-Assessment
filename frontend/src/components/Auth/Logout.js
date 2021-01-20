import React, {Component} from "react";
import {connect} from 'react-redux'
import auth from '../../lib/auth'
import {authLogout} from "../../actions/AuthAction";
import {bindActionCreators} from "redux";

class Logout extends Component {

    render() {
        return (
            <a className="nav-link" href="#" onClick={event => {
                event.preventDefault()
                this.props.authLogout().then(() => {
                    auth.logout()
                    window.location = "/login";
                })
            }}>Logout</a>
        )
    }
}

function mapDispatchToProps(dispatch) {
    return bindActionCreators({
        authLogout
    }, dispatch)
}

export default connect(null, mapDispatchToProps)(Logout)
