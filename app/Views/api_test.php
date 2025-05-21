<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeIgniter 4 API Test Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20px;
            padding-bottom: 40px;
        }
        .container {
            max-width: 1200px;
        }
        .api-section {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .response-area {
            background-color: #272822;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            min-height: 200px;
            font-family: monospace;
            white-space: pre;
            overflow-x: auto;
        }
        .nav-tabs {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .auth-section {
            margin-bottom: 30px;
            border: 1px solid #4caf50;
            border-radius: 5px;
            padding: 20px;
            background-color: #f1f8e9;
        }
        .token-display {
            background-color: #e8f5e9;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #a5d6a7;
            margin-top: 15px;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4 text-center">CodeIgniter 4 API Test Page</h1>
        
        <!-- Authentication Section -->
        <div class="auth-section">
            <h3>Authentication</h3>
            
            <div class="mt-3">
                <div class="form-group mb-3">
                    <label for="loginEmail">Email:</label>
                    <input type="email" class="form-control" id="loginEmail" value="john.doe@example.com">
                </div>
                <div class="form-group mb-3">
                    <label for="loginPassword">Password:</label>
                    <input type="password" class="form-control" id="loginPassword" value="123456">
                </div>
                <div class="mb-3">
                    <small class="text-muted">* Sample user: john.doe@example.com / 123456</small>
                </div>
                <button class="btn btn-success" id="loginButton">Login</button>
            </div>
            
            <!-- Token Display -->
            <div id="tokenSection" style="display: none;">
                <div class="mt-4">
                    <h5>JWT Token:</h5>
                    <div class="token-display" id="tokenDisplay"></div>
                    <div class="mt-2">
                        <button class="btn btn-sm btn-secondary" id="copyTokenButton">Copy Token</button>
                        <button class="btn btn-sm btn-info" id="viewProfileButton">View Profile</button>
                        <button class="btn btn-sm btn-warning" id="refreshTokenButton">Refresh Token</button>
                        <button class="btn btn-sm btn-secondary" id="copyRefreshTokenButton">Copy Refresh Token</button>
                    </div>
                </div>
            </div>
            
            <!-- Refresh Token Display -->
            <div id="refreshTokenSection" style="display: none;">
                <div class="mt-4">
                    <h5>Refresh Token:</h5>
                    <div class="token-display" id="refreshTokenDisplay"></div>
                </div>
            </div>
            
            <!-- Auth Response Area -->
            <div class="mt-4">
                <h5>Authentication Response:</h5>
                <div class="response-area" id="authResponse"></div>
            </div>
        </div>
        
        <ul class="nav nav-tabs" id="apiTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">Users API</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab">Products API</button>
            </li>
        </ul>
        
        <div class="tab-content" id="apiTabsContent">
            <!-- Users API Section -->
            <div class="tab-pane fade show active" id="users" role="tabpanel">
                <div class="api-section">
                    <h3>Users API</h3>
                    
                    <div class="form-group mb-3">
                        <label for="userEndpoint">Endpoint:</label>
                        <select class="form-control" id="userEndpoint">
                            <option value="api/users" data-method="GET">GET - All Users</option>
                            <option value="api/users/1" data-method="GET">GET - User Detail (ID: 1)</option>
                            <option value="api/users" data-method="POST">POST - New User</option>
                            <option value="api/users/1" data-method="PUT">PUT - Update User (ID: 1)</option>
                            <option value="api/users/1" data-method="DELETE">DELETE - Delete User (ID: 1)</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-3" id="userDataContainer">
                        <label for="userData">Request Data (JSON):</label>
                        <textarea class="form-control" id="userData" rows="5">
{
    "name": "John Doe",
    "email": "john.doe@example.com",
    "password": "123456"
}</textarea>
                    </div>
                    
                    <button class="btn btn-primary" id="sendUserRequest">Send Request</button>
                    
                    <div class="mt-4">
                        <h5>Response:</h5>
                        <div class="response-area" id="userResponse"></div>
                    </div>
                </div>
            </div>
            
            <!-- Products API Section -->
            <div class="tab-pane fade" id="products" role="tabpanel">
                <div class="api-section">
                    <h3>Products API</h3>
                    
                    <div class="form-group mb-3">
                        <label for="productEndpoint">Endpoint:</label>
                        <select class="form-control" id="productEndpoint">
                            <option value="api/products" data-method="GET">GET - All Products</option>
                            <option value="api/products/1" data-method="GET">GET - Product Detail (ID: 1)</option>
                            <option value="api/products" data-method="POST">POST - New Product</option>
                            <option value="api/products/1" data-method="PUT">PUT - Update Product (ID: 1)</option>
                            <option value="api/products/1" data-method="DELETE">DELETE - Delete Product (ID: 1)</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-3" id="productDataContainer">
                        <label for="productData">Request Data (JSON):</label>
                        <textarea class="form-control" id="productData" rows="5">
{
    "name": "Tablet",
    "description": "10-inch high-resolution tablet",
    "price": 3499.99,
    "stock": 30
}</textarea>
                    </div>
                    
                    <button class="btn btn-primary" id="sendProductRequest">Send Request</button>
                    
                    <div class="mt-4">
                        <h5>Response:</h5>
                        <div class="response-area" id="productResponse"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let jwtToken = localStorage.getItem('jwtToken') || '';
            let refreshToken = localStorage.getItem('refreshToken') || '';
            
            if (jwtToken) {
                document.getElementById('tokenDisplay').textContent = jwtToken;
                document.getElementById('tokenSection').style.display = 'block';
            }
            
            if (refreshToken) {
                document.getElementById('refreshTokenDisplay').textContent = refreshToken;
                document.getElementById('refreshTokenSection').style.display = 'block';
            }
            
            const userEndpoint = document.getElementById('userEndpoint');
            userEndpoint.addEventListener('change', function() {
                const method = this.options[this.selectedIndex].getAttribute('data-method');
                if (method === 'GET' || method === 'DELETE') {
                    document.getElementById('userDataContainer').style.display = 'none';
                } else {
                    document.getElementById('userDataContainer').style.display = 'block';
                }
            });
            
            const productEndpoint = document.getElementById('productEndpoint');
            productEndpoint.addEventListener('change', function() {
                const method = this.options[this.selectedIndex].getAttribute('data-method');
                if (method === 'GET' || method === 'DELETE') {
                    document.getElementById('productDataContainer').style.display = 'none';
                } else {
                    document.getElementById('productDataContainer').style.display = 'block';
                }
            });
            
            document.getElementById('loginButton').addEventListener('click', function() {
                const email = document.getElementById('loginEmail').value;
                const password = document.getElementById('loginPassword').value;
                
                fetch('/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('authResponse').textContent = JSON.stringify(data, null, 2);
                    
                    if (data.status === true) {
                        localStorage.setItem('jwtToken', data.data.token);
                        localStorage.setItem('refreshToken', data.data.refreshToken);
                        
                        jwtToken = data.data.token;
                        refreshToken = data.data.refreshToken;
                        
                        document.getElementById('tokenDisplay').textContent = jwtToken;
                        document.getElementById('refreshTokenDisplay').textContent = refreshToken;
                        document.getElementById('tokenSection').style.display = 'block';
                        document.getElementById('refreshTokenSection').style.display = 'block';
                    }
                })
                .catch(error => {
                    document.getElementById('authResponse').textContent = 'Error: ' + error.message;
                });
            });
            
            document.getElementById('viewProfileButton').addEventListener('click', function() {
                fetch('/api/auth/profile', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + jwtToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('authResponse').textContent = JSON.stringify(data, null, 2);
                })
                .catch(error => {
                    document.getElementById('authResponse').textContent = 'Error: ' + error.message;
                });
            });
            
            document.getElementById('refreshTokenButton').addEventListener('click', function() {
                fetch('/api/auth/refresh', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        refreshToken: refreshToken
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('authResponse').textContent = JSON.stringify(data, null, 2);
                    
                    if (data.status === true) {
                        jwtToken = data.data.token;
                        refreshToken = data.data.refreshToken;
                        
                        localStorage.setItem('jwtToken', jwtToken);
                        localStorage.setItem('refreshToken', refreshToken);
                        
                        document.getElementById('tokenDisplay').textContent = jwtToken;
                        document.getElementById('refreshTokenDisplay').textContent = refreshToken;
                    }
                })
                .catch(error => {
                    document.getElementById('authResponse').textContent = 'Error: ' + error.message;
                });
            });
            
            document.getElementById('copyRefreshTokenButton').addEventListener('click', copyRefreshToken);
            
            document.getElementById('sendUserRequest').addEventListener('click', function() {
                const endpoint = document.getElementById('userEndpoint').value;
                const method = document.getElementById('userEndpoint').options[document.getElementById('userEndpoint').selectedIndex].getAttribute('data-method');
                let body = null;
                
                if (method !== 'GET' && method !== 'DELETE') {
                    body = document.getElementById('userData').value;
                }
                
                sendApiRequest(endpoint, method, body, 'userResponse');
            });
            
            document.getElementById('copyTokenButton').addEventListener('click', copyToken);
            
            document.getElementById('sendProductRequest').addEventListener('click', function() {
                const endpoint = document.getElementById('productEndpoint').value;
                const method = document.getElementById('productEndpoint').options[document.getElementById('productEndpoint').selectedIndex].getAttribute('data-method');
                let body = null;
                
                if (method !== 'GET' && method !== 'DELETE') {
                    body = document.getElementById('productData').value;
                }
                
                sendApiRequest(endpoint, method, body, 'productResponse');
            });
            
            function sendApiRequest(endpoint, method, body, responseElementId) {
                const currentToken = localStorage.getItem('jwtToken');
                
                const options = {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + currentToken
                    }
                };
                
                if (body) {
                    options.body = body;
                }
                
                fetch('/' + endpoint, options)
                .then(response => response.json())
                .then(data => {
                    document.getElementById(responseElementId).textContent = JSON.stringify(data, null, 2);
                })
                .catch(error => {
                    document.getElementById(responseElementId).textContent = 'Error: ' + error.message;
                });
            }
            
            function copyToken() {
                navigator.clipboard.writeText(localStorage.getItem('jwtToken'))
                    .then(() => {
                        alert('Token copied!');
                    })
                    .catch(err => {
                        console.error('Could not copy token: ', err);
                    });
            }
            
            function copyRefreshToken() {
                navigator.clipboard.writeText(localStorage.getItem('refreshToken'))
                    .then(() => {
                        alert('Refresh token copied!');
                    })
                    .catch(err => {
                        console.error('Could not copy refresh token: ', err);
                    });
            }
        });
    </script>
</body>
</html>
