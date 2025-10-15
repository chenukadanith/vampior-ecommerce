# Multi-Vendor E-Commerce Platform

A comprehensive multi-vendor e-commerce platform built with Laravel 12, featuring role-based access control and modern e-commerce functionalities. Developed as a technical assessment for the Associate PHP Laravel Developer position at Vampior Designs.

## 🎯 Overview

This platform demonstrates a full-stack implementation of a multi-role system with distinct features for buyers, sellers, and administrators. Each user role has a tailored dashboard and specific permissions to create a complete e-commerce ecosystem.

## ✨ Features

### 👤 Admin Features

The admin has global oversight and control over the entire platform:

- **User Management**: View all registered users, assign or update their roles (promote buyers to sellers), and delete users
- **Category Management**: Full CRUD control over product categories to maintain a consistent taxonomy
- **Global Product Management**: View, edit, and delete any product from any seller, or create new products and assign them to specific sellers
- **Global Order Management**: Comprehensive dashboard with all platform orders, revenue statistics, and detailed order inspection

### 🏬 Seller Features

Sellers have complete control over their digital storefront:

- **Product Management**: Full CRUD operations on their own products with authorization policies preventing access to other sellers' items
- **Category Selection**: Choose from admin-created categories when managing products
- **Order Management**: View all sales, access customer shipping details, and update order status through the fulfillment pipeline (Pending → Accepted → Shipping)
- **Sales Analytics Dashboard**: Insights including total revenue, units sold, active orders count, and top-selling products

### 🛒 Buyer Features

Buyers enjoy a complete modern e-commerce experience:

- **Product Discovery**: Responsive product grid with category filtering and real-time search functionality
- **Shopping Cart**: Session-based cart to add, update quantities, or remove items before checkout
- **Wishlist**: Persistent, database-driven wishlist with instant visual feedback via heart icons
- **Secure Checkout**: Streamlined checkout process for shipping information and order placement
- **Order Tracking**: Personal "My Orders" page to view order history and status, with ability to mark items as "Completed" upon receipt

## 🔐 Security & Authentication

- **Role-Based Access Control**: Comprehensive permission system using `spatie/laravel-permission`
- **OAuth 2.0 Integration**: Secure login via Google and GitHub using Laravel Socialite
- **Session Management**: Built on Laravel's robust authentication system

## 🛠️ Technical Stack

- **Backend**: Laravel 12
- **Frontend**: Blade Templates & Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel's built-in system + Laravel Socialite
- **Authorization**: spatie/laravel-permission
- **Image Processing**: intervention/image for optimization and resizing

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL
- Git

## 🚀 Installation

Follow these steps to set up the project locally:

### 1. Clone the Repository

```bash
git clone [Your Repository URL]
cd [repository-folder-name]
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Configuration

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Environment Variables

Edit your `.env` file and configure the following:

```env
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

# Google OAuth
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback

# GitHub OAuth
GITHUB_CLIENT_ID=your_github_client_id
GITHUB_CLIENT_SECRET=your_github_client_secret
GITHUB_REDIRECT_URL=http://localhost:8000/auth/github/callback
```

### 5. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed default roles (Admin, Seller, Buyer)
php artisan db:seed
```

### 6. Storage Link

Create a symbolic link for public storage access:

```bash
php artisan storage:link
```

### 7. Start Development Servers

Open two terminal windows:

**Terminal 1 - Vite Development Server:**
```bash
npm run dev
```

**Terminal 2 - Laravel Development Server:**
```bash
php artisan serve
```

### 8. Access the Application

Visit `http://localhost:8000` in your web browser.

## 📁 Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Application controllers
│   │   └── Middleware/      # Custom middleware
│   ├── Models/              # Eloquent models
│   └── Policies/            # Authorization policies
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── views/               # Blade templates
│   └── js/                  # Frontend JavaScript
├── routes/
│   └── web.php              # Web routes
└── public/                  # Public assets
```

## 🔑 Default Credentials

After seeding, you can create users with the following roles:

- **Admin**: Full platform access
- **Seller**: Product and order management
- **Buyer**: Shopping and order tracking

## 🧪 Testing

```bash
# Run tests
php artisan test
```

## 📝 Key Features Implementation

### Authorization
- Role-based permissions using Spatie's Laravel Permission package
- Policy-based authorization for resource access control
- Middleware protection on all routes

### Image Handling
- Automatic image optimization and resizing using Intervention Image
- Secure file storage with Laravel's storage system
- Public access via symbolic links

### Order Management
- Multi-stage order status workflow
- Real-time status updates
- Comprehensive order tracking for all user roles

## 🤝 Contributing

This project was developed as a technical assessment. For any questions or suggestions, please open an issue.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Developer

Developed for Vampior Designs technical assessment.

## 📞 Support

For support or queries, please contact [Your Email] or open an issue in the repository.

---

**Note**: Remember to configure your OAuth credentials before enabling social login features.
