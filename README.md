
# 🛠️ CreatingContents Backend

A robust backend API built with **Laravel**, designed to manage and serve content for the CreatingContents platform. This project demonstrates proficiency in modern PHP development, API design, and database management.

---

## 🚀 Features

- 🔐 Secure API endpoints for content management
- 🗄️ Structured database schema for efficient data storage
- 📦 Dockerized environment for consistent development setup
- 🧪 PHPUnit-based testing suite for backend logic validation

---

## 🛠️ Tech Stack

- **Backend Framework**: [Laravel](https://laravel.com/)
- **Database**: MySQL
- **Containerization**: Docker
- **Testing**: PHPUnit
- **Frontend Integration**: Tailored for integration with the [CreatingContents Frontend](https://github.com/htay-htay-thwe/creatingContents-frontend)

---

## 📂 Project Structure



creatingContents-backened/
├── app/                  # Core application logic
├── bootstrap/            # Application bootstrapping
├── config/               # Configuration files
├── database/             # Database migrations and seeds
├── public/               # Publicly accessible files
├── resources/            # Views and localization files
├── routes/               # API and web routes
├── storage/              # Logs and file storage
├── tests/                # Automated tests
├── .dockerignore         # Docker ignore file
├── .editorconfig         # Editor configuration
├── .env.example          # Environment variables example
├── .gitignore            # Git ignore file
├── Dockerfile            # Docker configuration
├── README.md             # Project documentation
├── artisan               # Laravel command-line tool
├── composer.json         # PHP dependencies
├── composer.lock         # PHP dependency lock file
├── package.json          # Node.js dependencies
└── vite.config.js        # Vite configuration for frontend assets

---

## ⚙️ Installation & Setup

### Clone the repository

```bash
git clone https://github.com/htay-htay-thwe/creatingContents-backened.git
cd creatingContents-backened
````

### Copy and configure environment variables

```bash
cp .env.example .env
```

Update the `.env` file with your database credentials and other environment-specific settings.

### Build and start the Docker containers

```bash
docker-compose up -d
```

This command builds the Docker images and starts the containers in detached mode.

### Install PHP dependencies

```bash
docker exec app composer install
```

### Generate the application key

```bash
docker app php artisan key:generate
```

### Run database migrations

```bash
docker exec app php artisan migrate
```

### Access the application

The backend API should now be accessible at `http://localhost:8000`.

---

## 🧪 Running Tests

To run the test suite:

```bash
docker-compose exec app php artisan test
```

This will execute the PHPUnit tests to ensure the integrity of your application.

---

## 📬 Contact

👤 **Your Name**
📧 Email: htayhtaythwe962@gmail.com

---

⭐ If you find this project useful, please consider giving it a **star**!

```

---

### 📌 Notes for Employers

This backend project is designed to work seamlessly with the [CreatingContents Frontend](https://github.com/htay-htay-thwe/creatingContents-frontend), providing a full-stack solution for content management. The use of Docker ensures a consistent development environment, making it easy to set up and collaborate on.

If you have any questions or need further information, feel free to reach out via the contact details provided above.

---
 
```


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Login Page
![127 0 0 1_8000_login_page](https://github.com/user-attachments/assets/9a5d9253-34f8-42ba-b43a-e9abd5a950e2)




## Register Page 
![127 0 0 1_8000_register_page](https://github.com/user-attachments/assets/92641911-836d-4d5e-b07b-3bf46b522302)


## Admin Dashboard
![127 0 0 1_8000_dashboard](https://github.com/user-attachments/assets/065fe4a1-5d2b-4c15-9003-24f119b00e13)




## Manage User Account 
![127 0 0 1_8000_manage_user_acc](https://github.com/user-attachments/assets/e267619a-2dd9-44a7-9253-768a041b2532)




## Change Password Account 
![127 0 0 1_8000_change_password](https://github.com/user-attachments/assets/c2ca77ff-b052-4dac-ae23-53e097f1b068)




## Admin Account Information
![127 0 0 1_8000_admin_acc_6](https://github.com/user-attachments/assets/3fbc7a13-4251-45ec-b8b8-53d67acdaa8f)



