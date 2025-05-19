<?php
// Inclusion du fichier de connexion à la base de données
require_once '../config/db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Vérifier si l'ID est valide
if ($id <= 0) {
    header("Location: listChambres.php");
    exit;
}

$conn = openDatabaseConnection();

// Traitement du formulaire si soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom= $_POST['nom'];
    $nombre_personnes= (int)$_POST['nombre_personnes'];
    $email=$_POST['email'];
    $telephone=$_POST['telephone'];
    
    // Validation des données
    $errors = [];

if (empty($nom)) {
$errors[] = "Veuillez assigner un client.";
}

if (empty($email)) {
$errors[] = "Veuillez entrer un moyen de contact.";
}

if ($nombre_personnes <= 0) {
$errors[] = "Le nombre de personnes doit être positif.";
}

if (empty($chambre)) {
    $errors[]="Vous devez rentrer une chambre";
}

if (empty($date_depart)){
    $errors[]="vous devez inclure une date de départ";
}


if (empty($date_arrivee)){
    $errors[]="vous devez inclure une date d'arrivée.";
}
    // Si pas d'erreurs, mettre à jour les données
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE chambres SET numero = ?, capacite = ? WHERE id = ?");
        $stmt->execute([$numero, $capacite, $id]);
        
        // Rediriger vers la liste des chambres
        header("Location: listChambres.php?success=1");
        exit;
    }
} else {
    // Récupérer les données de la chambre
    $stmt = $conn->prepare("SELECT * FROM chambres WHERE id = ?");
    $stmt->execute([$id]);
    $chambre = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si la chambre n'existe pas, rediriger
    if (!$chambre) {
        header("Location: listChambres.php");
        exit;
    }
}

closeDatabaseConnection($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier une Chambre</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .error-message {
            color: #e74c3c;
            margin: 10px 0;
            padding: 10px;
            background-color: #f9e7e7;
            border-left: 4px solid #e74c3c;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="../index.php">Accueil</a>
        <a href="listChambres.php">Chambres</a>
        <a href="../clients/listClients.php">Clients</a>
        <a href="../reservations/listReservations.php">Réservations</a>
    </div>

    <div class="container">
        <h1>Modifier une Chambre</h1>
        
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="error-message">
                <?php foreach($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
       <form method="post">
<div class="form-group">
    <p class=red><label for="nom">Client:</label></p>
    <input type="text" id="nom" name="nom" required>
</div>
    <p class=red><label for="nombre_personnes">Nombre de résidents:</label> </p>
<input type="number" id="nombre_personnes" name="nombre_personnes" min="1" required>
<p class=red><label for="email">email:</label> </p>
<input type="text" id="email" name="email" required>
<p class=red><label for="chambre">chambre:</label> </p>
<input type="number" id="chambre" name="chambre" required>
<p class=red> <label for="date_depart">date de départ:</label></p>
<input type="text" id="date_depart" name="date_depart" required>
<p class=red><label for="date_arrivee">date de départ:</label> </p>
<input type="text" id="date_arrivee" name="date_arrivee" required
</div>
<div class="actions">
<button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
<a href="listClients.php" class="btn btn-danger">Annuler</a>
</div>
</form>
    </div>
</body>
</html>
