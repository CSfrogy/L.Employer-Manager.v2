# Employee Task Management System - Project Report

## 📋 Project Overview

**Project Name:** Employee Task Management System  
**Repository:** project-1-employee-task-management-system  
**Owner:** CSfrogy  
**Current Branch:** master  
**Framework:** Laravel 9.19+  
**PHP Version:** 8.0.2+  

This is a comprehensive **web-based employee task management system** built with Laravel. It enables administrators to manage employees and assign tasks, while providing employees with a dedicated dashboard to track, update, and manage their assigned tasks with built-in messaging functionality.

---

## 🎯 Key Features

### 1. **Multi-Role Authentication System**
- **Admin Portal:** Secure login for administrators
- **Employee Portal:** Separate authentication for employees
- Role-based access control using Laravel Sanctum and custom guards
- Password-protected accounts with hashing

### 2. **Employee Management**
- CRUD operations for employee records
- Employee profile management with image upload
- Employee information includes:
  - Name, Email, Phone
  - Date of Birth, City
  - Profile Image
  - Department Assignment
- Dashboard with employee overview
- Bulk delete operations

### 3. **Task Management**
- Create, read, update, and delete tasks
- Assign tasks to specific employees
- Task details include:
  - Title, Content/Description
  - Due Date
  - Status (Active/Inactive)
  - Assignment tracking
- Task filtering by status (Active/Inactive)
- Employee task dashboard showing assigned tasks
- Task status updates
- Progress tracking
- Extension request functionality

### 4. **Admin Features**
- **Admin Dashboard:** Overview of system metrics
- **Employee Management:** Full CRUD for employees
- **Task Management:** Create and assign tasks to employees
- **Admin Management:** Create additional admin accounts
- **Mailbox:** Message management with admin replies
- Mark messages as read/unread
- Message reply functionality

### 5. **Employee Features**
- **Employee Dashboard:** Overview of personal tasks
- **Task Management:** View assigned tasks with detailed information
- **Task Actions:**
  - Mark tasks as complete/incomplete
  - Update progress percentage
  - Request deadline extensions
- **Profile Management:**
  - Update personal information
  - Change password
  - Upload/change profile image
- **Messaging System:**
  - Create new messages to admin
  - View message history
  - Receive replies from admin
  - Delete personal messages

### 6. **Communication System**
- **Messages & Replies:** Two-way communication between employees and admins
- **Message Tracking:** Read/unread status
- **Message History:** Complete conversation threads

### 7. **Department Management**
- Create and manage departments
- Link employees to departments

---

## 🏗️ Project Architecture

### Technology Stack

**Backend:**
- Laravel Framework 9.19+
- PHP 8.0.2+
- Eloquent ORM
- Laravel Sanctum (API Authentication)

**Frontend:**
- Blade Templating Engine
- Vite 7.1.12+ (Build Tool)
- CSS/JavaScript with Tailwind CSS
- Livewire 2.12 (Interactive Components)
- Axios (HTTP Requests)

**Database:**
- MySQL/MariaDB (configured in `database.php`)
- Laravel Migrations
- Database Seeders and Factories

**Development Tools:**
- Laravel Sail (Docker support)
- PHPUnit (Testing Framework)
- Laravel Pint (Code Standards)
- Faker (Data Generation)

---

## 📁 Project Structure

