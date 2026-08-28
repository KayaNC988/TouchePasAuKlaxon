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
         $isOwner = (int) $trajet['auteur_id'] === (int) $_SESSION['user']['id'];

        require __DIR__ . '/../views/trajets/show.php';
    }
   
    public function edit(int $id): void
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

    if ((int) $trajet['auteur_id'] !== (int) $_SESSION['user']['id']) {
        http_response_code(403);
        echo "Vous n'êtes pas autorisé à modifier ce trajet.";
        return;
    }

    $stmt = $pdo->query('SELECT id, ville FROM agences ORDER BY ville');
    $agences = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    require __DIR__ . '/../views/trajets/edit.php';
}

   

    public function update(int $id): void
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

    if ((int) $trajet['auteur_id'] !== (int) $_SESSION['user']['id']) {
        http_response_code(403);
        echo "Vous n'êtes pas autorisé à modifier ce trajet.";
        return;
    }

    $agenceDepartId = (int) ($_POST['agence_depart_id'] ?? 0);
    $agenceArriveeId = (int) ($_POST['agence_arrivee_id'] ?? 0);
    $departAt = $_POST['depart_at'] ?? '';
    $arriveeAt = $_POST['arrivee_at'] ?? '';
    $placesTotal = (int) ($_POST['places_total'] ?? 0);

    if (
        $agenceDepartId < 1 ||
        $agenceArriveeId < 1 ||
        !$departAt ||
        !$arriveeAt ||
        $placesTotal < 1
    ) {
        $_SESSION['old'] = $_POST;
        $_SESSION['error'] = 'Veuillez remplir correctement tous les champs.';
        header("Location: /trajets/$id/edit");
        exit;
    }

    if ($agenceDepartId === $agenceArriveeId) {
        $_SESSION['old'] = $_POST;
        $_SESSION['error'] = "Les agences de départ et d'arrivée doivent être différentes.";
        header("Location: /trajets/$id/edit");
        exit;
    }

    if (strtotime($arriveeAt) <= strtotime($departAt)) {
        $_SESSION['old'] = $_POST;
        $_SESSION['error'] = "La date d'arrivée doit être postérieure à la date de départ.";
        header("Location: /trajets/$id/edit");
        exit;
    }

    $stmt = $pdo->prepare(
        'UPDATE trajets
         SET agence_depart_id = :agence_depart_id,
             agence_arrivee_id = :agence_arrivee_id,
             depart_at = :depart_at,
             arrivee_at = :arrivee_at,
             places_total = :places_total,
             places_disponibles = :places_disponibles
         WHERE id = :id
         AND auteur_id = :auteur_id'
    );

    $stmt->execute([
        'agence_depart_id' => $agenceDepartId,
        'agence_arrivee_id' => $agenceArriveeId,
        'depart_at' => $departAt,
        'arrivee_at' => $arriveeAt,
        'places_total' => $placesTotal,
        'places_disponibles' => $placesTotal,
        'id' => $id,
        'auteur_id' => (int) $_SESSION['user']['id'],
    ]);

    $_SESSION['success'] = 'Trajet modifié avec succès.';

    header("Location: /trajets/$id");
    exit;
}

public function delete(int $id): void
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

    if ((int) $trajet['auteur_id'] !== (int) $_SESSION['user']['id']) {
        http_response_code(403);
        echo "Vous n'êtes pas autorisé à supprimer ce trajet.";
        return;
    }

    $stmt = $pdo->prepare(
        'DELETE FROM trajets
         WHERE id = :id
         AND auteur_id = :auteur_id'
    );

    $stmt->execute([
        'id' => $id,
        'auteur_id' => (int) $_SESSION['user']['id'],
    ]);

    $_SESSION['success'] = 'Trajet supprimé avec succès.';

    header('Location: /');
    exit;
}

 public function create(): void
    {
        $_SESSION['success'] = 'Trajet créé avec succès.';

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
        $_SESSION['old'] = $_POST;
        $_SESSION['error'] = 'Veuillez remplir correctement tous les champs.';
        header('location: /trajets/create');
        exit;
    }

    if ($agenceDepartId === $agenceArriveeId) {
        $_SESSION['old'] = $_POST;
        $_SESSION['error'] = 'Les agences de départ et d’arrivée doivent être différentes.';
        header('location: /trajets/create');
        exit;
    }

    if (strtotime($arriveeAt) <= strtotime($departAt)) {
         $_SESSION['old'] = $_POST;
        $_SESSION['error'] = 'La date d’arrivée doit être postérieure à la date de départ.';
        header('location: /trajets/create');
        exit;
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

