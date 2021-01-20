import React, {Component} from 'react';
import Moment from 'react-moment';

class ListItem extends Component {

    render() {
        const {item} = this.props
        return (
            <tr>
                <td>{item.activity}</td>
                <td><Moment fromNow ago>{item.created_at}</Moment> ago</td>
            </tr>
        );
    }
}

export default ListItem;
