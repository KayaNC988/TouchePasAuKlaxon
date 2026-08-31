<?php require __DIR__ . '/partials/header.php'; ?>

<main class="container my-5">

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

    <?php if (isset($_SESSION['user'])): ?>
        <h2 class="mb-4 text-secondary">
            Trajets proposés
        </h2>
    <?php else: ?>
        <h2 class="mb-4 text-secondary">
            Veuillez vous connecter pour consulter les détails des trajets
        </h2>
    <?php endif; ?>

    <table class="table table-striped">

        <thead class="table-primary">
            <tr>
                <th scope="col">Ville de départ</th>
                <th scope="col">Date de départ</th>
                <th scope="col">Heure de départ</th>
                <th scope="col">Ville d'arrivée</th>
                <th scope="col">Date d'arrivée</th>
                <th scope="col">Heure d'arrivée</th>
                <th scope="col">Places disponibles</th>

                <?php if (isset($_SESSION['user'])): ?>
                    <th scope="col">Action</th>
                <?php endif; ?>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($trajets as $trajet): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($trajet['ville_depart']) ?>
                    </td>

                    <td>
                        <?= date(
                            'd/m/Y',
                            strtotime($trajet['depart_at'])
                        ) ?>
                    </td>

                    <td>
                        <?= date(
                            'H:i',
                            strtotime($trajet['depart_at'])
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($trajet['ville_arrivee']) ?>
                    </td>

                    <td>
                        <?= date(
                            'd/m/Y',
                            strtotime($trajet['arrivee_at'])
                        ) ?>
                    </td>

                    <td>
                        <?= date(
                            'H:i',
                            strtotime($trajet['arrivee_at'])
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            (string) $trajet['places_disponibles']
                        ) ?>
                    </td>

                    <?php if (isset($_SESSION['user'])): ?>

                        <td>
                            <div class="d-flex gap-2 flex-wrap">

                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#trajetModal<?= (int) $trajet['id'] ?>"
                                >
                                    Voir les détails
                                </button>

                                <?php if (
                                    (int) $trajet['auteur_id']
                                    === (int) $_SESSION['user']['id']
                                ): ?>

                                    <a
                                        href="/trajets/<?= (int) $trajet['id'] ?>/edit"
                                        class="btn btn-outline-primary btn-sm"
                                    >
                                        Modifier
                                    </a>

                                    <form
                                        method="POST"
                                        action="/trajets/<?= (int) $trajet['id'] ?>/delete"
                                        class="d-inline"
                                    >
                                        <button
                                            type="submit"
                                            class="btn btn-outline-danger btn-sm"
                                        >
                                            Supprimer
                                        </button>
                                    </form>

                                <?php endif; ?>

                            </div>
                        </td>

                    <?php endif; ?>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>


    <?php if (isset($_SESSION['user'])): ?>

        <?php foreach ($trajets as $trajet): ?>

            <div
                class="modal fade"
                id="trajetModal<?= (int) $trajet['id'] ?>"
                tabindex="-1"
                aria-labelledby="trajetModalLabel<?= (int) $trajet['id'] ?>"
                aria-hidden="true"
            >

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5
                                class="modal-title"
                                id="trajetModalLabel<?= (int) $trajet['id'] ?>"
                            >
                                Détails du trajet
                            </h5>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Fermer"
                            ></button>

                        </div>

                        <div class="modal-body">

                            <p>
                                <strong>Conducteur :</strong>
                                <?= htmlspecialchars($trajet['auteur_prenom']) ?>
                                <?= htmlspecialchars($trajet['auteur_nom']) ?>
                            </p>

                            <p>
                                <strong>Téléphone :</strong>
                                <?= htmlspecialchars($trajet['auteur_telephone']) ?>
                            </p>

                            <p>
                                <strong>Email :</strong>
                                <?= htmlspecialchars($trajet['auteur_email']) ?>
                            </p>

                            <p>
                                <strong>Nombre total de places :</strong>
                                <?= htmlspecialchars(
                                    (string) $trajet['places_total']
                                ) ?>
                            </p>

                        </div>

                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Fermer
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</main>
<script>
    const flashMessage = document.getElementById('flash-message');

    if (flashMessage) {
        setTimeout (() => {
            flashMessage.remove();
        }, 10000);
    }
    </script>
<?php require __DIR__ . '/partials/footer.php'; ?>