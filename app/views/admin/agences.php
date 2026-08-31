<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="container mt-4">

    <h1 class="mb-4">Gestion des agences</h1>
    
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

    <?php if (isset($_SESSION['error'])): ?>
    <div
        class="alert alert-danger alert-dismissible fade show"
        id="flash-error"
        role="alert"
    >
        <?= htmlspecialchars($_SESSION['error']) ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Fermer"
        ></button>
    </div>

    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

    <div class="mb-3">
        <a href="/admin/agences/create" class="btn btn-primary">
            créer une agence
</a>
</div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Ville</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($agences as $agence): ?>
                    <tr>
                        <td><?= htmlspecialchars($agence['ville']) ?></td>
                        <td>
                            <div class="d-flex gap-2">
                            <a href="/admin/agences/<?= (int) $agence['id'] ?>/edit"
                               class="btn btn-primary btn-sm">Modifier</a>

                               <form action="/admin/agences/<?= (int) $agence['id'] ?>/delete"
                               method="POST"
                               onsubmit="return confirm('Voulez-vous vraiment supprimer cette agence ?');">

                               <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </form>
                </div>
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