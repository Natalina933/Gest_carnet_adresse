<?php
include_once('dbConnect.php');

// Connexion à la base de données
$dbConnect = new DBConnect('localhost', 'gest_contact', 'root', '');
$bdd = $dbConnect->getPDO();

// Vérifie si les champs obligatoires (name, email, phone_number) sont remplis
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone_number'])) {
    header('Location: error.php?erreur=true');
    exit;
} else {
    // Nettoie les données d'entrée pour éviter les injections de code.
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone_number = htmlspecialchars($_POST['phone_number']);

    try {
        // Prépare et exécute une requête SQL pour insérer les données dans la table 'contact'.
        $req = $bdd->prepare('INSERT INTO contact (name, email, phone_number) VALUES (?, ?, ?)');
        $req->execute([$name, $email, $phone_number]);

        // Redirige vers la page 'contact.php' avec l'ID de l'enregistrement nouvellement créé.
        header('Location: contact.php?contact_id=' . $bdd->lastInsertId());
        exit;
    } catch (PDOException $e) {
        echo 'Erreur d\'exécution de la requête : ' . $e->getMessage();
        exit;
    }
}
