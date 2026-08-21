<?php

namespace App\Controllers;

class TrajetController
{
    public function show(int $id): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        require __DIR__ . '/../../config/database.php';
        $trajetModel = new \App\Models\Trajet($pdo);
        $trajet = $trajetModel->findById($id);

        if (!$trajet) {
            http_response_code(404);
            echo "Trajet non trouvé.";
            return;
        }

        require __DIR__ . '/../views/trajets/show.php';
    }
   
    public function create(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        require __DIR__ . '/../../config/database.php';

        $stmt = $pdo->query("SELECT id, ville FROM agences ORDER BY ville ASC");
        $agences = $stmt->fetchALL(\PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/trajets/create.php';
    }

}