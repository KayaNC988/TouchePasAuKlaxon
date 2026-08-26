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

public function store(): void
{
    if (!isset($_SESSION['user'])) {
        header('Location: /login');
        exit;
    }

    $agenceDepartId = $_POST['agence_depart_id'] ?? null;
    $agenceArriveeId = $_POST['agence_arrivee_id'] ?? null;
    $departAt = $_POST['depart_at'] ?? '';
    $arriveeAt = $_POST['arrivee_at'] ?? '';
    $placesTotal = (int) ($_POST['places_total'] ?? 0);



    if (
        !$agenceDepartId ||
        !$agenceArriveeId ||
        !$departAt ||
        !$arriveeAt ||
        $placesTotal < 1
    ) {
        echo 'Veuillez remplir correctement tous les champs.';
        return;
    }

    if ($agenceDepartId === $agenceArriveeId) {
        echo 'Les agences de départ et d’arrivée doivent être différentes.';
        return;
    }

    if (strtotime($arriveeAt) <= strtotime($departAt)) {
        echo 'La date d’arrivée doit être postérieure à la date de départ.';
        return;
    }

    require __DIR__ . '/../../config/database.php';

    $stmt = $pdo->prepare(
        'INSERT INTO trajets (
            agence_depart_id,
            agence_arrivee_id,
            depart_at,
            arrivee_at,
            places_total,
            places_disponibles,
            auteur_id
        ) VALUES (
            :agence_depart_id,
            :agence_arrivee_id,
            :depart_at,
            :arrivee_at,
            :places_total,
            :places_disponibles,
            :auteur_id
        )'
    );

    $stmt->execute([
        'agence_depart_id' => $agenceDepartId,
        'agence_arrivee_id' => $agenceArriveeId,
        'depart_at' => $departAt,
        'arrivee_at' => $arriveeAt,
        'places_total' => $placesTotal,
        'places_disponibles' => $placesTotal,
        'auteur_id' => $_SESSION['user']['id'],
    ]);

    header('Location: /');
    exit;
}
}

