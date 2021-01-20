import React, {Component} from 'react';

class Page404 extends Component {
    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-body">
                                <h1 className="float-left display-3 mr-4">404</h1>
                                <h4 className="pt-3">Oops! You're lost.</h4>
                                <p className="text-muted float-left">The page you are looking for was not found.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Page404;
