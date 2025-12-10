<div align="center">
  <h1>Employee Task Management System</h1>
  <p>A comprehensive web-based task management and employee management system built with Laravel</p>
  
  [![Laravel](https://img.shields.io/badge/Laravel-9.19+-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
  [![PHP](https://img.shields.io/badge/PHP-8.0.2+-777BB4?style=flat-square&logo=php)](https://php.net)
  [![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)
  
</div>

<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#key-features">Key Features</a></li>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>

---

## About The Project

The **Employee Task Management System** is a robust, full-featured web application designed to streamline employee and task management operations. Built with modern web technologies, it provides administrators with comprehensive tools to manage employees and assign tasks, while giving employees a dedicated interface to track, update, and manage their assigned work.

### Key Features

- **Multi-Role Authentication System** - Separate secure login portals for admins and employees with role-based access control
- **Employee Management** - Complete CRUD operations for employee records with profile management and image uploads
- **Task Management** - Create, assign, and track tasks with status updates, progress tracking, and deadline extensions
- **Admin Dashboard** - Comprehensive overview of employees, tasks, and system metrics
- **Employee Dashboard** - Personal task tracking with status updates and progress reporting
- **Messaging System** - Two-way communication between employees and administrators with message threading
- **Department Management** - Organize employees into departments
- **Profile Management** - Employees can update personal information, change passwords, and upload profile images
- **Security Features** - Password hashing, CSRF protection, secure authentication, and input validation

<p align="right">(<a href="#top">back to top</a>)</p>

### Built With

This project is built using modern, industry-standard technologies:

- **[Laravel](https://laravel.com)** - PHP web application framework (v9.19+)
- **[PHP](https://www.php.net)** - Server-side language (v8.0.2+)
- **[MySQL](https://www.mysql.com)** - Relational database
- **[Livewire](https://livewire.laravel.com)** - Interactive Laravel components
- **[Vite](https://vitejs.dev)** - Modern frontend build tool
- **[Tailwind CSS](https://tailwindcss.com)** - Utility-first CSS framework
- **[Axios](https://axios-http.com)** - Promise-based HTTP client
- **[Laravel Sanctum](https://laravel.com/docs/sanctum)** - API token authentication
- **[Bootstrap](https://getbootstrap.com)** - Responsive design framework

<p align="right">(<a href="#top">back to top</a>)</p>

---

## Getting Started

This section provides instructions on setting up the project locally. Follow these steps to get a copy of the project running on your machine.

### Prerequisites

Before you begin, ensure you have the following installed on your system:

- **PHP** (v8.0.2 or higher)
  ```bash
  # Check PHP version
  php --version
  ```

- **Composer** - PHP package manager
  ```bash
  # Download and install from https://getcomposer.org/
  # Verify installation
  composer --version
  ```

- **Node.js & npm** - JavaScript runtime and package manager
  ```bash
  # Download and install from https://nodejs.org/
  # Verify installation
  node --version
  npm --version
  ```

- **MySQL Server** (v5.7 or higher) or **MariaDB**
  ```bash
  # Verify MySQL installation
  mysql --version
  ```

- **Git** - Version control system
  ```bash
  git --version
  ```

### Installation

Follow these steps to get the project up and running:

1. **Clone the repository**
   ```bash
   git clone https://github.com/CSfrogy/project-1-employee-task-management-system.git
   cd project-1-employee-task-management-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Copy environment configuration**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Configure your database**
   
   Edit the `.env` file and set your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=employee_task_system
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

7. **Run database migrations**
   ```bash
   php artisan migrate
   ```

8. **Seed the database (optional)**
   ```bash
   php artisan db:seed
   ```

9. **Build frontend assets**
   ```bash
   # For development with hot reload
   npm run dev
   
   # For production build
   npm run build
   ```

10. **Start the development server**
    ```bash
    php artisan serve
    ```
    
    The application will be available at: **http://localhost:8000**

<p align="right">(<a href="#top">back to top</a>)</p>

---

## Usage

### For Administrators

1. **Login** - Navigate to `/admin/login` and enter your admin credentials
2. **Dashboard** - View overview of employees and tasks
3. **Manage Employees** - Add, edit, or delete employee records
4. **Create Tasks** - Assign tasks to employees with deadlines
5. **View Messages** - Check and reply to employee messages
6. **Manage Admins** - Create additional admin accounts

### For Employees

1. **Login** - Navigate to `/employee/login` and enter your credentials
2. **View Tasks** - Check all assigned tasks on your dashboard
3. **Update Tasks** - Mark tasks as complete or update progress
4. **Request Extensions** - Request deadline extensions for tasks
5. **Manage Profile** - Update personal information and password
6. **Send Messages** - Contact administrators through the messaging system

### Example Workflows

**Task Assignment by Admin:**
- Admin logs in → Navigate to Tasks → Create New Task → Select Employee → Set Deadline → Save

**Task Completion by Employee:**
- Employee logs in → View Tasks → Click Task → Update Progress → Change Status to Complete → Save

For more detailed information, see the [PROJECT_REPORT.md](PROJECT_REPORT.md) file which contains comprehensive documentation about the project structure, database schema, and API routes.

<p align="right">(<a href="#top">back to top</a>)</p>

---

## Roadmap

- [x] Multi-role authentication system
- [x] Employee CRUD operations
- [x] Task management and tracking
- [x] Admin messaging system
- [x] Profile management
- [x] Department management
- [ ] Task priority levels
- [ ] Task templates for recurring tasks
- [ ] Task statistics and reporting
- [ ] Email notifications
- [ ] Task history and audit logs
- [ ] Mobile app support (API integration)
- [ ] Advanced task filtering and search
- [ ] Task comments and notes
- [ ] Team collaboration features

See the [open issues](https://github.com/CSfrogy/project-1-employee-task-management-system/issues) for a full list of proposed features and known issues.

<p align="right">(<a href="#top">back to top</a>)</p>

---

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**!

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".

### Steps to contribute:

1. **Fork the Project**
   ```bash
   # Click the Fork button on GitHub
   ```

2. **Create your Feature Branch**
   ```bash
   git checkout -b feature/AmazingFeature
   ```

3. **Commit your Changes**
   ```bash
   git commit -m 'Add some AmazingFeature'
   ```

4. **Push to the Branch**
   ```bash
   git push origin feature/AmazingFeature
   ```

5. **Open a Pull Request**
   - Click "Compare & pull request" on GitHub
   - Describe your changes
   - Submit the PR

Don't forget to give the project a star! Thanks again!

<p align="right">(<a href="#top">back to top</a>)</p>

---

## License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

The MIT License allows you to:
- ✅ Use the software for any purpose
- ✅ Copy and distribute the software
- ✅ Modify the software

As long as you include the original copyright and license notice.

<p align="right">(<a href="#top">back to top</a>)</p>

---

## Contact

**Project Owner:** CSfrogy

- GitHub: [@CSfrogy](https://github.com/CSfrogy)
- Project Repository: [project-1-employee-task-management-system](https://github.com/CSfrogy/project-1-employee-task-management-system)

Feel free to reach out with any questions, feedback, or suggestions!

<p align="right">(<a href="#top">back to top</a>)</p>

---

## Acknowledgments

This project was inspired by and built upon:

- [Laravel Framework](https://laravel.com) - The amazing PHP framework
- [Laravel Documentation](https://laravel.com/docs) - Comprehensive framework documentation
- [Livewire](https://livewire.laravel.com) - For interactive component framework
- [Vite](https://vitejs.dev) - For modern build tooling
- [Bootstrap](https://getbootstrap.com) - For responsive design utilities
- All contributors and open-source community members

Special thanks to everyone who has contributed to this project and the Laravel ecosystem!

<p align="right">(<a href="#top">back to top</a>)</p>

---

<div align="center">
  <p>Made with ❤️ by <a href="https://github.com/CSfrogy">CSfrogy</a></p>
  <p>© 2025 Employee Task Management System. All rights reserved.</p>
</div>
