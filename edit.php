<?php

session_start();

require 'database.php';

// Alleen ingelogde gebruikers
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ID uit de URL halen
$id = $_GET['id'];

// Project ophalen
$sql = "SELECT * FROM projecten WHERE id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$project = $stmt->fetch(PDO::FETCH_ASSOC);


// Als het formulier wordt verstuurd
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titel = $_POST['titel'];
    $korte_omschrijving = $_POST['korte_omschrijving'];
    $lange_omschrijving = $_POST['lange_omschrijving'];
    $type = $_POST['type'];
    $jaar = $_POST['jaar'];

    $sql = "UPDATE projecten
            SET titel = ?,
                korte_omschrijving = ?,
                lange_omschrijving = ?,
                type = ?,
                jaar = ?
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $titel,
        $korte_omschrijving,
        $lange_omschrijving,
        $type,
        $jaar,
        $id
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

    <title>Project aanpassen</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <h1>Project aanpassen</h1>

    <form method="POST">

        <div class="mb-3">

            <label>Titel</label>

            <input
                type="text"
                name="titel"
                class="form-control"
                value="<?= $project['titel'] ?>"
                required
            >

        </div>


        <div class="mb-3">

            <label>Korte omschrijving</label>

            <input
                type="text"
                name="korte_omschrijving"
                class="form-control"
                value="<?= $project['korte_omschrijving'] ?>"
                required
            >

        </div>


        <div class="mb-3">

            <label>Lange omschrijving</label>

            <textarea
                name="lange_omschrijving"
                class="form-control"
                required
            ><?= $project['lange_omschrijving'] ?></textarea>

        </div>


        <div class="mb-3">

            <label>Type</label>

            <input
                type="text"
                name="type"
                class="form-control"
                value="<?= $project['type'] ?>"
                required
            >

        </div>


        <div class="mb-3">

            <label>Jaar</label>

            <input
                type="number"
                name="jaar"
                class="form-control"
                value="<?= $project['jaar'] ?>"
                required
            >

        </div>


        <button type="submit" class="btn btn-primary">
            Opslaan
        </button>

        <a href="index.php" class="btn btn-secondary">
            Annuleren
        </a>

    </form>

</div>

</body>
</html>