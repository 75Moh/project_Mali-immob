<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title> Agence Immobilière</title>
</head>
<body>
    <h1> Agence Immobilière</h1>
    <p>
        Cette  permet de gérer les biens immobiliers d'une agence.
    </p>
    <h2>Liste des biens</h2>
    <ul>
        <li><a href="api/biens">Tous les biens</a></li>
        <li><a href="api/biens?type=appartement">Appartements</a></li>
        <li><a href="api/biens?type=maison">Maisons</a></li>
    </ul>
    <h2>Ajouter un bien</h2>
    <form action="api/biens" method="post">
        <label for="type">Type de bien : </label>
        <input type="text" id="type" name="type" required>
        <br>
        <label for="proprietaire">Adresse : </label>
        <input type="text" id="proprietaire" name="proprietaire" required>
        <br>
        <label for="Appartement">Surface (m²) : </label>
        <input type="number" id="Appartement" name="Appartement" required>
        <br>
        <label for="prix">Prix (Xof) : </label>
        <input type="number" id="prix" name="prix" required>
        <br>
        <br>
        <input type="submit" value="Ajouter">
        <?php

// Définition des routes
$routes = array(
    '/biens' => 'getBiens',
    '/biens/ajouter' => 'ajouterBien'
);

// Fonction pour récupérer tous les biens
function getBiens() {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=agence_immobiliere', 'root', '');

    // Requête SQL
    $sql = 'SELECT * FROM biens';

    // Exécution de la requête
    $stmt = $db->query($sql);

    // Récupération des résultats
    $biens = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Encodage des résultats en JSON
    echo json_encode($biens);
}

// Fonction pour ajouter un bien
function ajouterBien() {
    // Récupération des données du formulaire
    $type = $_POST['type'];
    $proprietaire = $_POST['proprietaire'];
    $Appartement = $_POST['Appartement'];
    $prix = $_POST['prix'];

    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=agence_immobiliere', 'root', '');

    // Requête SQL
    $sql = 'INSERT INTO biens (type, proprietaire, Appartement, prix) VALUES (:type, :proprietaire, :Appartement, :prix)';

    // Préparation de la requête
    $stmt = $db->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':proprietaire', $proprietaire);
    $stmt->bindParam(':Appartement', $Appartement);
    $stmt->bindParam(':prix', $prix);

    // Exécution de la requête
    $stmt->execute();

    // Redirection vers la page de liste des biens
    header('Location: index.php');
}

// Traitement de la requête
$route = $_SERVER['REQUEST_URI'];

if (array_key_exists($route, $routes)) {
    $function = $routes[$route];
    call_user_func($function);
} else {
    echo '404 Not Found';
}

?>
