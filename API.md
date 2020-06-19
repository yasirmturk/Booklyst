# API Documentation

## User management

APIs for register, login etc

### Register
Creates a new user in the system and return user object. `email_verified_at` is null if email is not verified. Also returns the token if `grant_type` is set.
Endpoint: `/api/register`
Params: 
-- `client_id`
-- `client_secret`
-- `name`
-- `email`
-- `password`
-- `password_confirmation`
Optional:
-- `grant_type`
-- `scope`

### Login
Authenticate the user and returns token along with user object.
Endpoint: `/api/login`
Params: 
-- `client_id`
-- `client_secret`
-- `grant_type`
-- `scope`
-- `username`
-- `password`

### Logout
Revokes the token
Endpoint: `/api/logout`

### Forgot password

### Sign up as a Provider

# OAuth
<SERVER_URL>/developer
OAuth Clients > Create New Client

## Token Flow

POST <SERVER_URL>/oauth/token
`grant_type` > `authorization_code`
`client_id` > client ID
`code` > authorization code
`code_verifier` > original code_verifier string

## Authorization Flow

code_verifier ~ 43 - 128 char random string

`client_id` > client ID
`code_challenge` > Base64URL(SHA256(code_verifier))
`response_type` > `code`

GET <SERVER_URL>/oauth/authorize?client_id=&response_type=code&state=&code_challenge=&code_challenge_method=S265

