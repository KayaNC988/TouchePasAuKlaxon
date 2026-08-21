<?php

namespace APP\Models;

use PDO;

class Trajet
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUpcomingTrajets(): array
    {             
        $sql ="
             SELECT 
                  trajets.*, 
                  depart.ville AS ville_depart,
                  arrivee.ville AS ville_arrivee
             FROM trajets
             INNER JOIN agences AS depart 
                    ON trajets.agence_depart_id = depart.id
             INNER JOIN agences AS arrivee
                    ON trajets.agence_arrivee_id = arrivee.id
             WHERE trajets.depart_at > NOW()
             AND trajets.places_disponibles > 0
             ORDER BY trajets.depart_at ASC
            ";

        $stmt = $this->pdo->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array|false
    {
        $sql = "
            SELECT 
                  trajets.*, 
                  depart.ville AS ville_depart,
                  arrivee.ville AS ville_arrivee,
                  users.nom AS auteur_nom,
                  users.prenom AS auteur_prenom,
                  users.telephone AS auteur_telephone,
                  users.email AS auteur_email
             FROM trajets
             INNER JOIN agences AS depart 
                    ON trajets.agence_depart_id = depart.id
             INNER JOIN agences AS arrivee
                    ON trajets.agence_arrivee_id = arrivee.id
                INNER JOIN users
                    ON trajets.auteur_id = users.id
             WHERE trajets.id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}