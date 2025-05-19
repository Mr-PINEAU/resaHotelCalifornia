// chambres/create.php
<?php
require_once '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'];
    $capacite = $_POST['capacite'];
    
    $conn = openDatabaseConnection();
    $stmt = $conn->prepare("INSERT INTO chambres (numero, capacite) VALUES (?, ?)");
    $stmt->execute([$numero, $capacite]);
    closeDatabaseConnection($conn);
    
    header("Location: listChambres.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Ajouter une Réservation</title>
</head>
<body>
    <h1>Ajouter une Réservation</h1>
    <form method="post">
  <div>
  <label>Nom:</label> </p>
  <input type="text" name="nom" required>
  </div>

  <div>
   <label>Email:</label> </p>
  <input type="email" name="email" required>
  </div>

  <div>
 <label>Téléphone:</label></p>
  <input type="text" name="telephone" required>
  </div>

  <div>
 <label>Nombre de personnes:</label></p>
  <input type="number" name="nombre_personnes" required>
  </div>

  <div>
  <label>Chambre:</label></p>
  <input type="number" name="numero" required>
  </div>

  <div>
  <label>Date d'arrivée:</label> </p>
  <input type="date" name="date_arrivee" required>
  </div>
  <div>
  <label>Date de départ:</label> </p>
  <input type="date" name="date_depart" required>
  </div>

  <button type="submit">Créer la réservation</button>
</form>
    <a href="listReservations.php">Retour à la liste</a>
</body>
</html>
