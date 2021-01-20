import React, {Component} from 'react';
import ContentBody from "../../../components/Activity/Content/ContentBody";

class Content extends Component {
    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Activity History</div>

                            <div className="card-body">
                                <ContentBody history={this.props.history}/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Content;
