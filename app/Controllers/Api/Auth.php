<?php

namespace App\Controllers\Api;

use App\Libraries\JWTHandler;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->errorResponse($validation->getErrors(), 400);
        }

        // Get JSON data
        $json = $this->request->getJSON();
        
        if ($json) {
            $email = $json->email ?? '';
            $password = $json->password ?? '';
        } else {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
        }

        // Get user from database
        $user = $this->userModel->findUserByEmail($email);
        
        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            return $this->errorResponse('Invalid email or password', 401);
        }
        
        // Generate JWT token
        $jwtHandler = new JWTHandler();
        $token = $jwtHandler->generateToken($user['id'], $user['email'], $user['role']);
        $refreshToken = $jwtHandler->generateRefreshToken($user['id'], $user['email'], $user['role']);

        $userData = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'token' => $token,
            'refreshToken' => $refreshToken
        ];

        return $this->successResponse($userData, 'Login successful');
    }

    public function register()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->errorResponse($validation->getErrors(), 400);
        }

        // Get JSON data
        $json = $this->request->getJSON();
        
        if ($json) {
            $name = $json->name ?? '';
            $email = $json->email ?? '';
            $password = $json->password ?? '';
        } else {
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
        }

        // Check if email already exists
        $existingUser = $this->userModel->findUserByEmail($email);
        if ($existingUser) {
            return $this->errorResponse('Email already exists', 400);
        }

        // Save user to database
        $userId = $this->userModel->insert([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => 'user'
        ]);

        if (!$userId) {
            return $this->errorResponse('Failed to register user', 500);
        }

        $user = $this->userModel->find($userId);
        
        // Generate JWT token
        $jwtHandler = new JWTHandler();
        $token = $jwtHandler->generateToken($user['id'], $user['email'], $user['role']);
        $refreshToken = $jwtHandler->generateRefreshToken($user['id'], $user['email'], $user['role']);
        
        $userData = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'token' => $token,
            'refreshToken' => $refreshToken
        ];

        return $this->successResponse($userData, 'Registration successful', 201);
    }

    public function refresh()
    {
        $json = $this->request->getJSON();
        $refreshToken = $json->refreshToken ?? '';
        
        if (empty($refreshToken)) {
            return $this->errorResponse('Refresh token is required', 400);
        }
        
        $jwtHandler = new JWTHandler();
        $userData = $jwtHandler->validateRefreshToken($refreshToken);
        
        if (!$userData) {
            return $this->errorResponse('Invalid or expired refresh token', 401);
        }
        
        // Generate new tokens
        $token = $jwtHandler->generateToken($userData->userId, $userData->email, $userData->role);
        $newRefreshToken = $jwtHandler->generateRefreshToken($userData->userId, $userData->email, $userData->role);
        
        $tokenData = [
            'token' => $token,
            'refreshToken' => $newRefreshToken
        ];
        
        return $this->successResponse($tokenData, 'Token refreshed successfully');
    }

    public function profile()
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token = explode(' ', $header)[1] ?? '';
        
        if (empty($token)) {
            return $this->errorResponse('Invalid token format', 401);
        }
        
        $jwtHandler = new JWTHandler();
        $userData = $jwtHandler->validateToken($token);
        
        if (!$userData) {
            return $this->errorResponse('Invalid or expired token', 401);
        }
        
        // Get user data from database
        $user = $this->userModel->find($userData->userId);
        
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }
        
        $profileData = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        
        return $this->successResponse($profileData, 'Profile retrieved successfully');
    }
}
