<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    private $secretKey = 'sua_chave_secreta';
    private $tokenExpiryTime = 31536000; // 1 ano em segundos

    public function generateToken()
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + $this->tokenExpiryTime;

        // Dados que você deseja incluir no token
        $data = [
            'user_id' => 123,
            'username' => 'joao',
            'exp' => $expirationTime
        ];

        $token = JWT::encode($data, $this->secretKey, 'HS256');

        return $token;
    }

    public function checkToken($token)
    {
        try {

            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));

            // Verifica se o token expirou
            $now = time();
            if ($decoded->exp < $now) {
                return false;
            }

            // Se o token não expirou, retorna o payload (dados) do token
            return true;
        } catch (\Exception $e) {
            print_r($e);
            // Algum erro ocorreu ao decodificar o token
            return false;
        }
    }
}
