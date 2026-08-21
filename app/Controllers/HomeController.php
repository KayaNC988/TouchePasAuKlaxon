<?php

namespace App\Controllers;

use App\Models\Trajet;

class HomeController
{
    public function index(): void
    {
       require __DIR__ . '/../../config/database.php';

       $trajetModel = new Trajet($pdo);
       $trajets = $trajetModel->getUpcomingTrajets();

        require __DIR__ . '/../views/home.php';
    }
}