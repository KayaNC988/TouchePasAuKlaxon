<?php

namespace App\Controllers;

use PDO;
/**
 * Contrôleur chargé de la gestion de l'administration de l'application.
 * 
 * Il permet à l'administrateur de consulter la liste des utilisateurs, de gérer les agences et de gérer les trajets.
 */
class AdminController
{
    /**
     * Vérifie que l'utilisateur connecté possède le rôle d'administrateur.
     * 
     * Redirige vers la page d'accueil si l'utilisateur n'est pas connecté ou n'a pas le rôle d'administrateur.
     * 
     * @return void
     */
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
/**
 * Affiche la liste des utilisateurs de l'application.
 * 
 * @return void
 */
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
/**
 * Affiche la liste des agences de l'application.
 *
 * @return void
 */
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
/**
 * Affiche le formulaire de création d'une nouvelle agence.
 * 
 * @return void
 */
    public function createAgence(): void 
    {
         $this->checkAdmin();

         require __DIR__ . '/../views/admin/agences-create.php';
    }
/**
 * Enregistre une nouvelle agence dans la base de données.
 * 
 * Vérifie que le nom de la ville a bien été renseigné avant d'effectuer l'insertion de l'agence.
 * 
 * @return void
 */
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
/**
 * Affiche le formulaire de modification d'une agence existante.
 * 
 * @param int $id L'identifiant de l'agence à modifier.
 * @return void
 */
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
/**
 * Met à jour les informations d'une agence existante dans la base de données.
 * 
 * Vérifie que le nom de la ville a bien été renseigné avant d'enregistrer les modifications dans la base de données.
 * 
 * @param int $id L'identifiant de l'agence à modifier.
 * @return void
 */
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

/**
 * Supprime une agence de la base de données.
 *
 * Vérifie que l'agence n'est pas utilisée par un trajet avant de procéder à la suppression.
 * 
 * @param int $id L'identifiant de l'agence à supprimer.
 * @return void
 */
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
/**
 * Affiche la liste des trajets dans l'espace administrateur.
 *
 * Récupère les informations des trajets, des agences de départ et d'arrivée ainsi que l'identité de leur auteur.
 * 
 * @return void
 */
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
/**
 * Supprime un trajet depuis l'espace administrateur.
 *
 * @param int $id L'identifiant du trajet à supprimer.
 * @return void
 */
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