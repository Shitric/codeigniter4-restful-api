<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\JWTHandler;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeaderLine('Authorization');
        
        if (empty($header)) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Authorization header not found',
                    'data' => null
                ]);
        }
        
        $token = explode(' ', $header)[1] ?? '';
        
        if (empty($token)) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Invalid token format',
                    'data' => null
                ]);
        }
        
        $jwtHandler = new JWTHandler();
        $userData = $jwtHandler->validateToken($token);
        
        if (!$userData) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Invalid or expired token',
                    'data' => null
                ]);
        }
        
        // Add user data to session for later use
        session()->set('user_data', $userData);
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing after the request
    }
}
