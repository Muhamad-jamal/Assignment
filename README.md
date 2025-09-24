# HR Management API (Laravel)

## Project Overview

This project is a Laravel-based HR Management API. It supports:

- **Employee management (CRUD)**
- **Position management**
- **Salary tracking & notifications**
- **Employee hierarchy**
- **Export/import via CSV**
- **Rate-limited API**
- **Authentication with Sanctum**

## Requirements

- **PHP 8.2+**
- **Composer**
- **MySQL / MariaDB / PostgreSQL**
- **Node.js & NPM** (for front-end or broadcasting channels, if needed)

## Installation

1. **Clone the repository**
    ```bash
    git clone https://github.com/Muhamad-jamal/Assignment.git
    cd Assignment
    ```

2. **Install dependencies**
    ```bash
    composer install
    ```

3. **Copy environment file**
    ```bash
    cp .env.example .env
    ```

4. **Configure environment**

    Edit `.env` file with your database credentials:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=hr_management
    DB_USERNAME=root
    DB_PASSWORD=secret
    ```

5. **Generate app key**
    ```bash
    php artisan key:generate
    ```

6. **Run migrations & seed database**
    ```bash
    php artisan migrate --seed
    ```
    This will:
    - Create tables (`users`, `employees`, `positions`, `salary_histories`, `logs`)
    - Populate positions, employees, and users with fake data

7. **Run the application**
    ```bash
    php artisan serve
    ```
    Default URL: [http://127.0.0.1:8000](http://127.0.0.1:8000)

## Authentication

- Login via `/api/auth/login` (`POST`) with user credentials
- Use Sanctum token for authenticated requests

**Example Admin User (seeded by default):**
```
Email: admin@example.com
Password: password
```

## API Rate Limiting

All API endpoints are limited to **10 requests per minute**

## API Endpoints (examples)

- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`
- `GET /api/v1/employees/without-recent-salary-change?months=3`
- `GET /api/v1/employees/export/csv`
- `POST /api/v1/employees/import/csv`
- `GET /api/v1/employees/{id}/hierarchy/names`
- `GET /api/v1/employees/{id}/hierarchy/names-salaries`

## Optional Commands

Insert fake employees with progress bar:
```bash
php artisan employees:insert {count}
# Example:
php artisan employees:insert 20
```

## Broadcasting & Notifications

Salary changes trigger emails to the employee and managers up to the founder.

Laravel queue should be running for email delivery:
```bash
php artisan queue:work
```

## Testing

Run tests:
```bash
php artisan test
```

## License

MIT
