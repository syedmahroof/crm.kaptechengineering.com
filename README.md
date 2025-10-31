# Laravel Lead Management System (Bootstrap Version)

A comprehensive Lead Management System built with Laravel 11, Bootstrap 5, and modern web technologies.

## 🚀 Features

### Core Modules

1. **Dashboard**
   - Real-time statistics and analytics
   - Lead distribution by status with pie chart
   - Recent leads and follow-ups overview
   - Quick access to all modules

2. **Lead Management**
   - Complete CRUD operations
   - Advanced filtering (by status, user, product, branch)
   - Lead assignment to users
   - Status tracking with color-coded badges
   - Notes and follow-up tracking per lead

3. **Products & Catalog**
   - Product management with categories and brands
   - Price tracking
   - Active/Inactive status management
   - Category and Brand organization

4. **Follow-ups & Calendar**
   - FullCalendar integration for visual scheduling
   - Follow-up status tracking (Pending, Completed, Cancelled)
   - Calendar view with color-coded events
   - Quick follow-up creation from lead details

5. **User & Role Management**
   - Spatie Laravel Permission integration
   - 4 default roles: Super Admin, Admin, Sales Manager, Sales Executive
   - Granular permission system
   - User assignment and role management

6. **Organization Management**
   - Branch management
   - Contact information tracking
   - Lead assignment by branch

## 🛠️ Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Bootstrap 5
- **Authentication**: Laravel Breeze (Blade)
- **Permissions**: Spatie Laravel Permission
- **Calendar**: FullCalendar.js
- **Charts**: Chart.js
- **Database**: SQLite (configurable to MySQL/PostgreSQL)
- **Icons**: Bootstrap Icons

## 📦 Installation

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite/MySQL/PostgreSQL

### Quick Setup

1. **Clone or use the existing installation**
   ```bash
   cd /Users/syedmahroof/Sites/ra
   ```

2. **Database is already set up and seeded!**
   The database has been migrated and seeded with:
   - Default users with roles
   - Lead statuses
   - Sample categories, brands, and products
   - Sample branches

3. **Server is running!**
   The Laravel development server is already running at:
   ```
   http://localhost:8000
   ```

## 🔐 Default Login Credentials

Three test users have been created:

1. **Super Admin**
   - Email: `admin@example.com`
   - Password: `password`
   - Full system access

2. **Sales Manager**
   - Email: `manager@example.com`
   - Password: `password`
   - Can manage leads, products, and users

3. **Sales Executive**
   - Email: `sales@example.com`
   - Password: `password`
   - Can view and create leads

## 📂 Project Structure

```
app/
├── Http/Controllers/
│   ├── DashboardController.php
│   ├── LeadController.php
│   ├── ProductController.php
│   ├── CategoryController.php
│   ├── BrandController.php
│   ├── BranchController.php
│   ├── NoteController.php
│   ├── FollowupController.php
│   ├── CalendarController.php
│   ├── UserController.php
│   └── RoleController.php
├── Models/
│   ├── User.php (with HasRoles trait)
│   ├── Lead.php
│   ├── Product.php
│   ├── Category.php
│   ├── Brand.php
│   ├── Branch.php
│   ├── Note.php
│   ├── Followup.php
│   └── LeadStatus.php

resources/views/
├── layouts/
│   └── app.blade.php (Bootstrap sidebar layout)
├── dashboard.blade.php
├── leads/ (index, create, edit, show)
├── products/ (index, create, edit)
├── categories/ (index, create, edit)
├── brands/ (index, create, edit)
├── branches/ (index, create, edit)
├── users/ (index, create, edit)
├── roles/ (index, create, edit)
├── followups/ (index)
└── calendar/ (index with FullCalendar)
```

## 🎨 UI Features

- **Modern Bootstrap 5 Design**: Clean, professional interface
- **Responsive Sidebar Navigation**: Fixed sidebar with organized menu items
- **Color-Coded Status**: Visual indicators for lead statuses
- **Interactive Calendar**: FullCalendar integration for follow-ups
- **Charts & Analytics**: Chart.js for data visualization
- **Modal Dialogs**: Quick actions for notes and follow-ups
- **Alert Messages**: Success/error feedback for user actions

## 🔧 Available Routes

### Public Routes
- `/login` - Login page
- `/register` - Registration page

### Authenticated Routes
- `/dashboard` - Main dashboard
- `/leads` - Lead management (index, create, edit, show, delete)
- `/products` - Product management
- `/categories` - Category management
- `/brands` - Brand management
- `/branches` - Branch management
- `/followups` - Follow-up management
- `/calendar` - Calendar view
- `/users` - User management
- `/roles` - Role & permission management

## 💾 Database Schema

### Main Tables
- `users` - System users with authentication
- `roles` & `permissions` - Spatie permission tables
- `lead_statuses` - Status definitions with colors
- `leads` - Main lead records
- `products` - Product catalog
- `categories` - Product categories
- `brands` - Product brands
- `branches` - Organization branches
- `notes` - Lead notes
- `followups` - Follow-up schedules

## 🎯 Key Features

### Lead Filtering
Filter leads by:
- Status
- Assigned User
- Product
- Branch
- Search term (name, email, phone)

### Follow-up Management
- Schedule follow-ups with date/time
- Track status (Pending, Completed, Cancelled)
- View in calendar or list format
- Color-coded calendar events

### Notes System
- Add notes to any lead
- Track conversation history
- User attribution
- Timestamp tracking

### Permission System
17 built-in permissions:
- view/create/edit/delete leads
- view/create/edit/delete products
- view/create/edit/delete users
- view/create/edit/delete roles
- manage settings

## 🚦 Next Steps

1. **Access the application** at http://localhost:8000
2. **Login** with one of the default accounts
3. **Explore** all modules through the sidebar navigation
4. **Create test leads** to see the full workflow
5. **Schedule follow-ups** and view them in the calendar
6. **Customize** the system to your needs

## 🔄 Development Commands

```bash
# Start development server
php artisan serve

# Build assets
npm run build

# Watch for changes (development)
npm run dev

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

## 📝 Notes

- The sidebar navigation is fixed and organized by module type
- All CRUD operations include validation and error handling
- Success/error messages are displayed with Bootstrap alerts
- The dashboard updates dynamically based on data
- Calendar events are fetched via AJAX for real-time updates

## 🎉 Ready to Use!

The system is fully installed, configured, and seeded with sample data. Simply visit http://localhost:8000 and login to start using the application!

---

**Built with ❤️ using Laravel 11, Bootstrap 5, and modern web technologies**
