# Papers

Papers is a project created as a documentation for authentication with Laravel.

## Requirements for development environment

- PHP >= 8.3
- Composer >= 2.2.0
- SQLite 3
- Node.js >= 20.x
- [Mailpit](https://github.com/axllent/mailpit)

## Install on local

```
cd path/to/somewhere
git clone https://github.com/jamband/papers.git
cd papers
composer run dev
```

## Start the development server

```
php artisan serve
npm run dev
mailpit
```

## Actions

General user:

- User register
- Email verification notification
- User login
- User logout
- Forgot password
- Reset password
- Confirm password
- Delete account

Admin user:

- Admin user login
- Admin user logout
- Delete user

## Testing

Unit tests and feature tests:

```
php artisan test
```

Browser tests:

```
php artisan serve
mailpit
php artisan dusk:chrome-driver
php artisan dusk
```

## License

Papers is licensed under the MIT license.
