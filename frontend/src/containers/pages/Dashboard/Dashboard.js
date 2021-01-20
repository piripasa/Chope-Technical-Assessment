import React, {Component} from 'react'
import auth from "../../../lib/auth";

class Dashboard extends Component {

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Dashboard</div>

                            <div className="card-body">
                                <div className="alert alert-success" role="alert">
                                    Welcome! {auth.getUser().name}
                                </div>

                                You are logged in!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}


export default Dashboard
