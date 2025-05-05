<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'description', 'price', 'stock', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'description' => 'required|min_length[10]',
        'price' => 'required|numeric',
        'stock' => 'required|integer'
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Ürün adı zorunludur',
            'min_length' => 'Ürün adı en az 3 karakter olmalıdır'
        ],
        'description' => [
            'required' => 'Ürün açıklaması zorunludur',
            'min_length' => 'Ürün açıklaması en az 10 karakter olmalıdır'
        ],
        'price' => [
            'required' => 'Ürün fiyatı zorunludur',
            'numeric' => 'Ürün fiyatı sayısal bir değer olmalıdır'
        ],
        'stock' => [
            'required' => 'Stok miktarı zorunludur',
            'integer' => 'Stok miktarı tam sayı olmalıdır'
        ]
    ];
}
