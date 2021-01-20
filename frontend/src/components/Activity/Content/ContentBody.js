import React, {Component} from 'react';
import ListItem from "./ListItem";
import {getKey} from "../../../lib/function";

class ContentBody extends Component {
    renderList() {
        return this.props.history.map(item => {
            return <ListItem key={getKey()} item={item}/>
        })
    }

    render() {
        return (
            <table className="table table-striped">
                <thead className="thead-dark">
                    <tr>
                        <th scope="col">Action</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>
                <tbody>
                    {this.renderList()}
                </tbody>
            </table>
        );
    }
}

export default ContentBody;
