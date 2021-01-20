import React, {Component} from 'react'
import auth from "../../../lib/auth";
import {bindActionCreators} from "redux";
import {authRegister} from "../../../actions/AuthAction";
import {connect} from "react-redux";
import LaddaButton, {EXPAND_RIGHT} from "react-ladda";


class Register extends Component {

    constructor(props) {
        super(props);
        this.register = this.register.bind(this);
        this.state = {
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            loading: false,
            error: null,
        };
    }

    register = () => {
        this.setState({
            loading: !this.state.loading
        });
        this.props.authRegister(this.state).then((res) => {
            if (res.type === 'AUTH_REGISTER_SUCCESS') {
                this.setState({
                    name: "",
                    email: "",
                    password: "",
                    password_confirmation: "",
                    loading: false,
                    error: null,
                })
                alert(res.payload.data.message);
                window.location = "/login";
            } else {
                this.setState({
                    loading: !this.state.loading
                });
            }
        })
    }

    handleChange = (e) => {
        this.setState({
            [e.target.name]: e.target.value
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
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Register</div>

                            <div className="card-body">
                                <form onSubmit={e => {
                                    e.preventDefault()
                                    this.register()
                                }}>

                                    <div className="form-group row">
                                        <label htmlFor="name"
                                               className="col-md-4 col-form-label text-md-right">Name</label>
                                        <div className="col-md-6">
                                            <input type="text"
                                                   className={`form-control ${errors['name'] ? 'is-invalid' : ''}`}
                                                   name="name"
                                                   required onChange={this.handleChange}/>
                                            {this.renderError('name')}
                                        </div>
                                    </div>

                                    <div className="form-group row">
                                        <label htmlFor="email" className="col-md-4 col-form-label text-md-right">E-Mail
                                            Address</label>
                                        <div className="col-md-6">
                                            <input type="email"
                                                   className={`form-control ${errors['email'] ? 'is-invalid' : ''}`}
                                                   name="email"
                                                   required onChange={this.handleChange}/>
                                            {this.renderError('email')}
                                        </div>
                                    </div>

                                    <div className="form-group row">
                                        <label htmlFor="password"
                                               className="col-md-4 col-form-label text-md-right">Password</label>
                                        <div className="col-md-6">
                                            <input type="password"
                                                   className={`form-control ${errors['password'] ? 'is-invalid' : ''}`}
                                                   name="password"
                                                   required onChange={this.handleChange}/>
                                            {this.renderError('password')}
                                        </div>
                                    </div>

                                    <div className="form-group row">
                                        <label htmlFor="password-confirm"
                                               className="col-md-4 col-form-label text-md-right">Confirm
                                            Password</label>
                                        <div className="col-md-6">
                                            <input type="password"
                                                   className="form-control"
                                                   name="password_confirmation"
                                                   required onChange={this.handleChange}/>
                                        </div>
                                    </div>

                                    <div className="form-group row mb-0">
                                        <div className="col-md-6 offset-md-4">
                                            <LaddaButton
                                                loading={this.state.loading}
                                                className="btn btn-primary"
                                                data-style={EXPAND_RIGHT}
                                                data-spinner-color="#ddd"
                                            >
                                                Register
                                            </LaddaButton>
                                        </div>
                                    </div>
                                </form>
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
        authRegister
    }, dispatch)
}

function mapStateToProps(state) {
    return {
        errors: state.authReducer.errors
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(Register)
