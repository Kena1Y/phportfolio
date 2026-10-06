<?php

session_start();

require 'database.php';

$fout = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: index.php");
        exit;

    } else {

        $fout = "Gebruikersnaam of wachtwoord is verkeerd.";

    }
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inloggen</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <h1>Inloggen</h1>

    <?php if ($fout != "") { ?>

        <div class="alert alert-danger">
            <?= $fout ?>
        </div>

    <?php } ?>

    <form method="POST">

        <div class="mb-3">

            <label>Gebruikersnaam</label>

            <input
                type="text"
                name="username"
                class="form-control"
                required
            >

        </div>

        <div class="mb-3">

            <label>Wachtwoord</label>

            <input
                type="password"
                name="password"
                class="form-control"
                required
            >

        </div>

        <button type="submit" class="btn btn-primary">
            Inloggen
        </button>

        <a href="index.php" class="btn btn-secondary">
            Terug
        </a>

    </form>

</div>

</body>

</html>