import React, {Component} from "react";
import {connect} from 'react-redux'
import auth from '../../../lib/auth'
import {authLogin} from "../../../actions/AuthAction";
import {bindActionCreators} from "redux";
import LaddaButton, {EXPAND_RIGHT} from 'react-ladda';

class Login extends Component {

    constructor(props) {
        super(props);
        this.authenticate = this.authenticate.bind(this);
        this.state = {
            username: "",
            password: "",
            loading: false,
            error: null
        };
    }

    authenticate = () => {
        this.setState({
            loading: !this.state.loading
        });
        this.props.authLogin(this.state).then((res) => {
            if (res.type === 'AUTH_LOGIN_SUCCESS') {
                let json = {}
                json.token = res.payload.data.data.access_token

                json.user = res.payload.data.data.user
                auth.login(json);
                window.location = "/dashboard";
            } else {
                this.setState({
                    loading: !this.state.loading,
                    error: res.error.response.data.data.error
                });
            }
        })
    }

    handleChange = (e) => {
        const target = e.target;
        const value = target.value;
        const name = target.name;
        this.setState({
            [name]: value
        })
    }

    renderError(key) {
        const {errors} = this.props
        if (errors[key]) {
            return (
                <span className="invalid-feedback" role="alert">
                    <strong>{errors[key]}</strong>
                </span>
            )
        }
        return null
    }

    render() {
        if (auth.isLoggedIn()) {
            window.location = "/dashboard";
        }
        const {errors} = this.props
        return (
            <div className="login-box">
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-md-8">
                            <div className="card">
                                <div className="card-header">Login</div>

                                <div className="card-body">
                                    <form onSubmit={e => {
                                        e.preventDefault()
                                        this.authenticate()
                                    }}>
                                        {this.state.error ?<div className="alert alert-danger" role="alert">{this.state.error}</div>:null}
                                        <div className="form-group row">
                                            <label htmlFor="email" className="col-md-4 col-form-label text-md-right">Username</label>
                                            <div className="col-md-6">
                                                <input type="email"
                                                       className={`form-control ${errors['username'] ? 'is-invalid' : ''}`}
                                                       name="username" required onChange={this.handleChange}/>
                                                {this.renderError('username')}
                                            </div>
                                        </div>

                                        <div className="form-group row">
                                            <label htmlFor="password" className="col-md-4 col-form-label text-md-right">Password</label>
                                            <div className="col-md-6">
                                                <input type="password"
                                                       className={`form-control ${errors['password'] ? 'is-invalid' : ''}`}
                                                       name="password" required onChange={this.handleChange}/>
                                                {this.renderError('password')}
                                            </div>
                                        </div>

                                        <div className="form-group row mb-0">
                                            <div className="col-md-8 offset-md-4">
                                                <LaddaButton
                                                    loading={this.state.loading}
                                                    className="btn btn-primary"
                                                    data-style={EXPAND_RIGHT}
                                                    data-spinner-color="#ddd"
                                                >
                                                    Login
                                                </LaddaButton>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

function mapDispatchToProps(dispatch) {
    return bindActionCreators({
        authLogin
    }, dispatch)
}

function mapStateToProps(state) {
    return {
        errors: state.authReducer.errors
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(Login)
