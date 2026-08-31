<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="container mt-4">

    <h1 class="mb-4">Gestion des trajets</h1>

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

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Départ</th>
                    <th>Date de départ</th>
                    <th>Heure</th>
                    <th>Arrivée</th>
                    <th>Date d'arrivée</th>
                    <th>Heure</th>
                    <th>Places</th>
                    <th>Conducteur</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($trajets as $trajet): ?>
                    <tr>
                        <td><?= htmlspecialchars($trajet['ville_depart']) ?></td>

                        <td>
                            <?= date('d/m/Y', strtotime($trajet['depart_at'])) ?>
                        </td>

                        <td>
                            <?= date('H:i', strtotime($trajet['depart_at'])) ?>
                        </td>

                        <td><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>

                        <td>
                            <?= date('d/m/Y', strtotime($trajet['arrivee_at'])) ?>
                        </td>

                        <td>
                            <?= date('H:i', strtotime($trajet['arrivee_at'])) ?>
                        </td>

                        <td>
                            <?= (int) $trajet['places_disponibles'] ?>
                            /
                            <?= (int) $trajet['places_total'] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $trajet['auteur_prenom'] . ' ' . $trajet['auteur_nom']
                            ) ?>
                        </td>
                        <td>
                            <form action="/admin/trajets/<?= (int) $trajet['id'] ?>/delete"
                            method="POST"
                            class="m-0"
                            onsubmit="return confirm('Voulez-vous vraiment supprimer ce trajet ?');">
                            <button type="submit"
                                    class="btn btn-danger btn-sm">Supprimer</button>
                </form>
                </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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