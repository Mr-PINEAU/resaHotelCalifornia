<?php
// Inclusion du fichier de connexion à la base de données
require_once '../config/db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Vérifier si l'ID est valide
if ($id <= 0) {
    header("Location: listClients.php");
    exit;
}

$conn = openDatabaseConnection();

// Traitement du formulaire si soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone=$_POST['telephone'];
    $nombre_personnes=(int)$_POST['nombre_personnes'];
    
    // Validation des données
    $errors = [];
    
    if (empty($nom)) {
        $errors[] = "Le nom est obligatoire.";
    }
    
    if ($nombre_personnes <= 0) {
        $errors[] = "Le nombre de personnes doit être un nombre positif.";
    }
    
    // Si pas d'erreurs, mettre à jour les données
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE clients SET nom = ?, email = ?, telephone=?,nombre_personnes=? WHERE id = ?");
        $stmt->execute([$nom, $email, $telephone, $nombre_personnes, $id]);
        
        // Rediriger vers la liste des chambres
        header("Location: listClients.php?success=1");
        exit;
    }
} else {
    // Récupérer les données de la chambre
    $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si le client n'existe pas, rediriger
    if (!$client) {
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
<?php include '../assets/navbar.php'; ?>

    <div class="container">
        <h1>Modifier un client</h1>
        
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="error-message">
                <?php foreach($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="nom">Nom du client:</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($client['nom']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="nombre_personnes"> nombre de personnes:</label>
                <input type="number" id="nombre_personnes" name="nombre_personnes" value="<?= $client['nombre_personnes'] ?>" min="1" required>
            </div>
            <div>
                <label for="email"> addresse électronique:</label>
                <input type="text" id="email" name="email" value="<?= htmlspecialchars($client['email']) ?>" required>
            </div>
            <div>
                <label for="telephone"> numero de telephone:</label>
                <input type="number" id="telephone" name="telephone" value="<?= $client['telephone'] ?>" min="1" required>
                </div>
            <div class="actions">
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="listClients.php" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>
