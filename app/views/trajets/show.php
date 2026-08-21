<?php

require __DIR__ . '/../partials/header.php'; ?>

<main class="container mt-4">
    <h2 class="mb-4 text-secondary">Détails du trajet</h2>

    <div class=card>
        <div class="card-body">

        <p><strong>Depart:</strong> <?= htmlspecialchars($trajet['ville_depart']) ?></p>
        <p><strong>Arrivée:</strong> <?= htmlspecialchars($trajet['ville_arrivee']) ?></p>
        <p><strong>Date de départ:</strong> <?= htmlspecialchars($trajet['depart_at']) ?></p>
        <p><strong>Date d'arrivée:</strong> <?= htmlspecialchars($trajet['arrivee_at']) ?></p>
        <p><strong>Places disponibles:</strong> <?= htmlspecialchars($trajet['places_disponibles']) ?></p>

        <hr>

        <h5 class="mt-4">Auteur du trajet</h5>
        <p><strong>Nom:</strong> <?= htmlspecialchars($trajet['auteur_nom']) ?></p>
        <p><strong>Prénom:</strong> <?= htmlspecialchars($trajet['auteur_prenom']) ?></p>
        <p><strong>Téléphone:</strong> <?= htmlspecialchars($trajet['auteur_telephone']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($trajet['auteur_email']) ?></p>
        <p><strong>Nombre total de places :</strong> <?= htmlspecialchars($trajet['places_total']) ?></p>
        </div>
    </div>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>

