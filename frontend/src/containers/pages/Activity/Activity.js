import React, {Component} from 'react';
import {connect} from 'react-redux'
import {bindActionCreators} from "redux";
import Content from "./Content";
import {serialize} from "../../../lib/function";
import {fetchActivityHistory} from "../../../actions/ActivityAction";
import {beginTheLoader, endTheLoader} from "../../../lib/startStopTheLoader";

class Activity extends Component {

    constructor(props) {
        super(props);
        this.state = {
            page: 1
        };

        this.loadMore = this.loadMore.bind(this);
    }

    componentDidMount() {
        this.setState({}, () => this.handleFilter());
    }

    handleFilter() {
        beginTheLoader();
        this.props.fetchActivityHistory(serialize(this.state)).then(res => {
            endTheLoader()
        });
    }

    componentWillMount() {
        window.addEventListener('scroll', this.loadMore);
    }

    componentWillUnmount() {
        window.removeEventListener('scroll', this.loadMore);
    }

    loadMore() {
        const {pagination} = this.props
        if (pagination.current_page < pagination.total_page) {
            if (window.innerHeight + document.documentElement.scrollTop === document.scrollingElement.scrollHeight) {
                this.setState({
                    page: pagination.current_page + 1
                }, () => this.handleFilter());
            }
        }
    }

    render() {
        return (
            <Content history={this.props.history}/>
        );
    }
}

function mapDispatchToProps(dispatch) {
    return bindActionCreators({
        fetchActivityHistory
    }, dispatch)
}

function mapStateToProps(state) {
    return {
        history: state.activityReducer.history,
        pagination: state.activityReducer.pagination,
    }
}


export default connect(mapStateToProps, mapDispatchToProps)(Activity)
