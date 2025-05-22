<?php
include 'include/database.php';
include 'include/nav.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='container mt-4 alert alert-danger'>ID du client manquant.</div>";
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_user = ?");
$stmt->execute([$id]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$client) {
    echo "<div class='container mt-4 alert alert-danger'>Client introuvable.</div>";
    exit;
}

$stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id_user = ?");
$stmt->execute([$id]);

header("Location: clients.php");
exit;

?>
