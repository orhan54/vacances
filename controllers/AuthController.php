<?php

class AuthController
{
    public function welcome(): void
    {
        require_once __DIR__ . '/../views/auth/welcome.php';
    }
}