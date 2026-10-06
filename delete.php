<?php

session_start();

require 'database.php';

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Haal het id uit de URL
$id = $_GET['id'];

// Verwijder het project
$sql = "DELETE FROM projecten WHERE id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

// Terug naar de overzichtspagina
header("Location: index.php");
exit;