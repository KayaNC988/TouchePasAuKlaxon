<?php

namespace App\Models;

use PDO;
/**
 * Modèle chargé de la gestion des trajets.
 * 
 * Permet de récupérer les trajets enregistrés dans la base de données.
 */
class Trajet
{
    private PDO $pdo;
/**
 * Initialise le mdèle avec la connexion à la base de données.
 * 
 * @param PDO $pdo La connexion à la base de données.
 */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
/**
 * Récupère les trajets à venir disposant encore de places.
 * 
 * Les trajets sont triés par date et heure de départ croissante.
 * 
 * @return array La liste des trajets disponibles à venir.
 */
    public function getUpcomingTrajets(): array
    {             
        $sql ="
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
             WHERE trajets.depart_at > NOW()
             AND trajets.places_disponibles > 0
             ORDER BY trajets.depart_at ASC
            ";

        $stmt = $this->pdo->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
/**
 * Récupère un trajet à partir de son identifiant.
 * 
 * Retourne les informations du trajet ainsi que les informations de l'agence de départ, de l'agence d'arrivée et de l'auteur du trajet.
 * 
 * @param int $id L'identifiant du trajet à récupérer.
 * @return array|false Les informations du trajet ou false si le trajet n'existe pas
 */
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