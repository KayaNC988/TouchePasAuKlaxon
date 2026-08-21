<?php
require __DIR__ . '/partials/header.php'; ?>

<main class="container mt-4">
    <h2 class="mb-4 text-secondary">Connexion</h2>

    <form method="POST" action="/login">
        <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input
             type="email" 
             class="form-control" 
             id="email" 
             name="email"
            required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input 
            type="password" 
            class="form-control" 
            id="password" 
            name="password" 
            required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </main>

    <?php require __DIR__ . '/partials/footer.php'; ?>