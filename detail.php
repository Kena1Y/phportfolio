<?php

require 'database.php';

// Haal het id uit de URL
$id = $_GET['id'];

// Zoek het project met dat id
$sql = "SELECT * FROM projecten WHERE id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$project = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Portfolio Website - Detailpagina</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    crossorigin="anonymous"
  />

</head>

<body>

<main>

  <div class="container">

    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-1 projects">

      <div class="project card shadow-sm card-body m-2">

        <div class="card-text">

          <h2>
            <?= $project['titel'] ?>
          </h2>

          <div>
            <?= $project['lange_omschrijving'] ?>
          </div>

          <div>
            Type: <?= $project['type'] ?>
          </div>

          <div>
            Jaar: <?= $project['jaar'] ?>
          </div>

        </div>

      </div>

    </div>

    <a href="index.php" class="btn btn-primary mt-3">
      Terug
    </a>

  </div>

</main>


<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
  crossorigin="anonymous"
></script>

</body>
</html>