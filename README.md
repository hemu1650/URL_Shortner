# URL_Shortner

A Laravel-based URL Shortening System with role-based access for SuperAdmin, Admin, and Member users. Each company can manage its own users and generate short URLs. The application supports public redirection via short links and includes full authentication and role-based authorization.

# Requirements
Laravel 12

PHP >= 8.1

MySQL or SQLite (default: MySQL)

Composer

Node.js & NPM (for frontend scaffolding, if needed)

Laravel Breeze (for auth scaffolding)

# 🔗 Laravel URL Shortener (SuperAdmin, Admin, Member)

This project is a role-based **URL Shortening system** built in Laravel 12 with the following user roles:
- **Super Admin**
- **Admin (Client)**
- **Member**

---

## 📁 Folder Structure & Key Files

- `routes/web.php` → All routes grouped for SuperAdmin, Admin, and Members.
- `app/Models/User.php` → Handles roles and relationships.
- `app/Http/Controllers` → Controller logic for each role.
- `resources/views` → Blade templates per role.
- `database/migrations` → User, Company, ShortUrl tables.

---

## 🧑‍💻 User Roles & Permissions

| Role         | Access Level                                                                 |
|--------------|------------------------------------------------------------------------------|
| Super Admin  | View all Admins & Members, view all short URLs, export CSVs                 |
| Admin        | Invite Members, create/view short URLs within their company                 |
| Member       | Can only create and manage their own short URLs                             |

---

## 🛠️ Installation & Setup



### 1. Clone the Repository

```bash
git clone https://github.com/your-username/url-shortener.git
cd url-shortener

### 2. Install PHP Dependencies

composer install

### 3. Copy .env File and Generate App Key
cp .env.example .env
php artisan key:generate

### 4. Configure Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

### 5. Run Migrations & Seed Default SuperAdmin
php artisan migrate --seed

### 6. Install Frontend Dependencies

npm install
npm run dev

### 7. Serve the Application

php artisan serve

### Default SuperAdmin Credentials
Email: superadmin@example.com
Password: password
