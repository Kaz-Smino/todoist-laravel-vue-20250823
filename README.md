# Task Manager Application - Laravel & Vue.js

> Build a simple task manager application where users can create, read, update, and delete tasks. The frontend will be built with Vue.js, and the backend will be built with Laravel.

## 🎯 Project Overview

A full-stack task management application demonstrating modern web development practices with Laravel and Vue.js, featuring complete CRUD operations and a responsive user interface.

## 📋 Requirements Specification

### Backend (Laravel)

#### Setup
- ✅ Laravel project with MySQL database
- ✅ Environment configuration

#### Tasks API
- [ ] Create a `Task` model with the following fields:
  - `id` (primary key)
  - `title` (string)
  - `description` (text)
  - `completed` (boolean)
  - `created_at` and `updated_at` (timestamps)
- [ ] Create a migration for the `tasks` table
- [ ] Implement a controller with CRUD operations
- [ ] Set up API routes for these CRUD operations:
  - `GET /api/tasks` - List all tasks
  - `POST /api/tasks` - Create a new task
  - `GET /api/tasks/{id}` - Show a specific task
  - `PUT /api/tasks/{id}` - Update a task
  - `DELETE /api/tasks/{id}` - Delete a task

### Frontend (Vue.js)

#### Setup
- [ ] Vue.js 3 project with Vite
- [ ] Install Axios for making HTTP requests

#### Components

**TaskList.vue**: Display a list of tasks
- [ ] Fetch tasks from the Laravel API and display them
- [ ] Allow users to mark tasks as completed

**TaskForm.vue**: Form for creating and editing tasks
- [ ] Allow users to enter a title and description
- [ ] Include a checkbox for marking the task as completed
- [ ] Submit the form to create or update tasks

**TaskItem.vue**: Display an individual task
- [ ] Include buttons for editing and deleting the task

#### Routing
- [ ] Set up Vue Router to navigate between the task list and the task form

#### Styling
- [ ] Apply responsive styling to make the application presentable

### Optional Features

- [ ] State management with Vuex or Pinia
- [ ] API Authentication system

## 🛠️ Technology Stack

- **Backend**: Laravel 12 with PHP 8.2+
- **Frontend**: Vue.js 3 with Vite
- **Database**: MySQL
- **HTTP Client**: Axios
- **Development Environment**: Laravel Sail (Docker)
- **Styling**: Tailwind CSS 4

## 🚀 Getting Started

### Prerequisites
- Docker Desktop
- Node.js 18+

### Installation & Setup

1. **Clone the repository**:
```bash
git clone https://github.com/Kaz-Smino/todoist-laravel-vue-20250823.git
cd todoist-laravel-vue-20250823
```

2. **Start the Docker environment**:
```bash
./vendor/bin/sail up -d
```

3. **Install dependencies**:
```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

4. **Setup environment and database**:
```bash
./vendor/bin/sail artisan migrate
```

5. **Build frontend assets**:
```bash
./vendor/bin/sail npm run dev
```

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/     # API Controllers
│   └── Models/              # Eloquent Models
├── database/
│   └── migrations/          # Database Migrations
├── resources/
│   ├── js/                  # Vue.js Components
│   └── css/                 # Styling
├── routes/
│   ├── api.php              # API Routes
│   └── web.php              # Web Routes
└── tests/                   # Application Tests
```

## 📊 Deliverables

1. **Laravel API** with endpoints for CRUD operations on tasks
2. **Vue.js application** with components for listing, creating, editing, and deleting tasks
3. **Responsive styling** to make the application look presentable

## 🎓 Learning Objectives

This project demonstrates proficiency in:
- Laravel backend API development
- Vue.js component-based frontend development
- RESTful API design and consumption
- Database design and migrations
- Modern JavaScript (ES6+)
- Responsive web design

## 📄 License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).