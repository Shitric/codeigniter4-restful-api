<?php

namespace App\Controllers\Api;

use App\Models\ProductModel;

class Products extends BaseController
{
    protected $productModel;
    
    public function __construct()
    {
        $this->productModel = new ProductModel();
    }
    
    public function index()
    {
        $products = $this->productModel->findAll();
        
        return $this->successResponse($products, 'Products listed successfully');
    }

    public function show($id = null)
    {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        return $this->successResponse($product, 'Product retrieved successfully');
    }

    public function create()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
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
                'description' => $json->description ?? '',
                'price' => $json->price ?? 0,
                'stock' => $json->stock ?? 0
            ];
        } else {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price' => (float)$this->request->getPost('price'),
                'stock' => (int)$this->request->getPost('stock')
            ];
        }

        $productId = $this->productModel->insert($data);
        
        if (!$productId) {
            return $this->errorResponse('Failed to create product', 500);
        }
        
        $product = $this->productModel->find($productId);
        
        return $this->successResponse($product, 'Product created successfully', 201);
    }

    public function update($id = null)
    {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }
        
        $rules = [
            'name' => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
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
                'name' => $json->name ?? $product['name'],
                'description' => $json->description ?? $product['description'],
                'price' => $json->price ?? $product['price'],
                'stock' => $json->stock ?? $product['stock']
            ];
        } else {
            $data = [
                'name' => $this->request->getPost('name') ?? $product['name'],
                'description' => $this->request->getPost('description') ?? $product['description'],
                'price' => (float)($this->request->getPost('price') ?? $product['price']),
                'stock' => (int)($this->request->getPost('stock') ?? $product['stock'])
            ];
        }

        $this->productModel->update($id, $data);
        
        $updatedProduct = $this->productModel->find($id);
        
        return $this->successResponse($updatedProduct, 'Product updated successfully');
    }

    public function delete($id = null)
    {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }
        
        $this->productModel->delete($id);
        
        return $this->successResponse(null, 'Product deleted successfully');
    }
}
