<?php

namespace App\Controllers\Api;

use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        $users = $this->userModel->findAll();
        
        return $this->successResponse($users, 'Users listed successfully');
    }

    public function show($id = null)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        return $this->successResponse($user, 'User retrieved successfully');
    }

    public function create()
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
            $data = [
                'name' => $json->name ?? '',
                'email' => $json->email ?? '',
                'password' => $json->password ?? '',
                'role' => $json->role ?? 'user'
            ];
        } else {
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'role' => $this->request->getPost('role') ?? 'user'
            ];
        }
        
        // Check if email already exists
        $existingUser = $this->userModel->findUserByEmail($data['email']);
        if ($existingUser) {
            return $this->errorResponse('Email already exists', 400);
        }

        $userId = $this->userModel->insert($data);
        
        if (!$userId) {
            return $this->errorResponse('Failed to create user', 500);
        }
        
        $user = $this->userModel->find($userId);
        
        return $this->successResponse($user, 'User created successfully', 201);
    }

    public function update($id = null)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }
        
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email'
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->errorResponse($validation->getErrors(), 400);
        }

        // Get JSON data
        $json = $this->request->getJSON();
        
        if ($json) {
            $data = [
                'name' => $json->name ?? $user['name'],
                'email' => $json->email ?? $user['email'],
                'role' => $json->role ?? $user['role']
            ];
        } else {
            $data = [
                'name' => $this->request->getPost('name') ?? $user['name'],
                'email' => $this->request->getPost('email') ?? $user['email'],
                'role' => $this->request->getPost('role') ?? $user['role']
            ];
        }
        
        // Check if email already exists
        if ($data['email'] !== $user['email']) {
            $existingUser = $this->userModel->findUserByEmail($data['email']);
            if ($existingUser) {
                return $this->errorResponse('Email already exists', 400);
            }
        }

        $this->userModel->update($id, $data);
        
        $updatedUser = $this->userModel->find($id);
        
        return $this->successResponse($updatedUser, 'User updated successfully');
    }

    public function delete($id = null)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }
        
        $this->userModel->delete($id);
        
        return $this->successResponse(null, 'User deleted successfully');
    }
}
