<?php

class ContactManager
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $contacts = [];

        try {
            $stmt = $this->pdo->query('SELECT id, name, email, phone_number FROM contact');
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $contact = new Contact(
                    $row['id'],
                    $row['name'],
                    $row['email'],
                    $row['phone_number']
                );
                $contacts[] = $contact;
            }
        } catch (PDOException $e) {
            echo 'Erreur d\'exécution de la requête : ' . $e->getMessage();
        }

        return $contacts;
    }

    public function findContactById(int $id): ?Contact
    {
        try {
            $stmt = $this->pdo->prepare('SELECT id, name, email, phone_number FROM contact WHERE id = ?');
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new Contact(
                    $row['id'],
                    $row['name'],
                    $row['email'],
                    $row['phone_number']
                );
            } else {
                return null; // Aucun contact trouvé avec cet ID
            }
        } catch (PDOException $e) {
            echo 'Erreur d\'exécution de la requête : ' . $e->getMessage();
            return null;
        }
    }

    public function insertContact(string $name, string $email, string $phone_number): bool
    {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO contact (name, email, phone_number) VALUES (?, ?, ?)');
            return $stmt->execute([$name, $email, $phone_number]);
        } catch (PDOException $e) {
            echo 'Erreur d\'exécution de la requête : ' . $e->getMessage();
            return false;
        }
    }

    public function updateContact(Contact $contact): bool
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE contact SET name = ?, email = ?, phone_number = ? WHERE id = ?');
            return $stmt->execute([
                $contact->getName(),
                $contact->getEmail(),
                $contact->getPhoneNumber(),
                $contact->getId()
            ]);
        } catch (PDOException $e) {
            echo 'Erreur d\'exécution de la requête : ' . $e->getMessage();
            return false;
        }
    }

    public function deleteContact(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM contact WHERE id = ?');
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo 'Erreur d\'exécution de la requête : ' . $e->getMessage();
            return false;
        }
    }
}

?>
