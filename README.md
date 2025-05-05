# CodeIgniter 4 API Starter Kit

This project is a CodeIgniter 4 starter kit designed for developing RESTful APIs. It includes JWT (JSON Web Token) authentication and is designed to accelerate your API development process.

## Features

- JWT Authentication
- Refresh Token mechanism
- Protected API routes
- API testing interface
- User authentication (login, register, profile)
- RESTful API structure
- Example API endpoints

## Installation

1. Clone the repository:

```bash
git clone https://github.com/yourusername/codeigniter4-api-starter-kit.git
cd codeigniter4-api-starter-kit
```

1. Install dependencies:

```bash
composer install
```

1. Create the `.env` file:

```bash
cp env .env
```

1. Edit the `.env` file:

```env
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080'
JWT_SECRET = 'your_secret_key_here'
JWT_ALGORITHM = 'HS256'
JWT_ACCESS_TIME = 3600
JWT_REFRESH_TIME = 604800
JWT_ISSUER = 'CodeIgniter 4 API Project'
JWT_AUDIENCE = 'API Users'
```

1. Run the application:

```bash
php spark serve
```

## API Endpoints

### Authentication

- `POST /api/auth/login` - Login and get JWT token
- `POST /api/auth/register` - Register a new user
- `GET /api/auth/profile` - Get user profile (protected)
- `POST /api/auth/refresh` - Refresh JWT token

### Users

- `GET /api/users` - Get all users
- `GET /api/users/:id` - Get user by ID
- `POST /api/users` - Create a new user
- `PUT /api/users/:id` - Update user
- `DELETE /api/users/:id` - Delete user

### Products

- `GET /api/products` - Get all products
- `GET /api/products/:id` - Get product by ID
- `POST /api/products` - Create a new product
- `PUT /api/products/:id` - Update product
- `DELETE /api/products/:id` - Delete product

## Testing API Requests

The project includes an API testing interface accessible at the root URL. This interface allows you to:

1. Login with sample credentials
2. View and copy JWT tokens
3. Refresh tokens when they expire
4. Test API endpoints with different HTTP methods
5. View API responses

## Project Structure

```bash
app/
├── Controllers/
│   ├── Api/Film_Paylasm_Scripti
│   │   ├── Auth.php         - Authentication controller
│   │   ├── BaseController.php - API base controller
│   │   ├── Users.php        - Users controller
│   │   └── Products.php     - Products controller
│   └── Home.php             - Home page controller
├── Filters/
│   └── JWTAuthFilter.php    - JWT authentication filter
├── Libraries/
│   └── JWTHandler.php       - JWT token handling library
├── Models/
│   ├── UserModel.php        - User model
│   └── ProductModel.php     - Product model
└── Views/
    └── api_test.php         - API testing interface
```

## Database Setup

Run migrations to create database tables:

```bash
php spark migrate
```

Seed the database with sample data:

```bash
php spark db:seed AllSeeder
```

## Extending the Project

### Adding a New API Controller

1. Create a new controller in the `app/Controllers/Api` directory
2. Extend the `BaseController` class
3. Add new routes in the `app/Config/Routes.php` file

### Authentication Configuration

You can configure JWT settings in the `.env` file:

- `JWT_SECRET` - Secret key for token encryption
- `JWT_ALGORITHM` - Encryption algorithm (default: HS256)
- `JWT_ACCESS_TIME` - Access token lifetime in seconds (default: 3600)
- `JWT_REFRESH_TIME` - Refresh token lifetime in seconds (default: 604800)
- `JWT_ISSUER` - Token issuer name
- `JWT_AUDIENCE` - Token audience

## Contributing

1. Fork this repository
2. Create a feature branch (`git checkout -b new-feature`)
3. Commit your changes (`git commit -am 'Add new feature: description'`)
4. Push to the branch (`git push origin new-feature`)
5. Create a Pull Request

## Note

This project was created with the assistance of an AI. It is intended for educational purposes and demonstrates how to implement JWT authentication in a CodeIgniter 4 application.

## License

This project is licensed under the MIT License - see the LICENSE file for details.
