<?php
include 'include/database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID client manquant.";
    exit;
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST['login'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    $stmt = $pdo->prepare("UPDATE utilisateurs SET login = ?, nom = ?, prenom = ? WHERE id_user = ?");
    $stmt->execute([$login, $nom, $prenom, $id]);

    header("Location: clients.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_user = ?");
$stmt->execute([$id]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$client) {
    echo "Client introuvable.";
    exit;
}

include 'include/nav.php';
?>

<div class="container mt-4">
  <h2>Modifier le client</h2>
  <form method="post">
    <div class="mb-3">
      <label for="login" class="form-label">Login</label>
      <input type="text" class="form-control" id="login" name="login" value="<?= ($client['login']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="nom" class="form-label">Nom</label>
      <input type="text" class="form-control" id="nom" name="nom" value="<?= ($client['nom']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="prenom" class="form-label">Prénom</label>
      <input type="text" class="form-control" id="prenom" name="prenom" value="<?= ($client['prenom']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="clients.php" class="btn btn-secondary">Annuler</a>
  </form>
</div>

<?php include 'include/footer.php'; ?>