```
project-1-employee-task-management-system/
├── app/
│   ├── Console/              # Artisan commands
│   ├── Exceptions/           # Exception handling
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/        # Admin controllers
│   │   │   ├── Employee/     # Employee controllers
│   │   │   └── LandingController.php
│   │   ├── Kernel.php        # Middleware configuration
│   │   └── Middleware/       # Custom middleware
│   ├── Models/               # Eloquent models
│   │   ├── Admin.php
│   │   ├── Employee.php
│   │   ├── Task.php
│   │   ├── Department.php
│   │   ├── Message.php
│   │   ├── MessageReply.php
│   │   └── User.php
│   └── Providers/            # Service providers
├── bootstrap/                # Bootstrap configuration
├── config/                   # Configuration files
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── [other configs]
├── database/
│   ├── factories/            # Model factories
│   │   ├── AdminFactory.php
│   │   ├── EmployeeFactory.php
│   │   ├── TaskFactory.php
│   │   └── UserFactory.php
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── resources/
│   ├── views/
│   │   ├── admin/            # Admin templates
│   │   ├── employee/         # Employee templates
│   │   ├── layouts/          # Layout components
│   │   ├── landing.blade.php # Landing page
│   │   └── welcome.blade.php # Welcome page
│   ├── css/                  # Stylesheets
│   └── js/                   # JavaScript files
├── routes/
│   ├── web.php               # Web routes
│   ├── api.php               # API routes
│   └── [other route configs]
├── storage/                  # File storage
├── tests/                    # Unit & feature tests
├── public/                   # Web root
│   ├── css/                  # Compiled CSS
│   ├── assets/               # Static assets
│   └── index.php             # Entry point
├── composer.json             # PHP dependencies
├── package.json              # JavaScript dependencies
├── vite.config.js            # Vite configuration
├── phpunit.xml               # Test configuration
└── artisan                   # Artisan CLI

```

---

## 🗄️ Database Schema

### Core Tables

**Users Table**
- id (Primary Key)
- name (string)
- email (unique)
- password (hashed)
- email_verified_at (nullable timestamp)
- remember_token
- timestamps

**Admins Table**
- id (Primary Key)
- name (string)
- email (unique)
- phone (string)
- password (hashed)
- remember_token
- timestamps

**Employees Table**
- id (Primary Key)
- name (string)
- email (unique)
- password (hashed)
- phone (string)
- dob (date - Date of Birth)
- city (string)
- image (nullable - profile image)
- remember_token
- timestamps

**Tasks Table**
- id (Primary Key)
- emp_id (Foreign Key → Employees)
- title (string)
- content (text - task description)
- date (date - due date)
- status (integer: 1=active, 0=inactive)
- timestamps

**Departments Table**
- id (Primary Key)
- name (string)
- timestamps

**Messages Table**
- id (Primary Key)
- employee_id (Foreign Key → Employees)
- subject (string)
- message (text)
- read_at (nullable timestamp)
- timestamps

**MessageReplies Table**
- id (Primary Key)
- message_id (Foreign Key → Messages)
- admin_id (Foreign Key → Admins)
- reply_text (text)
- timestamps

---

## 🔐 Authentication & Authorization

### Authentication Guards
- **Admin Guard:** Custom guard for admin authentication
- **Employee Guard:** Custom guard for employee authentication
- **Sanctum:** API token authentication support

### Middleware Protection
- `auth:admin` - Protects admin routes
- `auth:employee` - Protects employee routes
- `guest:admin` - Allows only non-authenticated admins
- `guest:employee` - Allows only non-authenticated employees

### Route Groups
```
/admin/*              - Admin authenticated routes
/employee/*           - Employee authenticated routes
/employee/login       - Employee login page
/admin/login          - Admin login page
/                     - Landing page (public)
```

---

## 📡 API & Route Structure

### Admin Routes
```
POST   /admin/login/post                    - Admin login
GET    /admin/dashboard                     - Admin dashboard
GET    /admin/employee/list                 - List employees
GET    /admin/employee/add                  - Add employee form
POST   /admin/employee/crate                - Create employee
POST   /admin/employee/delete               - Delete employee
GET    /admin/employee/edit/{id}            - Edit employee form
POST   /admin/employee/update               - Update employee

GET    /admin/tasks/list                    - List tasks
GET    /admin/tasks/add                     - Add task form
POST   /admin/tasks/create                  - Create task
POST   /admin/tasks/delete                  - Delete task
GET    /admin/tasks/edit/{id}               - Edit task form
POST   /admin/tasks/update                  - Update task

GET    /admin/admin/list                    - List admins
GET    /admin/admin/add                     - Add admin form
POST   /admin/admin/store                   - Store admin
POST   /admin/admin/delete                  - Delete admin
GET    /admin/admin/edit/{id}               - Edit admin form
POST   /admin/admin/update                  - Update admin

GET    /admin/mailbox/                      - Mailbox inbox
GET    /admin/mailbox/{message}             - View message
POST   /admin/mailbox/{message}/reply       - Reply to message
POST   /admin/mailbox/{message}/mark-read   - Mark as read
DELETE /admin/mailbox/{message}             - Delete message

POST   /admin/logout                        - Logout
```

