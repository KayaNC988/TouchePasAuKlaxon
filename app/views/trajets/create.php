<?php require __DIR__ . '/../partials/header.php'; ?>
<?php $old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
?>

<main class="container my-5">

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger mb-4" role="alert">
    <?= htmlspecialchars($_SESSION['error']) ?>
</div>

<?php unset($_SESSION['error']); ?>
<?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
    <h2 class="mb-4 text-secondary text-center">Proposer un trajet</h2>


    <form method="POST" action="/trajets">

    <div class="card mb-4">
 

 <div class="card-body border-bottom mb-4 pb-4">
    <h5 class="card-title mb-3 text-secondary">Vos informations</h5>

    <div class="row">
        <div class="col-md-6">
            <p>
                <strong>Nom :</strong>
                <?= htmlspecialchars($_SESSION['user']['nom']) ?>
            </p>

            <p>
                <strong>Prénom :</strong>
                <?= htmlspecialchars($_SESSION['user']['prenom']) ?>
            </p>
        </div>

        <div class="col-md-6">
            <p>
                <strong>Email :</strong>
                <?= htmlspecialchars($_SESSION['user']['email']) ?>
            </p>

            <p>
                <strong>Téléphone :</strong>
                <?= htmlspecialchars($_SESSION['user']['telephone']) ?>
            </p>
        </div>
    </div>
</div>

<div class="row g-4">

    <div class="col-md-6">
        <div class="mb-3">
          <label for="agence_depart_id" class="form-label fw-bold">
                Agence de départ
            </label> 

            <select
                name="agence_depart_id"
                id="agence_depart_id"
                class="form-select"
                required
            >
                <option value="">Choisir une agence</option>

                <?php foreach ($agences as $agence): ?>
                    <option value="<?= htmlspecialchars((string) $agence['id']) ?>"
                        <?= (($old['agence_depart_id'] ?? '') == $agence['id']) ? 'selected' : '' ?>
                        >
                         <?= htmlspecialchars($agence['ville']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="depart_at" class="form-label fw-bold">
                Date et heure de départ
            </label>

            <input
                type="datetime-local"
                name="depart_at"
                id="depart_at"
                class="form-control"
                value="<?= htmlspecialchars($old['depart_at'] ?? '') ?>"
                required
            >
        </div>
    </div>


    <div class="col-md-6">
        <div class="mb-3">
            <label for="agence_arrivee_id" class="form-label fw-bold">
                Agence d'arrivée
            </label>

            <select
                name="agence_arrivee_id"
                id="agence_arrivee_id"
                class="form-select"
                required
            >
                <option value="">Choisir une agence</option>

                <?php foreach ($agences as $agence): ?>
                    <option value="<?= htmlspecialchars((string) $agence['id']) ?>"
                        <?= (($old['agence_arrivee_id'] ?? '') == $agence['id']) ? 'selected' : '' ?>
                        >
                        <?= htmlspecialchars($agence['ville']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="arrivee_at" class="form-label fw-bold">
                Date et heure d'arrivée
            </label>

            <input
                type="datetime-local"
                name="arrivee_at"
                id="arrivee_at"
                class="form-control"
                value="<?= htmlspecialchars($old['arrivee_at'] ?? '') ?>"
                required
            >
        </div>
    </div>
    <div class="mb-4 mt-2 col-md-4">
    <label for="places_total" class="form-label fw-bold">
        Nombre total de places
    </label>

    
    <input
        type="number"
        name="places_total"
        id="places_total"
        class="form-control"
        min="1"
        value="<?= htmlspecialchars($old['places_total'] ?? '') ?>"
        required
    >
</div>


                </div>  

<div clas="d-flex gap-2 mt-3">
    <button type="submit" class="btn btn-primary px-4">
        Valider le trajet
        </button>

        <a href="/" class="btn btn-outline-secondary">
        Annuler
        </a>
        </div>
               
    

    </form>
   
        </div>
        </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>