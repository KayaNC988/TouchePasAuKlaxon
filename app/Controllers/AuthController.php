<?php

namespace App\Controllers;
use PDO;

/**
 * * Contrôleur chargé de la gestion de l'authentification des utilisateurs.
 * 
 * Il permet de gérer la connexion, la déconnexion et l'affichage du formulaire de connexion.
 */
class AuthController
{                   
/**
 * Affiche le formulaire de connexion.
 * 
 * @return void
 */
   public function showLogin(): void
 {
     require __DIR__ . '/../views/login.php';
 }

/**
 * Authentifie un utilisateur à partir de son email et de son mot de passe.
 * 
 * En cas de succés, les informations de l'utilisateur sont enregistrés dans la session et l'utilisateur est redirigé vers la page d'accueil.
 * 
 * @return void
 */
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
/**
 * Déconnecte l'utilisateur actuellement connecté.
 *
 * Supprime les données de session puis redirige l'utilisateur vers la page d'accueil.
 * 
 * @return void
 */
    public function logout(): void
    {
        session_unset();
        session_destroy();

        header('Location: /');
        exit;
    }
}