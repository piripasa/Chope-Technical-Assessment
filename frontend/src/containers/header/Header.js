import React, {Component} from 'react'
import Logo from "../../components/Header/Logo";
import Navigation from "../../components/Header/Navigation";

class Header extends Component {

    render() {
        return (
            <nav className="navbar navbar-expand-md navbar-light shadow-sm">
                <div className="container">
                    <Logo/>
                    <Navigation/>
                </div>
            </nav>
        )
    }
}

export default Header