### Employee Routes
```
GET    /employee/login                      - Employee login page
POST   /employee/login/post                 - Employee login

GET    /employee/dashboard                  - Employee dashboard
POST   /employee/logout                     - Logout

GET    /employee/tasks/                     - List employee tasks
GET    /employee/tasks/{id}                 - View task details
POST   /employee/tasks/{id}/status          - Update task status
POST   /employee/tasks/{id}/progress        - Update progress
POST   /employee/tasks/{id}/extension       - Request extension

GET    /employee/profile/                   - View profile
POST   /employee/profile/update             - Update profile
POST   /employee/profile/update-password    - Change password
POST   /employee/profile/upload-image       - Upload profile image

GET    /employee/messages/                  - View messages
GET    /employee/messages/create            - Create message form
POST   /employee/messages/                  - Send message
GET    /employee/messages/{message}         - View message
POST   /employee/messages/{message}/reply   - Reply to message
DELETE /employee/messages/{message}         - Delete message
```

### Public Routes
```
GET    /                                    - Landing page
```

---

## 💾 Models & Relationships

### User Model
- Extends Authenticatable
- Uses: HasApiTokens, HasFactory, Notifiable
- Attributes: name, email, password
- Hidden: password, remember_token

### Admin Model
- Extends Authenticatable
- Uses: HasApiTokens, HasFactory, Notifiable
- Attributes: name, email, phone, password
- Guard: admin
- Hidden: password, remember_token

### Employee Model
- Extends Authenticatable
- Uses: HasFactory, Notifiable
- Attributes: name, email, phone, dob, city, image, password
- Guard: employee
- **Relationships:**
  - `tasks()` → Has Many Tasks (emp_id)
- Hidden: password, remember_token

### Task Model
- Attributes: emp_id, title, content, date, status
- Scopes: active(), inactive()
- Accessors: getStatusTextAttribute()
- **Relationships:**
  - `employee()` → Belongs To Employee (emp_id)
- Timestamps enabled

### Department Model
- Attributes: name
- Table: departments
- Timestamps enabled

### Message Model
- Attributes: employee_id, subject, message, read_at
- Casts: read_at as datetime
- **Relationships:**
  - `employee()` → Belongs To Employee
  - `replies()` → Has Many MessageReplies
- Scopes: unread()
- Methods: isRead(), markAsRead()
- Timestamps enabled

### MessageReply Model
- Relationships: Belongs To Message and Admin
- Timestamps enabled

---

## 🛠️ Key Features Implementation

### Task Status Management
- Tasks have binary status: 1 (active) or 0 (inactive)
- Scopable queries: `Task::active()` and `Task::inactive()`
- Human-readable status text: "active" or "inactive"

### Message System
- Messages track read/unread status with `read_at` timestamp
- Unread scope for filtering: `Message::unread()`
- Reply threading with MessageReply model
- Ordered replies: latest first

### Employee Profiles
- Profile image upload capability
- Password hashing (stored securely)
- Phone and location information
- Date of birth tracking

### Admin Controls
- Create multiple admin accounts
- Manage employee records
- Manage task assignments
- View and reply to employee messages
- Mark messages as read/unread

---

## 📊 Database Migrations

The project includes migrations for:
- Users table (2014_10_12_000000)
- Password resets (2014_10_12_100000)
- Failed jobs (2019_08_19_000000)
- Personal access tokens (2019_12_14_000001)
- Admins table (2023_02_11_061806)
- Employees table (2023_02_11_063220)
- Tasks table (2023_02_27_064334)
- Departments table (2023_03_05_184824)
- Employee/task fields extensions (2025_11_16_085158)

---

## 🧪 Testing & Quality

