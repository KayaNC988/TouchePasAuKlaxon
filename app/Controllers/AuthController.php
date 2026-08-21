<?php

namespace App\Controllers;

class AuthController
{
    public function showLogin(): void
    {

        require __DIR__ . '/../views/login.php';
    }
}