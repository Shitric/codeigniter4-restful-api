<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'email', 'password', 'role', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'role' => 'required|in_list[admin,user]'
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'İsim alanı zorunludur',
            'min_length' => 'İsim en az 3 karakter olmalıdır'
        ],
        'email' => [
            'required' => 'E-posta alanı zorunludur',
            'valid_email' => 'Geçerli bir e-posta adresi giriniz',
            'is_unique' => 'Bu e-posta adresi zaten kullanılıyor'
        ],
        'password' => [
            'required' => 'Şifre alanı zorunludur',
            'min_length' => 'Şifre en az 6 karakter olmalıdır'
        ],
        'role' => [
            'required' => 'Rol alanı zorunludur',
            'in_list' => 'Rol admin veya user olmalıdır'
        ]
    ];
    
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }
        
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        
        return $data;
    }
    
    public function findUserByEmail($email)
    {
        return $this->where('email', $email)
                    ->first();
    }
    
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
