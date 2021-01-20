import React, {Component} from 'react'
import { connect } from 'react-redux'
import Header from "./header/Header";
import Main from "./main/Main";
import Footer from "./footer/Footer";
import { Loader } from 'react-overlay-loader';
import '../App.css';

class App extends Component {

    render() {
        return (
            <div>
                <Header/>
                <Main/>
                <Footer/>
                {this.props.loading ? <Loader fullPage loading /> : null}
            </div>
        )
    }
}

function mapStateToProps(state) {
    return {
        loading: state.loaderReducer.loading
    }
}
export default connect(mapStateToProps)(App)
