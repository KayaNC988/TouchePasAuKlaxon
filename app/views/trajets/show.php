<?php

require __DIR__ . '/../partials/header.php'; ?>

<main class="container mt-4">

   <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success mb-4" id="flash-message" role="alert">
            <?= htmlspecialchars($_SESSION['success']) ?>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="fermer">
    </button>
        </div>

        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
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

        <?php if ($isOwner): ?>
            <div class="d-flex gap-2 mt-4">
                <a href="/trajets/<?= (int) $trajet['id'] ?>/edit"
                   class="btn btn-primary">Modifier</a>
                   <form method="POST"
                         action="/trajets/<?= (int) $trajet['id'] ?>/delete">
                         <button type="submit"
                                  class="btn btn-outline-danger">
                                  Supprimer</button>
        </form>
        </div>
        <?php endif; ?>               

        </div>
    </div>
    </main>
<script>
    const flashMessage = document.getElementById('flash-message');

    if (flashMessage) {
        setTimeout (() => {
            flashMessage.remove();
        }, 10000);
    }
    </script>
    <?php require __DIR__ . '/../partials/footer.php'; ?>

