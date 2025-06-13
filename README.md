# URL_Shortner
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
