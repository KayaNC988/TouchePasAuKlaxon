<?php require __DIR__ . '/partials/header.php'; ?>

<main class="container mt-4">

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success mb-4" role="alert">
        <?= htmlspecialchars($_SESSION['success']) ?>

        <?php unset($_SESSION['success']); ?>
        <?php endif; ?>


<?php if (isset($_SESSION['user'])): ?>
    <h2 class="mb-4 text-secondary">Consultez les trajets disponibles</h2>
    <?php else: ?>
    <h2 class="mb-4 text-secondary">Veuillez vous connecter pour consulter les trajets disponibles</h2>
<?php endif; ?>

<table class="table table-stripped">
    <thead class="table-primary">
        <tr>
            <th scope="col">Ville de départ</th>
            <th scope="col">Date de départ</th>
            <th scope="col">Heure de départ</th>

            <th scope="col">Ville d'arrivée</th>
            <th scope="col">Date d'arrivée</th>
            <th scope="col">Heure d'arrivée</th>

            <th scope="col">Places disponibles</th>
            <th scope="col">Action</th>
        </tr>
    </thead>

        <tbody>
    <?php foreach ($trajets as $trajet): ?>
        <tr>
            <td><?= htmlspecialchars($trajet['ville_depart']) ?></td>
            <td><?= date('d/m/Y', strtotime($trajet['depart_at'])) ?></td>
            <td><?= date('H:i', strtotime($trajet['depart_at'])) ?></td>

            <td><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>
            <td><?= date('d/m/Y', strtotime($trajet['arrivee_at'])) ?></td>
            <td><?= date('H:i', strtotime($trajet['arrivee_at'])) ?></td>

            <td><?= htmlspecialchars($trajet['places_disponibles']) ?></td>
            <td>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="/trajets/<?= htmlspecialchars((string) $trajet['id']) ?>" 
                    class="btn btn-primary btn-sm">
                    Voir les détails</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
      
    
</table>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>