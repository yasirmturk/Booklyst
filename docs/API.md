# API Documentation

## User management

APIs for register, login etc

### Register
Creates a new user in the system and return user object. `email_verified_at` is null if email is not verified. Also returns the token if `grant_type` is set.

Endpoint: `POST /api/register`

Params: 
-- `client_id`
-- `client_secret`
-- `name`
-- `email`
-- `password`
-- `password_confirmation`
-- `roles[]`

Current Roles: `ROLE_PROVIDER`

Optional:
-- `grant_type` => 'password'
-- `scope` => '*'

### Login
Authenticate the user and returns token along with user object.

Endpoint: `POST /api/login`

Params: 
-- `client_id`
-- `client_secret`
-- `grant_type` => 'password'
-- `scope` => '*'
-- `username`
-- `password`

### Social Login
Authenticate the user via social token and returns token along with user object.

Endpoint: `POST /api/login/social`

Params:
-- `client_id`
-- `client_secret`
-- `access_token` => Token returned by OAuth Social login provider
-- `provider` => Provider
-- `roles[]`

Current Providers: `facebook`, `google`

Optional:
-- `grant_type` => 'social'
-- `scope` => '*'

Endpoint: `POST /api/login/{provider}`

Params:
-- `client_id`
-- `client_secret`
-- `access_token` => Token returned by OAuth Social login provider
-- `grant_type` => 'social'
-- `scope` => '*'
-- `roles[]`

Optional:
-- `provider` => Provider

### Forgot password
Send password reset link

Endpoint: `POST /api/password/reset`

Params:
-- `email`

### Logout
Revokes the token

Endpoint: `POST /api/logout`

### Sign up as a Provider


# OAuth

URL: `/developer`
OAuth Clients > Create New Client

## Token Flow

Endpoint: `POST oauth/token`

`grant_type` > `authorization_code`

`client_id` > client ID

`code` > authorization code

`code_verifier` > original code_verifier string

## Authorization Flow

code_verifier ~ 43 - 128 char random string

Endpoint: `GET /oauth/authorize?client_id=&response_type=code&state=&code_challenge=&code_challenge_method=S265`

`client_id` > client ID

`code_challenge` > Base64URL(SHA256(code_verifier))

`response_type` > `code`

