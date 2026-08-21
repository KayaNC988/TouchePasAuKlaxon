<?php

$shost = 'localhost';
$dbname = 'touche_pas_au_klaxon';
$username = 'root';
$dbPassword = '';

try {
    $pdo = new PDO("mysql:host=$shost;dbname=$dbname;charset=utf8mb4",
     $username, 
     $dbPassword
     );

     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}