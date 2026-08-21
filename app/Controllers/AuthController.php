<?php

namespace App\Controllers;
use PDO;

class AuthController
{                   

   public function showLogin(): void
 {
     require __DIR__ . '/../views/login.php';
 }


    public function Login(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        require __DIR__ . '/../../config/database.php';

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user && password_verify($password, $user['password'])) {
            

            $_SESSION['user'] = [
                'id' => $user['id'],
                'nom' => $user['nom'],
                'prenom' => $user['prenom'],
                'email' => $user['email'],
                'telephone' => $user['telephone'],
                'role' => $user['role']
            ];

            header('Location: /');
            exit;
        } else {
            echo "Adresse e-mail ou mot de passe incorrect.";
        }
       
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();

        header('Location: /');
        exit;
    }
}