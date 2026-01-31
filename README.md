
# Creating Contents - Backend API

A robust Laravel-based REST API backend for a content creation and sharing platform. This application provides comprehensive features for content management, user authentication, social interactions, and engagement tracking.

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [API Documentation](#api-documentation)
- [Docker Deployment](#docker-deployment)
- [Project Structure](#project-structure)
- [Testing](#testing)
- [Screenshots](#screenshots)
- [License](#license)

## ✨ Features

### Content Management
- Create, read, update, and delete posts
- Image upload and management
- Soft delete with restore capability
- Permanent deletion option
- Content search and filtering by genre
- View tracking for content analytics

### User Authentication & Authorization
- User registration and login
- JWT-based authentication
- Social login integration (OAuth)
- Profile management
- Password change functionality
- Profile image upload

### Social Interactions
- Like/Unlike posts
- Save/Unsave posts for later reading
- Commenting system with nested replies
- Comment deletion
- View counting and tracking

### Additional Features
- Middleware-based route protection
- RESTful API architecture
- CORS support for frontend integration
- File storage management
- Real-time engagement metrics

## 🛠 Tech Stack

- **Framework:** Laravel 10.x
- **PHP Version:** 8.1+
- **Database:** MySQL
- **Authentication:** JWT (tymon/jwt-auth) & Laravel Sanctum
- **Social Auth:** Laravel Socialite
- **Frontend Assets:** Vite
- **CSS Framework:** Tailwind CSS
- **Additional Packages:**
  - Laravel Fortify (Authentication scaffolding)
  - Laravel Jetstream (Application scaffolding)
  - Livewire (Real-time UI components)
  - Guzzle HTTP (API requests)

## 📦 Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7 or MariaDB >= 10.3
- Node.js >= 18.x
- NPM or Yarn
- Git

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/htay-htay-thwe/creatingContents-backened.git
cd creatingContents-backened
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Setup

Create a `.env` file by copying the example:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Generate JWT secret key:

```bash
php artisan jwt:secret
```

## ⚙️ Configuration

### Database Configuration

Update your `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=creating_content
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Application Settings

```env
APP_NAME="Creating Contents"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

### JWT Configuration

```env
JWT_SECRET=your_generated_jwt_secret
JWT_TTL=60
```

### Social Login (Optional)

Configure your OAuth providers:

```env
GITHUB_CLIENT_ID=your_github_client_id
GITHUB_CLIENT_SECRET=your_github_client_secret
GITHUB_REDIRECT_URI=http://localhost:8000/auth/github/callback

GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### CORS Configuration

Update `config/cors.php` to allow your frontend domain:

```php
'allowed_origins' => ['http://localhost:3000'],
```

## 💾 Database Setup

### Run Migrations

```bash
php artisan migrate
```

### Import SQL File (Alternative)

If you prefer to use the provided SQL file:

```bash
mysql -u your_username -p creating_content < creating_content.sql
```

### Seed Database (Optional)

```bash
php artisan db:seed
```

## 🏃 Running the Application

### Development Server

Start the Laravel development server:

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

### Build Frontend Assets

For development (with hot reload):

```bash
npm run dev
```

For production:

```bash
npm run build
```

### Storage Link

Create symbolic link for storage:

```bash
php artisan storage:link
```

## 📚 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/userAuth/create/user` | Register new user | No |
| POST | `/userAuth/user/login` | User login | No |
| POST | `/userAuth/upload/profileImage` | Upload profile image | Yes |
| POST | `/userAuth/update/user/information` | Update user info | Yes |
| POST | `/userAuth/change/password` | Change password | Yes |

### Social Authentication

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/auth/{provider}/redirect` | Redirect to OAuth provider |
| GET | `/auth/{provider}/callback` | OAuth callback handler |

*Supported providers: google, github, facebook*

### Post Management

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/basic-ui/create/post` | Create new post | Yes |
| GET | `/basic-ui/edit/post/{id}/{userId}` | Get post for editing | Yes |
| POST | `/basic-ui/update/post` | Update existing post | Yes |
| GET | `/basic-ui/get/read/content/{id}/{userId}` | Get post details | Yes |
| GET | `/basic-ui/get/profile/post/{id}` | Get user's posts | No |
| GET | `/basic-ui/delete/profile/post/{id}` | Soft delete post | Yes |
| GET | `/basic-ui/restore/profile/post/{id}` | Restore deleted post | Yes |
| GET | `/basic-ui/delete/permanent/profile/post/{id}` | Permanently delete post | Yes |

### Search

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/basic-ui/search/data/{id}/{searchKey}` | Search posts | Yes |
| GET | `/basic-ui/genre/search/data/{id}/{searchKey}` | Search by genre | Yes |

### Comments

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/basic-ui/show/comments/{id}` | Get post comments | Yes |
| GET | `/basic-ui/create/comment/{id}/{parentId}/{comment}/{userId}` | Create comment | Yes |
| POST | `/basic-ui/reply/comment/{id}/{userId}` | Reply to comment | Yes |
| GET | `/basic-ui/delete/comment/{id}/{postId}` | Delete comment | Yes |

### Likes & Saves

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/basic-ui/add/like/{id}/{userId}` | Like a post | Yes |
| GET | `/basic-ui/unlike/{id}/{userId}` | Unlike a post | Yes |
| GET | `/basic-ui/create/save/{id}/{userId}` | Save a post | Yes |
| GET | `/basic-ui/unSave/{id}` | Remove saved post | Yes |

### Views

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/basic-ui/create/view/content/{id}/{postIds}` | Track post view | Yes |
| GET | `/basic-ui/get/view/content` | Get view statistics | Yes |

### Request Headers

For authenticated endpoints, include:

```
Authorization: Bearer {your_jwt_token}
Content-Type: application/json
Accept: application/json
```

## 🐳 Docker Deployment

### Build Docker Image

```bash
docker build -t creating-contents-backend .
```

### Run Container

```bash
docker run -d -p 8000:8000 creating-contents-backend
```

### Docker Compose (Recommended)

Create a `docker-compose.yml` file:

```yaml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "8000:8000"
    environment:
      - DB_HOST=db
      - DB_DATABASE=creating_content
      - DB_USERNAME=root
      - DB_PASSWORD=secret
    depends_on:
      - db
  
  db:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: creating_content
      MYSQL_ROOT_PASSWORD: secret
    ports:
      - "3306:3306"
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

Run with:

```bash
docker-compose up -d
```

## 📁 Project Structure

```
creatingContents-backened/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # API Controllers
│   │   ├── Middleware/       # Custom Middleware
│   │   └── Responses/        # Custom Responses
│   ├── Models/               # Eloquent Models
│   │   ├── User.php
│   │   ├── Post.php
│   │   ├── Comment.php
│   │   ├── Like.php
│   │   ├── Save.php
│   │   ├── View.php
│   │   └── Image.php
│   └── Providers/            # Service Providers
├── config/                   # Configuration Files
├── database/
│   ├── migrations/           # Database Migrations
│   ├── seeders/              # Database Seeders
│   └── factories/            # Model Factories
├── routes/
│   ├── api.php               # API Routes
│   └── web.php               # Web Routes
├── resources/
│   ├── js/                   # JavaScript Assets
│   ├── css/                  # CSS Assets
│   └── views/                # Blade Templates
├── storage/                  # File Storage
├── tests/                    # Test Files
├── .env.example              # Environment Template
├── composer.json             # PHP Dependencies
├── package.json              # Node Dependencies
└── Dockerfile                # Docker Configuration
```

## 🧪 Testing

Run PHPUnit tests:

```bash
php artisan test
```

Run specific test:

```bash
php artisan test --filter=TestName
```

Run with coverage:

```bash
php artisan test --coverage
```

## 🔒 Security

- All passwords are hashed using bcrypt
- JWT tokens expire after configured TTL
- CSRF protection enabled
- SQL injection prevention via Eloquent ORM
- XSS protection
- Rate limiting on API routes

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📸 Screenshots

### Login Page
![Login Page](https://github.com/user-attachments/assets/9a5d9253-34f8-42ba-b43a-e9abd5a950e2)

### Register Page
![Register Page](https://github.com/user-attachments/assets/92641911-836d-4d5e-b07b-3bf46b522302)

### Admin Dashboard
![Admin Dashboard](https://github.com/user-attachments/assets/065fe4a1-5d2b-4c15-9003-24f119b00e13)

### Manage User Account
![Manage User Account](https://github.com/user-attachments/assets/e267619a-2dd9-44a7-9253-768a041b2532)

### Change Password
![Change Password](https://github.com/user-attachments/assets/c2ca77ff-b052-4dac-ae23-53e097f1b068)

### Admin Account Information
![Admin Account Information](https://github.com/user-attachments/assets/3fbc7a13-4251-45ec-b8b8-53d67acdaa8f)

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 👥 Author

**Htay Htay Thwe**
- GitHub: [@htay-htay-thwe](https://github.com/htay-htay-thwe)
- Email: htayhtaythwe962@gmail.com

## 📞 Support

For support, please open an issue in the GitHub repository or contact the development team.

---

⭐ If you find this project useful, please consider giving it a **star**!

**Made with ❤️ using Laravel**
