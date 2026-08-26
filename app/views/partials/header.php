<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche Pas Au Klaxon</title>
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body class="bg-light">
    <header class="container mt-3">
        <nav class="navbar navbar-dark bg-primary rounded px-3 py-2">
        <a class="navbar-brand text-white" href="/">Touche Pas Au Klaxon</a>

        <?php if (isset($_SESSION['user'])): ?>
            <div class="d-flex align-items-center gap-3">
                <a href="/trajets/create" class="btn btn-light">Créer un trajet</a>
            <span class="text-white me-3">Bonjour, <?= htmlspecialchars($_SESSION['user']['prenom']) ?>!</span>
            <a href="/logout" class="btn btn-outline-light">Se déconnecter</a>
            </div>
        <?php else: ?>
            <a href="/login" class="btn btn-outline-light">Se connecter</a>
        <?php endif; ?>
        </nav>
    </header>