<?php

session_start();

require 'database.php';

// Alleen ingelogde gebruikers mogen deze pagina gebruiken
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Als het formulier wordt verstuurd
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titel = $_POST['titel'];
    $korte_omschrijving = $_POST['korte_omschrijving'];
    $lange_omschrijving = $_POST['lange_omschrijving'];
    $type = $_POST['type'];
    $jaar = $_POST['jaar'];

    $sql = "INSERT INTO projecten
            (titel, korte_omschrijving, lange_omschrijving, type, jaar)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $titel,
        $korte_omschrijving,
        $lange_omschrijving,
        $type,
        $jaar
    ]);

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Project toevoegen</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <h1>Project toevoegen</h1>

    <form method="POST">

        <div class="mb-3">

            <label>Titel</label>

            <input
                type="text"
                name="titel"
                class="form-control"
                required
            >

        </div>


        <div class="mb-3">

            <label>Korte omschrijving</label>

            <input
                type="text"
                name="korte_omschrijving"
                class="form-control"
                required
            >

        </div>


        <div class="mb-3">

            <label>Lange omschrijving</label>

            <textarea
                name="lange_omschrijving"
                class="form-control"
                required
            ></textarea>

        </div>


        <div class="mb-3">

            <label>Type</label>

            <input
                type="text"
                name="type"
                class="form-control"
                required
            >

        </div>


        <div class="mb-3">

            <label>Jaar</label>

            <input
                type="number"
                name="jaar"
                class="form-control"
                required
            >

        </div>


        <button type="submit" class="btn btn-success">
            Toevoegen
        </button>

        <a href="index.php" class="btn btn-secondary">
            Annuleren
        </a>

    </form>

</div>

</body>
</html>