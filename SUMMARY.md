

## User menagnment

For a Laravel API, I usually separate user self-management from user administration.

Think of it as two different resources:
    - 'me' user endpoints (for self menagnment)
    - User Resource Endpoints -> reserved for editing User Resource as User of X roles eg. admin, trainer
        These should rely on UserPolicy class for user menagnment.

## API Authentication (Bearer Tokens)

APIs often don't use cookies.

Instead:

POST /auth/login

Laravel verifies credentials and returns:

{
    "token": "eyJhbGciOi..."
}

Client stores the token.

Then every request contains:

GET /me

Authorization: Bearer eyJhbGciOi...

The word Bearer literally means:

Whoever bears (possesses) this token may present it.

Laravel receives:

Authorization: Bearer eyJhbGciOi...

and checks:

Does this token exist?
Is it expired?
Was it revoked?
Which user owns it?

If valid:

$request->user()

returns the authenticated user.