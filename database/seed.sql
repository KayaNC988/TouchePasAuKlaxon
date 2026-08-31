Use touche_pas_au_klaxon;


INSERT INTO agences (ville) VALUES
('Paris'),
('Lyon'),
('Marseille'),
('Toulouse'),
('Nice'),
('Nantes'),
('Strasbourg'),
('Montpellier'),
('Bordeaux'),
('Lille'),
('Rennes'),
('Reims');




SET @password_test = '$2y$10$GC8RgrHdBd.K.FT2TjSkDON5RMDdNtAJnPZQ5VjjZjBDz63urF0Xm';

INSERT INTO users (nom, prenom, telephone, email, password, role) VALUES
('Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', @password_test, 'user'),
('Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', @password_test, 'user'),
('Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', @password_test, 'user'),
('Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', @password_test, 'user'),
('Lefevre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', @password_test, 'user'),
('Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', @password_test, 'user'),
('Roux', 'Chloe', '0633221199', 'chloe.roux@email.fr', @password_test, 'user'),
('Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', @password_test, 'user'),
('Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', @password_test, 'user'),
('Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', @password_test, 'user'),
('Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', @password_test, 'user'),
('Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', @password_test, 'user'),
('Chevallier', 'Clara', '0788990011', 'clara.chevallier@email.fr', @password_test, 'user'),
('Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', @password_test, 'user'),
('Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', @password_test, 'user'),
('Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', @password_test, 'user'),
('Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', @password_test, 'user'),
('Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', @password_test, 'user'),
('Masson', 'Julie', '0733445566', 'julie.masson@email.fr', @password_test, 'user'),
('Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', @password_test, 'user'),
('Administrateur', 'klaxon', '060000000', 'admin@klaxon.fr', @password_test, 'admin');


INSERT INTO trajets (
    agence_depart_id,
    agence_arrivee_id,
    depart_at,
    arrivee_at,
    places_total,
    places_disponibles,
    auteur_id
) VALUES (
    1,
    2,
    '2026-08-20 08:00:00',
    '2026-08-20 12:00:00',
    4,
    4,
    1
);