<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development/)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contact Form Database Storage

The application includes a database migration for storing contact form submissions. This functionality allows you to:

1. Permanently store all contact submissions in the database
2. Track metadata like IP address and user agent
3. Mark messages as read/unread
4. Generate test data using factories and seeders

### Database Setup

To set up the contacts database:

```bash
# Run migrations
php artisan migrate

# Optional: Seed with test data
php artisan db:seed --class=ContactSeeder
```

### Database Schema

The `contacts` table has the following structure:

| Column       | Type      | Description                           |
|--------------|-----------|---------------------------------------|
| id           | bigint    | Primary key                           |
| name         | string    | Sender's name                         |
| email        | string    | Sender's email address                |
| subject      | string    | Message subject                       |
| message      | text      | Message content                       |
| ip_address   | string    | Sender's IP address (nullable)        |
| user_agent   | string    | Sender's browser info (nullable)      |
| is_read      | boolean   | Whether message has been read         |
| created_at   | timestamp | Creation timestamp                    |
| updated_at   | timestamp | Last update timestamp                 |

### Usage Examples

```php
// Get all contacts
$contacts = App\Models\Contact::all();

// Get only unread contacts
$unreadContacts = App\Models\Contact::unread()->get();

// Mark a contact as read
$contact = App\Models\Contact::find(1);
$contact->markAsRead();

// Count unread messages
$count = App\Models\Contact::unread()->count();
```

## Testing

Comprehensive tests are included for the contact form API and database functionality:

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test files
php artisan test --filter=ContactApiTest
php artisan test --filter=ContactModelTest
php artisan test --filter=ContactEmailTest
php artisan test --filter=ContactFactoryTest
```

### Test Coverage

The tests cover:

1. **API Functionality**
   - Successful form submission
   - Validation errors
   - Error handling
   - Metadata capture (IP address, User Agent)
   - Response format

2. **Model Behavior**
   - Fillable attributes
   - Data casting (boolean, datetime)
   - Query scopes (unread)
   - Helper methods (markAsRead)

3. **Email Notifications**
   - Email sending verification
   - Email content verification
   - Preventing emails on validation failure

4. **Data Generation**
   - Factory functionality
   - State modifiers (read/unread)
   - Seeder reliability

### Test Cases

The test suite includes 14 test cases distributed across 4 test files:

- `ContactApiTest.php`: Tests the API endpoints
- `ContactModelTest.php`: Tests the Contact model
- `ContactEmailTest.php`: Tests email notifications
- `ContactFactoryTest.php`: Tests factories and seeders
