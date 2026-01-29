# Enrollment System - Features & Tools

## 📋 Project Overview

A modern, scalable enrollment management system built with Laravel and Filament. The system provides an intuitive interface for managing courses, departments, subjects, curricula, and student enrollments.

---

## ✨ Features

### Core Management Modules

-   **👥 User Management**

    -   User registration and authentication
    -   Role-based access control (Registrar Panel)
    -   User profile management

-   **🏫 Department Management**

    -   Create and manage departments
    -   Track department details and status
    -   Associate courses with departments

-   **📚 Course Management**

    -   Create and manage courses with codes and descriptions
    -   Link courses to departments
    -   Track course status (active/inactive)
    -   Searchable course listings

-   **📖 Subject Management**

    -   Manage subjects with detailed specifications
    -   Track lecture and laboratory hours/units
    -   Subject type classification (Lecture, Lab, Lecture+Lab)
    -   Status tracking

-   **📋 Curriculum Management**

    -   Create and manage academic curricula
    -   Associate subjects with curricula
    -   Track curriculum details and versions

-   **📝 Prospectus Management**
    -   Manage program prospectuses
    -   Link prospectuses to subjects
    -   Track prospectus information and status

### Dashboard & Analytics

-   **📊 Dashboard Overview**

    -   Statistics overview widgets displaying key metrics
    -   Visual charts and analytics

-   **📈 Enrollees Chart**
    -   Visual representation of enrollment data
    -   Chart-based analytics for enrollment trends

### User Experience Features

-   **🔍 Advanced Search & Filtering**

    -   Searchable select fields with dynamic options
    -   Search by related model fields (e.g., search departments by code or description)
    -   Real-time filtering capabilities

-   **🎨 Custom Theme**

    -   Modern, responsive interface
    -   Customized Filament theme with dark primary color (#042042)
    -   Secondary accent color (#eaea52)
    -   Rounded corners and smooth interactions
    -   Hover effects on navigation items

-   **📱 Responsive Design**

    -   Mobile-friendly interface
    -   Adaptive layouts for all screen sizes

-   **⚡ Real-time Updates**
    -   Instant form validation
    -   Live search suggestions
    -   Dynamic field population

---

## 🛠️ Technology Stack

### Backend

-   **Laravel 12.0** - Modern PHP web application framework
-   **PHP 8.2+** - Latest PHP version
-   **Filament 4.0** - Powerful admin panel and form builder
-   **Eloquent ORM** - Database query builder and ORM

### Frontend

-   **Tailwind CSS 4.1.17** - Utility-first CSS framework
-   **@tailwindcss/vite** - Tailwind CSS Vite plugin for optimization
-   **Vite 7.0.7** - Next-generation frontend build tool
-   **Axios 1.11.0** - Promise-based HTTP client
-   **Blade** - Laravel's templating engine

### Development Tools

-   **Composer** - PHP dependency manager
-   **NPM** - Node package manager
-   **Laravel Pint** - PHP code style fixer
-   **Laravel Pail** - Real-time log viewer
-   **Laravel Sail** - Docker development environment

### Database

-   **MySQL/SQLite** - Database management (via Laravel migrations)
-   **Laravel Migrations** - Database version control

### Testing & Quality

-   **PHPUnit 11.5.3** - PHP testing framework
-   **Mockery 1.6** - Mocking library for testing
-   **Collision 8.6** - Error page for Laravel
-   **FakerPHP 1.23** - Fake data generation for testing

### Architecture & Patterns

-   **MVC Architecture** - Model-View-Controller pattern
-   **Service Providers** - Laravel dependency injection
-   **Middleware** - Request/response pipeline
-   **Factories & Seeders** - Data generation and seeding

---

## 📦 Database Models

1. **User** - System users and authentication
2. **Department** - Academic departments
3. **Course** - Academic courses
4. **Subject** - Individual subjects
5. **Curriculum** - Academic curricula
6. **Prospectus** - Program prospectuses

---

## 🎯 Key Capabilities

✅ **CRUD Operations** - Full Create, Read, Update, Delete functionality for all modules  
✅ **Role-Based Access Control** - Secure panel access with authentication  
✅ **Data Validation** - Form-level and database-level validation  
✅ **Bulk Actions** - Perform actions on multiple records  
✅ **Status Tracking** - Active/Inactive status for most entities  
✅ **Timestamps** - Automatic created_at and updated_at tracking  
✅ **Relationships** - Complex database relationships (HasMany, BelongsTo)  
✅ **Search & Filter** - Advanced search with dynamic field population

---

## 🚀 Getting Started

### Prerequisites

-   PHP 8.2+
-   Node.js & npm
-   Composer
-   MySQL/SQLite

### Setup

```bash
composer install
npm install
npm run dev
php artisan migrate
php artisan serve
```

### Development

```bash
npm run dev          # Development build with hot reload
php artisan serve    # Start Laravel development server
```

### Production

```bash
npm run build        # Production build
php artisan migrate  # Apply migrations
```

---

## 📂 Project Structure

```
enrollment-system/
├── app/
│   ├── Filament/
│   │   ├── Resources/        # Resource definitions
│   │   │   ├── Courses/
│   │   │   ├── Curricula/
│   │   │   ├── Departments/
│   │   │   ├── Prospectuses/
│   │   │   ├── Subjects/
│   │   │   └── Users/
│   │   └── Widgets/          # Dashboard widgets
│   │       ├── EnrolleesChart.php
│   │       └── StatsOverview.php
│   ├── Models/               # Eloquent models
│   ├── Http/                 # Controllers & middleware
│   └── Providers/            # Service providers
├── database/
│   ├── migrations/           # Database migrations
│   ├── factories/            # Model factories
│   └── seeders/              # Database seeders
├── resources/
│   ├── css/                  # Stylesheets
│   │   └── filament/registrar/theme.css
│   ├── js/                   # JavaScript files
│   └── views/                # Blade templates
├── routes/                   # Route definitions
└── storage/                  # File storage & logs
```

---

## 🎨 Customization

The system includes a custom Filament theme located at:

-   `resources/css/filament/registrar/theme.css`
-   `tailwind.config.js` - Extended Tailwind configuration with custom colors

Custom colors defined:

-   **Primary**: `#042042` (Dark Blue)
-   **Secondary**: `#eaea52` (Yellow)
-   **Accent**: `#4ea1d3` (Light Blue)

---

## 📝 License

MIT License - Free to use and modify

---

## 👨‍💻 Author

Makiii05 - Enrollment System Project

---

**Last Updated**: December 11, 2025
