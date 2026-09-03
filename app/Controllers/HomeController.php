<?php

namespace App\Controllers;

use App\Models\Trajet;
/**
 * Contrôleur chargé de la gestion de la page d'accueil.
 * 
 * Il récupère les trajets à venir disposant encore de places afin de les afficher sur la page d'accueil.
*/
class HomeController
{
    /**
     * Affiche la page d'accueil avec la liste des trajets à venir.
     * 
     * @return void
     */
    public function index(): void
    {
       require __DIR__ . '/../../config/database.php';

       $trajetModel = new Trajet($pdo);
       $trajets = $trajetModel->getUpcomingTrajets();

        require __DIR__ . '/../views/home.php';
    }
}