**Testing Framework:** PHPUnit 9.5.10+
- Feature tests in `tests/Feature/`
- Unit tests in `tests/Unit/`
- Test case base class: `tests/TestCase.php`
- Database seeding for test data

**Code Quality:**
- Laravel Pint for code standards
- PHPStan for static analysis (via Spatie Laravel Ignition)
- PSR-4 autoloading for clean architecture

**Development Tools:**
- Laravel Tinker for interactive shell
- Faker for test data generation
- Mockery for mocking

---

## 📦 Dependencies

### Core Dependencies
- `laravel/framework` (^9.19)
- `laravel/sanctum` (^3.0) - API authentication
- `livewire/livewire` (^2.12) - Interactive components
- `guzzlehttp/guzzle` (^7.2) - HTTP client
- `laravel/tinker` (^2.7) - REPL

### Development Dependencies
- `phpunit/phpunit` (^9.5.10) - Testing
- `laravel/pint` (^1.0) - Code formatting
- `laravel/sail` (^1.0.1) - Docker support
- `fakerphp/faker` (^1.9.1) - Fake data
- `mockery/mockery` (^1.4.4) - Mocking
- `spatie/laravel-ignition` (^1.0) - Error reporting

### Frontend Dependencies
- `vite` (^7.1.12) - Build tool
- `laravel-vite-plugin` (^2.0.1) - Laravel integration
- `axios` (^1.1.2) - HTTP client
- `lodash` (^4.17.19) - Utility library
- `postcss` (^8.1.14) - CSS processing

---

## 🚀 Getting Started

### Installation Steps

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd project-1-employee-task-management-system
   ```

2. **Install Dependencies**
   ```bash
   # PHP dependencies
   composer install
   
   # JavaScript dependencies
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   # Configure database in .env file
   php artisan migrate
   
   # Optional: Seed sample data
   php artisan db:seed
   ```

5. **Build Frontend Assets**
   ```bash
   npm run build      # Production build
   npm run dev        # Development build with watch mode
   ```

6. **Start Development Server**
   ```bash
   php artisan serve
   # Application will be available at http://localhost:8000
   ```

### Running Tests
```bash
php artisan test          # Run all tests
php artisan test --file=tests/Feature/ExampleTest.php  # Specific test
```

---

## 📋 File Structure Summary

| Directory | Purpose |
|-----------|---------|
| `app/` | Application code (models, controllers, middleware) |
| `config/` | Application configuration files |
| `database/` | Migrations, seeders, factories |
| `resources/` | Views, CSS, JavaScript assets |
| `routes/` | Route definitions (web, API, etc.) |
| `storage/` | Generated files, logs, cache |
| `tests/` | Unit and feature tests |
| `public/` | Web-accessible files |
| `vendor/` | Composer dependencies |

---

## 🔒 Security Features

- ✅ Password hashing with Laravel Hash facade
- ✅ CSRF protection on forms
- ✅ Secure authentication guards (admin/employee)
- ✅ Sanctum token authentication for API
- ✅ User input validation
- ✅ Protected file uploads
- ✅ Database prepared statements (Eloquent ORM)

---

## 📝 Additional Notes

### Naming Convention Note
- Route `POST /admin/employee/crate` appears to be a typo (should likely be `create`)

### Strengths
1. Clean, modular architecture with separation of concerns
2. Role-based access control with multiple user types
3. Complete CRUD operations for all entities
4. Two-way messaging system
5. Profile management with image uploads
6. Comprehensive routing structure
7. Modern tech stack (Laravel 9, Vite, Livewire)

### Potential Improvements
1. Fix naming typo in employee creation route
2. Add API endpoints for mobile app integration
3. Implement task templates for recurring tasks
4. Add task priority levels
5. Implement task statistics/reports
6. Add email notifications
7. Implement task history/audit logs
8. Add pagination for large task lists
9. Add task filtering by date range
10. Implement task comments/notes

---

## 📅 Project Information

- **Created:** February 2023 onwards
- **Last Updated:** November 16, 2025
- **Framework Version:** Laravel 9.19+
- **PHP Requirement:** 8.0.2+
- **License:** MIT

---

**Generated:** December 3, 2025  
**Status:** Active Development
