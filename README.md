# Papers

Papers is a project created as a documentation for authentication with Laravel.

## Requirements for development environment

- PHP >= 7.4
- Composer 2.x
- Laravel 8.x
- SQLite 3
- Node.js >= 12.14.0
- [MailHog](https://github.com/mailhog/MailHog)

## Install on local

```
cd path/to/somewhere
git clone https://github.com/jamband/papers.git
cd papers
composer run dev
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
MailHog
php artisan dusk
```

## License

Papers is licensed under the MIT license.
