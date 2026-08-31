<?php

namespace App\Controllers;

use PDO;

class AdminController
{
    private function checkAdmin(): void
    {
        if (
            !isset($_SESSION['user'])
            || ($_SESSION['user']['role'] ?? '') !== 'admin'
        ) {
            header('Location: /');
            exit;
        }
    }

    public function users(): void
    {
        $this->checkAdmin();

        require __DIR__ . '/../../config/database.php';

        $stmt = $pdo->query(
            'SELECT id, nom, prenom, telephone, email, role
             FROM users
             ORDER BY nom ASC, prenom ASC'
        );

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/admin/users.php';
    }

    public function agences(): void 
    {
        $this->checkAdmin();

        require __DIR__ . '/../../config/database.php';

        $stmt = $pdo->query(
           'SELECT id, ville
            FROM agences
            ORDER BY ville ASC'
        );

        $agences = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/admin/agences.php';
    }

    public function createAgence(): void 
    {
         $this->checkAdmin();

         require __DIR__ . '/../views/admin/agences-create.php';
    }

    public function storeAgence(): void
{
    $this->checkAdmin();

    $ville = trim($_POST['ville'] ?? '');

    if ($ville === '') {
        $_SESSION['error'] = 'Le nom de la ville est obligatoire.';
        header('Location: /admin/agences/create');
        exit;
    }

    require __DIR__ . '/../../config/database.php';

    $stmt = $pdo->prepare(
        'INSERT INTO agences (ville) VALUES (:ville)'
    );

    $stmt->execute([
        'ville' => $ville
    ]);

    $_SESSION['success'] = 'Agence créée avec succès.';

    header('Location: /admin/agences');
    exit;
}

public function editAgence(int $id): void
{
    $this->checkAdmin();

    require __DIR__ . '/../../config/database.php';

    $stmt = $pdo->prepare(
        'SELECT id, ville
         FROM agences
         WHERE id = :id'
    );

    $stmt->execute([
        'id' => $id
    ]);

    $agence = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$agence) {
        header('Location: /admin/agences');
        exit;
    }

    require __DIR__ . '/../views/admin/agences-edit.php';
}

public function updateAgence(int $id): void
{
    $this->checkAdmin();

    $ville = trim($_POST['ville'] ?? '');

    if ($ville === '') {
        $_SESSION['error'] = 'Le nom de la ville est obligatoire.';
        header('Location: /admin/agences/' . $id . '/edit');
        exit;
    }

    require __DIR__ . '/../../config/database.php';

    $stmt = $pdo->prepare(
        'UPDATE agences
         SET ville = :ville
         WHERE id = :id'
    );

    $stmt->execute([
        'ville' => $ville,
        'id' => $id
    ]);

    $_SESSION['success'] = 'Agence modifiée avec succès.';

    header('Location: /admin/agences');
    exit;
}

public function deleteAgence(int $id): void
{
    $this->checkAdmin();

    require __DIR__ . '/../../config/database.php';

    $stmt = $pdo->prepare(
        'SELECT COUNT(*)
         FROM trajets
         WHERE agence_depart_id = :id
            OR agence_arrivee_id = :id'
    );

    $stmt->execute([
        'id' => $id
    ]);

    $trajetsAssocies = (int) $stmt->fetchColumn();

    if ($trajetsAssocies > 0) {
        $_SESSION['error'] =
            'Impossible de supprimer cette agence car elle est utilisée par un trajet.';

        header('Location: /admin/agences');
        exit;
    }

    $stmt = $pdo->prepare(
        'DELETE FROM agences
         WHERE id = :id'
    );

    $stmt->execute([
        'id' => $id
    ]);

    $_SESSION['success'] = 'Agence supprimée avec succès.';

    header('Location: /admin/agences');
    exit;
}

    public function trajets(): void
{
    $this->checkAdmin();

    require __DIR__ . '/../../config/database.php';

    $stmt = $pdo->query(
        'SELECT
            trajets.id,
            depart.ville AS ville_depart,
            arrivee.ville AS ville_arrivee,
            trajets.depart_at,
            trajets.arrivee_at,
            trajets.places_total,
            trajets.places_disponibles,
            users.nom AS auteur_nom,
            users.prenom AS auteur_prenom
        FROM trajets
        INNER JOIN agences AS depart
            ON trajets.agence_depart_id = depart.id
        INNER JOIN agences AS arrivee
            ON trajets.agence_arrivee_id = arrivee.id
        INNER JOIN users
            ON trajets.auteur_id = users.id
        ORDER BY trajets.depart_at ASC'
    );

    $trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    require __DIR__ . '/../views/admin/trajets.php';
}

public function deleteTrajet(int $id): void
{
    $this->checkAdmin();

    require __DIR__ . '/../../config/database.php';

    $stmt = $pdo->prepare(
        'DELETE FROM trajets
         WHERE id = :id'
    );

    $stmt->execute([
        'id' => $id
    ]);

    $_SESSION['success'] = 'Trajet supprimé avec succès.';

    header('Location: /admin/trajets');
    exit;
}
}