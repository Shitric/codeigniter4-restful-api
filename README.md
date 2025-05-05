# CodeIgniter 4 RESTful API Starter Kit

This project is a CodeIgniter 4 starter kit designed for developing RESTful APIs. It includes JWT (JSON Web Token) authentication and uses SQLite database.

## Features

- JWT Authentication
- Refresh Token mechanism
- Protected API routes
- User authentication (login, register, profile)
- RESTful API structure
- SQLite database integration

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/yourusername/codeigniter4-restful-api.git
   cd codeigniter4-restful-api
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Create the `.env` file:

   ```bash
   cp env .env
   ```

4. Edit the `.env` file:

   ```env
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080'
   database.default.DBDriver = SQLite3
   database.default.database = writable/database/ci4_api.db
   JWT_SECRET = 'your_secret_key'
   JWT_ALGORITHM = 'HS256'
   JWT_ACCESS_TIME = 3600
   JWT_REFRESH_TIME = 604800
   JWT_ISSUER = 'CodeIgniter 4 API Project'
   JWT_AUDIENCE = 'API Users'
   ```

5. Create the database directory:

   ```bash
   mkdir -p writable/database
   touch writable/database/ci4_api.db
   chmod 777 writable/database/ci4_api.db
   ```

6. Create database tables:

   ```bash
   php spark migrate
   ```

7. Add sample data:

   ```bash
   php spark db:seed UserSeeder
   php spark db:seed ProductSeeder
   ```

8. Run the application:

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

## Project Structure

```bash
app/
├── Controllers/
│   ├── Api/
│   │   ├── Auth.php           - Authentication controller
│   │   ├── BaseController.php - API base controller
│   │   ├── Users.php          - Users controller
│   │   └── Products.php       - Products controller
│   └── Home.php               - Home page controller
├── Filters/
│   └── JWTAuthFilter.php      - JWT authentication filter
├── Libraries/
│   └── JWTHandler.php         - JWT token handling library
├── Models/
│   ├── UserModel.php          - User model
│   └── ProductModel.php       - Product model
└── Traits/
    └── ApiResponseTrait.php   - API response format trait
```

## Note

This project was entirely written by Claude 3.7 LLM using the Windsurf Editor.
