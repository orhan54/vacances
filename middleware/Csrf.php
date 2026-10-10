<?php

class Csrf
{
    public static function generateToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function getToken()
    {
        return self::generateToken();
    }


    public static function validateToken($token): bool
    {
        return isset($_SESSION['csrf_token'])
            && is_string($_SESSION['csrf_token'])
            && is_string($token)
            && $_SESSION['csrf_token'] !== ''
            && $token !== ''
            && hash_equals($_SESSION['csrf_token'], $token);
    }


}