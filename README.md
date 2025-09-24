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

4. **Import Database**
   - Import the provided SQL dump using phpMyAdmin or MySQL CLI:
     ```bash
     mysql -u root -p assignment < assignment.sql
     ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations and Seeders** (if you want to reset and seed with fresh fake data)
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Start the Development Server**
   ```bash
   php artisan serve
   ```

---

## Assignment Feature Mapping

- **Authentication:** Laravel Sanctum, `/api/v1/auth/*` endpoints.
- **Employee Management:** CRUD, hierarchy, salary change notifications, search, import/export, recently changed salaries.
- **Positions:** CRUD for positions.
- **Logging:** All operations in DB and `storage/logs/employee.log`.
- **Artisan Commands:** For logs, export, fake data insertion, JSON export (see `app/Console/Commands/`).
- **Rate Limiting:** 10 req/min (via middleware).
- **API Versioning:** All endpoints under `/api/v1/`.
- **Testing:** TDD for all endpoints, run with `php artisan test`.
- **Data & Collections:** Use `assignment.sql` and `Assignment.postman_collection.json`.
- **Other Notes:** Uses Eloquent ORM, avoids N+1 queries, seeded with fake data, default admin `admin@example.com`/`password`.

---

## License

MIT
