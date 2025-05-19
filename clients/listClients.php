<?php
require_once '../config/db_connect.php';
$conn = openDatabaseConnection();
$stmt = $conn->query("SELECT * FROM clients ORDER BY nom");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
closeDatabaseConnection($conn);
?>
 <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $nombre_de_personne = $_POST['nombre_personne'];
        if (empty($nom) || empty($email) || empty($telephone) || empty($nombre_personnes))  {
            $encodedMessage = urlencode("ERREUR : une ou plusieurs valeurs erronnée(s).");
            header("Location: listclients.php?message=$encodedMessage");
            exit;
        } else {
            $conn = openDatabaseConnection();
            $stmt = $conn->prepare("INSERT INTO clients (nom, email, telephone, nombre_personnes) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $email, $telephone, $nombre_personnes]);
            closeDatabaseConnection($conn);
            
            $encodedMessage = urlencode("SUCCES : ajout effectuée.");
            header("Location: listClients.php?message=$encodedMessage");
            exit;
        }
    }
 ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    rel="stylesheet">
</head>

<body>
    <?php include '../assets/navbar.php'; ?>
    <h1>Liste des Clients</h1>
    <a href="createClients.php">Ajouter un client</a>
    <table border="1" style="width: 60%; min-width: 400px; margin: 0 auto;">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>email</th>
            <th>telephone</th>
            <th>nombre_personne</th>
        </tr>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?php echo $client['id']; ?></td>
                <td><?= $client['nom'] ?></td>
                <td><?= $client['email'] ?></td>
                <td><?= $client['telephone'] ?></td>
                <td><?= $client['nombre_personnes'] ?></td>
                <td>  <a href="editClients.php?id=<?= $client['id'] ?>">Modifier</a>
                    <a href="deleteClients.php?id=<?= $client['id'] ?>"
                        onclick="return confirm('Êtes-vous sûr?')">Supprimer</a>
                </td>
                
            </tr>
           
        <?php endforeach; ?>
    </table>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>