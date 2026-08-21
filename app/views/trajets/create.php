<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="container mt-4">
    <h2 class="mb-4 text-secondary">Proposer un trajet</h2>

    <form method="POST" action="/trajets/create">

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Vos informations</h5>

            <p><strong>Nom:</strong> <?= htmlspecialchars($_SESSION['user']['nom']) ?></p>
            <p><strong>Prénom:</strong> <?= htmlspecialchars($_SESSION['user']['prenom']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
            <p><strong>téléphone:</strong> <?= htmlspecialchars($_SESSION['user']['telephone']) ?></p>
        </div>

        <div class="mb-3">
            <label for="agence_depart_id" class="form-label">Agence de départ</label>

            <select
            name="agence_depart_id"
            id="agence_depart_id"
            class="form-select"
            required>

            <option value="">Choisir une agence</option>

            <?php foreach ($agences as $agence): ?>
                <option value="<?htmlspecialchars((string) $agence['id']) ?>">
                    <?= htmlspecialchars($agence['ville']) ?>
            </option>
            <?php endforeach; ?>
            </select>
            </div>

            <div class="mb-3">
    <label for="agence_arrivee_id" class="form-label">Agence d'arrivée</label>

    <select
        name="agence_arrivee_id"
        id="agence_arrivee_id"
        class="form-select"
        required
    >
        <option value="">Choisir une agence</option>

        <?php foreach ($agences as $agence): ?>
            <option value="<?= htmlspecialchars((string) $agence['id']) ?>">
                <?= htmlspecialchars($agence['ville']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="mb-3">
    <label for="depart_at" class="form-label">Date et heure de départ</label>
    <input
        type="datetime-local"
        name="depart_at"
        id="depart_at"
        class="form-control"
        required
    >
</div>

<div class="mb-3">
    <label for="arrivee_at" class="form-label">Date et heure d'arrivée</label>
    <input
        type="datetime-local"
        name="arrivee_at"
        id="arrivee_at"
        class="form-control"
        required
    >
</div>

<div class="mb-3">
    <label for="places_total" class="form-label">
        Nombre total de places
    </label>

    <input
        type="number"
        name="places_total"
        id="places_total"
        class="form-control"
        min="1"
        required
    >
</div>

<div clas="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        Proposer le trajet
        </button>

        <a href="/" class=btn btn-secondary">
        Annuler
        </a>
        </div>
    </div>

    </form>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>