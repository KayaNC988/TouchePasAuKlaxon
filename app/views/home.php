<?php require __DIR__ . '/partials/header.php'; ?>

<main class="container mt-4">

<h2 "mb-3">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</h2>

<table class="table table-stripped">
    <thead class="table-dark">
        <tr>
            <th scope="col">Ville de départ</th>
            <th scope="col">Date de départ</th>
            <th scope="col">Heure de départ</th>

            <th scope="col">Ville d'arrivée</th>
            <th scope="col">Date d'arrivée</th>
            <th scope="col">Heure d'arrivée</th>

            <th scope="col">Places disponibles</th>
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
        </tr>
    <?php endforeach; ?>
</tbody>
      
    
</table>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>