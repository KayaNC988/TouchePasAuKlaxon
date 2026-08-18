CREATE DATABASE IF NOT EXISTS touche_pas_au_klaxon
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE touche_pas_au_klaxon;

CREATE TABLE agences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ville VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user'
);

CREATE TABLE trajets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agence_depart_id INT NOT NULL,
    agence_arrivee_id INT NOT NULL,
    depart_at DATETIME NOT NULL,
    arrivee_at DATETIME NOT NULL,
    places_total INT NOT NULL,
    places_disponibles INT NOT NULL,
    auteur_id INT NOT NULL,


FOREIGN KEY (agence_depart_id) REFERENCES agences(id),
FOREIGN KEY (agence_arrivee_id) REFERENCES agences(id),
FOREIGN KEY (auteur_id) REFERENCES users(id)
);