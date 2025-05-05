<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTHandler
{
    private $key;
    private $algorithm;
    private $accessTokenLifetime;
    private $refreshTokenLifetime;

    public function __construct()
    {
        $this->key = getenv('JWT_SECRET');
        $this->algorithm = getenv('JWT_ALGORITHM') ?: 'HS256';
        $this->accessTokenLifetime = getenv('JWT_ACCESS_TIME') ? (int)getenv('JWT_ACCESS_TIME') : 3600; // 1 hour
        $this->refreshTokenLifetime = getenv('JWT_REFRESH_TIME') ? (int)getenv('JWT_REFRESH_TIME') : 604800; // 7 days
    }

    public function generateToken($userId, $email, $role)
    {
        $issuedAt = time();
        $expire = $issuedAt + $this->accessTokenLifetime;

        $payload = [
            'iss' => getenv('JWT_ISSUER') ?: 'CodeIgniter 4 API Project',
            'aud' => getenv('JWT_AUDIENCE') ?: 'API Users',
            'iat' => $issuedAt,
            'exp' => $expire,
            'data' => [
                'userId' => $userId,
                'email' => $email,
                'role' => $role
            ]
        ];

        return JWT::encode($payload, $this->key, $this->algorithm);
    }

    public function generateRefreshToken($userId, $email, $role)
    {
        $issuedAt = time();
        $expire = $issuedAt + $this->refreshTokenLifetime;

        $payload = [
            'iss' => getenv('JWT_ISSUER') ?: 'CodeIgniter 4 API Project',
            'aud' => getenv('JWT_AUDIENCE') ?: 'API Users',
            'iat' => $issuedAt,
            'exp' => $expire,
            'data' => [
                'userId' => $userId,
                'email' => $email,
                'role' => $role
            ],
            'type' => 'refresh'
        ];

        return JWT::encode($payload, $this->key, $this->algorithm);
    }

    public function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->key, $this->algorithm));
            return $decoded->data;
        } catch (Exception $e) {
            return false;
        }
    }

    public function validateRefreshToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->key, $this->algorithm));
        
            // Check refresh token type
            if (!isset($decoded->type) || $decoded->type !== 'refresh') {
                return false;
            }
        
            return $decoded->data;
        } catch (Exception $e) {
            return false;
        }
    }
}
