<?php
// Inclusion de dbConnect.php pour obtenir l'objet PDO
require_once 'dbConnect.php';
require_once 'Contact.php';
require_once 'ContactManager.php';

try {
    $pdo = dbConnect(); // Appel à la fonction dbConnect qui retourne un objet PDO

    if ($pdo) {
        // Inclusion de ContactManager.php pour utiliser la classe ContactManager
        include_once('ContactManager.php');
        $contactManager = new ContactManager($pdo); // Instanciation de ContactManager avec PDO

        // Exemple d'utilisation de findAll pour récupérer tous les contacts
        $contacts = $contactManager->findAll();

        // Affichage des contacts en utilisant la méthode toString de Contact
        foreach ($contacts as $contact) {
            echo $contact . "\n"; // Utilisation implicite de la méthode __toString()
        }
    } else {
        echo "Erreur de connexion à la base de données.";
    }
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    // Gérer l'erreur de connexion à la base de données si nécessaire
}
