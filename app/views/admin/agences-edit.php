<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="container mt-4">

    <h1 class="mb-4">Modifier une agence</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form
        action="/admin/agences/<?= (int) $agence['id'] ?>/edit"
        method="POST"
    >

        <div class="mb-3">
            <label for="ville" class="form-label">Ville</label>

            <input
                type="text"
                class="form-control"
                id="ville"
                name="ville"
                value="<?= htmlspecialchars($agence['ville']) ?>"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Enregistrer les modifications
        </button>

        <a href="/admin/agences" class="btn btn-secondary">
            Annuler
        </a>

    </form>

</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>