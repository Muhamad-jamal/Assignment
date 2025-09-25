# HR Management API (Laravel)

## Overview

This project is a Laravel-based backend API for HR management. It implements employee and position management, authentication, notifications, hierarchical queries, logging, data import/export, rate limiting, and more, strictly following the assignment requirements.

---

## Installation Requirements

- **PHP:** ^8.2
- **Composer:** Latest version recommended
- **Database:** MariaDB/MySQL (recommended), other Laravel-supported DBs possible
- **Node.js & npm:** For broadcasting/queues (if needed)
- **Required Composer Packages:**
  - `laravel/framework` ^12.0
  - `laravel/sanctum` ^4.0
  - `laravel/tinker`
  - `ifsnop/mysqldump-php`
  - See `composer.json` for full list

---

## Installation & Configuration

1. **Clone the Repository**
   ```bash
   git clone https://github.com/Muhamad-jamal/Assignment.git
   cd Assignment
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Environment Setup**
   - Copy the example environment file and configure your DB credentials:
     ```bash
     cp .env.example .env
     ```
   - Edit `.env` for your database settings:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=assignment
     DB_USERNAME=root
     DB_PASSWORD=your_password
     ```
   - **Email Setup:**  
     Configure the following mail settings in your `.env` file to enable email notifications (salary change, manager notification, etc.):
     ```
     MAIL_MAILER=smtp
     MAIL_HOST=smtp.mailtrap.io
     MAIL_PORT=2525
     MAIL_USERNAME=your_mailtrap_username
     MAIL_PASSWORD=your_mailtrap_password
     MAIL_ENCRYPTION=null
     MAIL_FROM_ADDRESS=hr@example.com
     MAIL_FROM_NAME="HR Management"
     ```
     *(You may use [Mailtrap](https://mailtrap.io/) or any SMTP provider for testing.)*

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```


6. **Run Migrations and Seeders**
    ```bash
    php artisan migrate --seed
    ```

    This will automatically:
    - Create an admin user:
       - **Email:** admin@example.com
       - **Password:** password
    - Use factories to create:
       - 5 positions
       - 5 employees

    You can customize the seed data in `database/seeders` and factories in `database/factories`.

6. **Start the Development Server**
   ```bash
   php artisan serve
   ```

7. **Run the Queue Worker**
   To process email and broadcast notifications, start the queue worker in a separate terminal:
   ```bash
   php artisan queue:work
   ```
   *(This is required for notifications to be sent and broadcasted.)*

---
## API Endpoint Explanations

## Postman Collection

A Postman collection is provided in the project root as `Assignment.postman_collection.json`.

**Instructions for Reviewers:**
- Import `Assignment.postman_collection.json` into Postman.
- Use the pre-configured requests to test all API endpoints quickly.
- Update environment variables in Postman as needed (e.g., base URL, authentication token).
- Refer to the API Endpoint Explanations below for details on each endpoint.
### Authentication

- `POST /api/v1/auth/register` – Register new user
- `POST /api/v1/auth/login` – Login, receive token
- `POST /api/v1/auth/logout` – Logout, invalidate token

### Employees

- `GET /api/v1/employees` – List all employees
- `GET /api/v1/employees/search?name=alice&salary=5000` – Search employees
- `GET /api/v1/employees/without-recent-salary-change?months=12` – Employees without salary change
- `POST /api/v1/employees` – Create new employee
- `GET /api/v1/employees/{id}` – Show employee details
- `PATCH /api/v1/employees/{id}` – Update employee info/salary
- `DELETE /api/v1/employees/{id}` – Delete employee
- `GET /api/v1/employees/{id}/hierarchy/names` – Get hierarchy names
- `GET /api/v1/employees/{id}/hierarchy/names-salaries` – Get hierarchy names and salaries
- `GET /api/v1/employees/export/csv` – Export employees as CSV
- `POST /api/v1/employees/import/csv` – Import employees from CSV

### Positions

- `GET /api/v1/positions` – List all positions
- `GET /api/v1/positions/{id}` – Show position details
- `POST /api/v1/positions` – Create position
- `PATCH /api/v1/positions/{id}` – Update position
- `DELETE /api/v1/positions/{id}` – Delete position

### Utility & Artisan Commands

- `php artisan logs:prune` – Delete old logs (>1 month)
- `php artisan logs:clear-files` – Remove log files
- `php artisan employees:insert {count}` – Add fake employees
- `php artisan db:export` – Export DB as SQL
- `php artisan employees:export-json` – Export employees to JSON

### Other Features

- **Notifications**: Email and broadcast on salary change, manager notification on creation.
- **Logging**: All actions logged in DB and file.
- **Rate Limiting**: 10 requests/min per user.
- **Eloquent ORM**: No raw SQL, eager loading for performance.

---

## License

MIT
