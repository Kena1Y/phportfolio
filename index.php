<?php

session_start();

require 'database.php';

// Zoeken en filter
$zoeken = $_GET['zoeken'] ?? '';
$jaar = $_GET['jaar'] ?? '';

// Welke pagina?
$pagina = $_GET['pagina'] ?? 1;

// Maximaal 5 projecten per pagina
$perPagina = 5;

// Berekenen waar we moeten beginnen
$start = ($pagina - 1) * $perPagina;


// Query voor zoeken en filteren
$where = " WHERE 1=1";
$waardes = [];

if ($zoeken != '') {
    $where .= " AND titel LIKE ?";
    $waardes[] = "%" . $zoeken . "%";
}

if ($jaar != '') {
    $where .= " AND jaar = ?";
    $waardes[] = $jaar;
}


// Eerst tellen hoeveel projecten er zijn
$sqlAantal = "SELECT COUNT(*) FROM projecten" . $where;

$stmtAantal = $pdo->prepare($sqlAantal);
$stmtAantal->execute($waardes);

$aantalProjecten = $stmtAantal->fetchColumn();


// Berekenen hoeveel pagina's nodig zijn
$aantalPaginas = ceil($aantalProjecten / $perPagina);


// Projecten ophalen
$sql = "SELECT * FROM projecten" . $where . " LIMIT $perPagina OFFSET $start";

$stmt = $pdo->prepare($sql);
$stmt->execute($waardes);

$projecten = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Portfolio Website - Overzichtspagina</title>

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

  <div class="mt-3">

    <?php if (isset($_SESSION['user_id'])) { ?>

    <span>
        Ingelogd als <?= $_SESSION['username'] ?>
    </span>

    <a href="add.php" class="btn btn-success">
        Project toevoegen
    </a>

    <a href="logout.php" class="btn btn-danger">
        Uitloggen
    </a>

<?php } else { ?>

    <a href="login.php" class="btn btn-primary">
        Inloggen
    </a>

<?php } ?>

</div>

    <!-- Zoekveld -->
    <form method="GET" class="d-flex justify-content-center align-items-center gap-2 m-4">

  <input
    type="text"
    name="zoeken"
    class="form-control"
    placeholder="Zoek op titel..."
    value="<?= $zoeken ?>"
  >

  <select name="jaar" class="form-select">

    <option value="">Alle jaren</option>

    <option value="2024" <?= $jaar == '2024' ? 'selected' : '' ?>>
      2024
    </option>

    <option value="2025" <?= $jaar == '2025' ? 'selected' : '' ?>>
      2025
    </option>

    <option value="2026" <?= $jaar == '2026' ? 'selected' : '' ?>>
      2026
    </option>

  </select>

  <button type="submit" class="btn btn-primary">
    Zoeken
  </button>

</form>


    <!-- Projecten -->
    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-1 projects">

      <?php foreach ($projecten as $project) { ?>

        <div class="project card shadow-sm card-body m-2">

          <div class="card-text">

            <h2>
              <?= $project['titel'] ?>
            </h2>

            <div>
              <?= $project['korte_omschrijving'] ?>
            </div>

          </div>


          <div class="d-flex justify-content-between align-items-center mt-3">

            <div class="btn-group">

              <!-- View knop -->
              <a
                href="detail.php?id=<?= $project['id'] ?>"
                class="btn btn-sm btn-outline-secondary"
              >
                View
              </a>

             <?php if (isset($_SESSION['user_id'])) { ?>

                  <a
                      href="edit.php?id=<?= $project['id'] ?>"
                      class="btn btn-sm btn-outline-secondary"
                  >
                      Edit
                  </a>

              <?php } ?>

             <?php if (isset($_SESSION['user_id'])) { ?>

                    <a
                    href="delete.php?id=<?= $project['id'] ?>"
                    class="btn btn-sm btn-outline-danger"
                  >
                    Delete
                  </a>

              <?php } ?>

            </div>

          </div>

        </div>

      <?php } ?>

    </div>


  <!-- Pagination -->
<div class="d-flex justify-content-center align-items-center m-4">

  <nav>

    <ul class="pagination">

      <?php for ($i = 1; $i <= $aantalPaginas; $i++) { ?>

        <li class="page-item">

          <a
            class="page-link"
            href="?pagina=<?= $i ?>&zoeken=<?= $zoeken ?>&jaar=<?= $jaar ?>"
          >
            <?= $i ?>
          </a>

        </li>

      <?php } ?>

    </ul>

  </nav>

</div>

  </div>
</main>


<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
  crossorigin="anonymous"
></script>

</body>
</html>
