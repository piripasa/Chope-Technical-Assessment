# Chope API

# Table of Contents <a name="toc"></a>

1. [API](#api)
	- [Register](#register)
	- [Login](#login)
	- [Logout](#logout)
	- [Activity History](#activity)
2. [Error response](#er)

### Register <a name="register"></a> ([Top](#toc))
#### [http://localhost:8000/api/register](http://localhost:8000/api/register)
#### Request type - POST
##### Headers
header-data |Data Type | Description | Required
--- | --- | --- | ---
Content-Type | string | application/json | YES
##### POST Body

```
{
    "name": "Zaman",
    "email": "test@test.test",
    "password":"12345678",
    "password_confirmation": "12345678"
}

```
##### Response
```
{
    "success": true,
    "message": "Registered successfully"
}
```
```
{
    "success": false,
    "message": "ValidationException",
    "data": {
        "email": [
            "The email has already been taken."
        ]
    }
}
```

### Login <a name="login"></a> ([Top](#toc))
#### [http://localhost:8000/api/login](http://localhost:8000/api/login)
#### Request type - POST
##### Headers
header-data |Data Type | Description | Required
--- | --- | --- | ---
Content-Type | string | application/json | YES
##### POST Body

```
{
    "username": "test@test.test",
    "password":"12345678"
}

```
##### Response
```
{
    "success": true,
    "data": {
        "token_type": "Bearer",
        "expires_in": 3600,
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJjaG9wZSIsInN1YiI6MTAsImlhdCI6MTYxMTE0NzQwMSwiZXhwIjoxNjExMTUxMDAxfQ.r0BBVKEF90QrEdrihq7I5D7NzLyTI-Ze765dnNTsJ8k",
        "user": {
            "id": 10,
            "name": "Zaman",
            "email": "test@test.test"
        }
    },
    "message": "Login successfully"
}
```

```
{
    "success": false,
    "message": "AuthException",
    "data": {
        "error": [
            "These credentials do not match our records."
        ]
    }
}
```

### Activity History <a name="activity"></a> ([Top](#toc))
#### [http://localhost:8000/api/activity](http://localhost:8000/api/activity)
#### Request type - GET
##### Headers
header-data |Data Type | Description | Required
--- | --- | --- | ---
Authorization | string | Bearer token | YES

##### Response
```
{
    "success": true,
    "data": {
        "history": [
            {
                "created_at": "2021-01-20T12:24:04.250292Z",
                "activity": "Register"
            },
            {
                "created_at": "2021-01-20T12:27:27.533617Z",
                "activity": "Login"
            }
        ],
        "paginate": {
            "current_page": 1,
            "per_page": 25,
            "total_in_page": 2,
            "total_page": 1,
            "total": 2
        }
    },
    "message": "Activity history list"
}
```

### Logout <a name="logout"></a> ([Top](#toc))
#### [http://localhost:8000/api/logout](http://localhost:8000/api/logout)
#### Request type - POST
##### Headers
header-data |Data Type | Description | Required
--- | --- | --- | ---
Authorization | string | Bearer token | YES

##### Response
```
{
    "success": true,
    "message": "Logout successfully"
}
```

### Error response <a name="er"></a> ([Top](#toc))

```
{
    "success": false,
    "message": "NotFoundHttpException",
    "data": {
        "error": [
            "Requested route has not found"
        ]
    }
}
```
