# Laravel Recipe Organizer

A categorized recipe collection web application for breakfast, lunch, and dinner recipes with user authentication, recipe management, and favoriting functionality.

## 📋 Table of Contents

- [Project Description](#project-description)
- [Team Members](#team-members)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Architecture](#architecture)
- [Installation & Setup](#installation--setup)
- [Usage](#usage)
- [Database Schema](#database-schema)
- [API Endpoints](#api-endpoints)
- [Development Workflow](#development-workflow)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

## 🎯 Project Description

The Recipe Organizer is a web application designed to help users manage their favorite recipes across different meal categories. Users can register, login, create, edit, and organize recipes by breakfast, lunch, and dinner categories. The application features a modern, responsive design with search and filtering capabilities.

## 👥 Team Members

- **[Student_ID_1]** - Project Manager & Backend Developer
- **[Student_ID_2]** - Backend Developer & Database Specialist  
- **[Student_ID_3]** - Frontend Developer & UI/UX Designer

*Repository Name: `[Student_ID_1]_[Student_ID_2]_[Student_ID_3]_[Student_ID_4]_[Student_ID_5]`*

## ✨ Features

### Core Features
- 🔐 **User Authentication** - Register, login, logout functionality
- 📝 **Recipe Management** - Create, read, delete recipes
- 🗂️ **Recipe Categorization** - Organize recipes by breakfast, lunch, dinner
- 🔍 **Search & Filtering** - Find recipes by title, ingredients, or category
- ❤️ **Favorites System** - Save and manage favorite recipes
- 📱 **Responsive Design** - Works on desktop, tablet, and mobile devices

### Additional Features
- ⏱️ **Cooking Time Tracking** - Preparation and cooking time estimates
- 📊 **Difficulty Levels** - Easy, medium, hard recipe classifications
- 🖼️ **Image Upload** - Add photos to recipes
- 📋 **Ingredient Lists** - Structured ingredient management
- 👨‍🍳 **Step-by-step Instructions** - Detailed cooking instructions

## 🛠️ Technology Stack

### Backend
- **Framework**: Laravel 10.x (PHP 8.1+)
- **Database**: MySQL 8.0
- **Authentication**: Laravel Breeze with Tailwind CSS
- **Storage**: Local file storage for images

### Frontend
- **Framework**: Blade Templates with Tailwind CSS
- **JavaScript**: Alpine.js for interactivity
- **Icons**: Heroicons
- **Styling**: Custom CSS with glassmorphism effects

### Development Tools
- **Version Control**: Git with GitHub
- **Dependency Management**: Composer (PHP), NPM (JavaScript)
- **Testing**: PHPUnit, Laravel Dusk

## 🏗️ Architecture

### Architectural Pattern
The application follows the **Model-View-Controller (MVC)** pattern with Laravel's conventions:

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Presentation  │    │   Application   │    │      Data       │
│   Layer (View)  │    │ Layer (Controller)│  │  Layer (Model)  │
│                 │    │                 │    │                 │
│ - Blade Templates│◄──►│ - Controllers   │◄──►│ - Eloquent ORM  │
│ - Tailwind CSS  │    │ - Middleware    │    │ - Database      │
│ - Alpine.js     │    │ - Validation    │    │ - Migrations    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

### Architecture Justification
1. **MVC Pattern**: Provides clear separation of concerns, making the codebase maintainable and scalable
2. **Laravel Framework**: Offers robust features like Eloquent ORM, built-in authentication, and excellent documentation
3. **MySQL Database**: Relational database perfect for structured recipe data with relationships
4. **Blade Templates**: Server-side rendering for better SEO and initial page load performance
5. **Tailwind CSS**: Utility-first CSS framework for rapid UI development and consistent styling

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL 8.0
- Git

### Step-by-Step Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/Temurbek-2001/cook-book.git
   cd cook-book
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript Dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Configuration**
   
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=cook_book
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Create Database**
   ```bash
   mysql -u your_username -p
   CREATE DATABASE cook_book;
   exit
   ```

7. **Run Migrations and Seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

8. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

9. **Build Assets**
   ```bash
   npm run build
   ```

10. **Start Development Server**
    ```bash
    php artisan serve
    ```

11. **Access Application**
    
    Open your browser and navigate to: `http://localhost:8000`


## 📖 Usage

### Getting Started
1. **Register/Login**: Create an account or login with existing credentials
2. **Browse Recipes**: View recipes by category (Breakfast, Lunch, Dinner)
3. **Create Recipe**: Click "Add Recipe" to create your own recipe
4. **Manage Favorites**: Click the heart icon to save favorite recipes

### Recipe Management
- **Create**: Fill out the recipe form with title, ingredients, instructions, and category
- **Filter**: Use category filters and search to find specific recipes

## 🗄️ Database Schema

### Entity Relationship Diagram
```
┌─────────────┐         ┌─────────────┐         ┌─────────────┐
│    Users    │         │   Recipes   │         │ Categories  │
├─────────────┤         ├─────────────┤         ├─────────────┤
│ id (PK)     │◄───────┐│ id (PK)     │┌───────►│ id (PK)     │
│ name        │        ││ title       ││        │ name        │
│ email       │        ││ description ││        │ description │
│ password    │        ││ ingredients ││        │ created_at  │
│ created_at  │        ││ instructions││        │ updated_at  │
│ updated_at  │        ││ prep_time   ││        └─────────────┘
└─────────────┘        ││ cook_time   ││
                       ││ difficulty  ││
       ┌─────────────┐ ││ image_path  ││
       │  Favorites  │ ││ user_id (FK)││
       ├─────────────┤ ││ category_id ││
       │ id (PK)     │ ││ created_at  ││
       │ user_id (FK)│◄┘│ updated_at  ││
       │ recipe_id   │◄─┘└─────────────┘
       │ created_at  │
       │ updated_at  │
       └─────────────┘
```

### Table Definitions

#### Users Table
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT (PK) | Primary key |
| name | VARCHAR(255) | User's full name |
| email | VARCHAR(255) | User's email (unique) |
| password | VARCHAR(255) | Hashed password |
| created_at | TIMESTAMP | Record creation time |
| updated_at | TIMESTAMP | Record last update time |

#### Categories Table
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT (PK) | Primary key |
| name | VARCHAR(100) | Category name |
| description | TEXT | Category description |
| created_at | TIMESTAMP | Record creation time |
| updated_at | TIMESTAMP | Record last update time |

#### Recipes Table
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT (PK) | Primary key |
| title | VARCHAR(255) | Recipe title |
| description | TEXT | Recipe description |
| ingredients | JSON | List of ingredients |
| instructions | TEXT | Cooking instructions |
| preparation_time | INTEGER | Prep time in minutes |
| cooking_time | INTEGER | Cook time in minutes |
| difficulty_level | ENUM | easy, medium, hard |
| image_path | VARCHAR(255) | Recipe image path |
| user_id | BIGINT (FK) | Foreign key to users |
| category_id | BIGINT (FK) | Foreign key to categories |
| created_at | TIMESTAMP | Record creation time |
| updated_at | TIMESTAMP | Record last update time |

#### Favorites Table
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT (PK) | Primary key |
| user_id | BIGINT (FK) | Foreign key to users |
| recipe_id | BIGINT (FK) | Foreign key to recipes |
| created_at | TIMESTAMP | Record creation time |
| updated_at | TIMESTAMP | Record last update time |

## 🔌 API Endpoints

### Authentication Routes
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/login` | Show login form |
| POST | `/login` | Process login |
| POST | `/logout` | User logout |
| GET | `/register` | Show registration form |
| POST | `/register` | Process registration |

### Recipe Routes
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/` | Homepage with featured recipes |
| GET | `/recipes` | List all recipes |
| GET | `/recipes/create` | Show create recipe form |
| POST | `/recipes` | Store new recipe |
| GET | `/recipes/{id}` | Show specific recipe |
| GET | `/recipes/{id}/edit` | Show edit recipe form |
| PUT | `/recipes/{id}` | Update recipe |
| DELETE | `/recipes/{id}` | Delete recipe |

### Category Routes
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/categories/{id}` | Show recipes by category |
| GET | `/breakfast` | Show breakfast recipes |
| GET | `/lunch` | Show lunch recipes |
| GET | `/dinner` | Show dinner recipes |

### Favorite Routes
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/favorites` | Add recipe to favorites |
| DELETE | `/favorites/{id}` | Remove from favorites |
| GET | `/favorites` | Show user's favorite recipes |


## 🔄 Development Workflow

### Development Process
1. **Feature Development**: Create feature branches from `dev`
2. **Code Review**: All changes require pull request review
3. **Testing**: Run tests before merging
4. **Integration**: Merge approved features to `dev`
5. **Release**: Merge `dev` to `main` for production

### Team Responsibilities

#### Project Manager & Backend Developer 1
- Project planning and task coordination
- User authentication system
- Database migrations and models
- API endpoint development

#### Backend Developer & Database Specialist
- Database schema design
- Model relationships and validation
- Search and filtering functionality
- Unit testing

#### Frontend Developer & UI/UX Designer
- Blade template development
- Responsive design implementation
- JavaScript functionality
- User experience optimization


## 🧪 Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### Test Structure
```
tests/
├── Feature/
│   ├── RecipeControllerTest.php
│   ├── ProfileTest.php
│   └── FavoriteTest.php
└── Unit/
   ├── RecipeTest.php
   ├── FavoriteTest.php
   ├── UserTest.php
   └── CategoryModelTest.php

```

### Test Coverage Goals
- **Unit Tests**: 80%+ coverage for models and utilities
- **Feature Tests**: All major user workflows

## 🤝 Contributing

### Development Setup
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Run the test suite
6. Submit a pull request

### Code Style
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add PHPDoc comments for methods
- Keep methods focused and small

### Pull Request Process
1. Update documentation if needed
2. Add tests for new features
3. Ensure all tests pass
4. Request review from team members
5. Address review feedback
6. Merge after approval

## 📄 License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

---

## 📞 Support

If you encounter any issues or have questions:

1. Check the [Issues](../../issues) page for existing problems
2. Create a new issue with detailed description
3. Contact the development team
4. Review the documentation

**Happy Cooking! 👨‍🍳👩‍🍳**
