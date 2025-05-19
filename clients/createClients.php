
<?php
require_once '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone=$_POST['telephone'];
    $nombre_personnes=$_POST['nombre_personnes'];

    $conn = openDatabaseConnection();
    $stmt = $conn->prepare("INSERT INTO clients (nom, email, telephone,nombre_personnes) VALUES (?, ?,?,?)");
    $stmt->execute([$numero, $capacite]);
    closeDatabaseConnection($conn);
    
    header("Location: listClients.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Ajouter une Client </title>
</head>
<body>
    <h1>Ajouter un client</h1>
    <form method="post">
        <div>
            <label>Numéro:</label>
            <input type="text" name="numero" required>
        </div>
        <div>
            <label>Capacité:</label>
            <input type="number" name="capacite" required>
        </div>
        <button type="submit">Enregistrer</button>
    </form>
    <a href="listClients.php">Retour à la liste</a>
</body>
</html>
