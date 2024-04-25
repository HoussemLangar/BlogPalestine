<?php
class Utilisateur {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajouterUtilisateur($nom_prenom, $nom_utilisateur, $mot_de_passe) {
        $query = "INSERT INTO inscription (nom_prenom, nom_utilisateur, mot_de_passe, def) VALUES (:nom_prenom, :nom_utilisateur, :mot_de_passe, 'user')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom_prenom', $nom_prenom);
        $stmt->bindParam(':nom_utilisateur', $nom_utilisateur);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>alert('Utilisateur ajouté avec succès');</script>";
        } else {
            echo "<script>alert('Erreur lors de l'ajout de l'utilisateur');</script>";
        }
    }

    public function modifierMotDePasseUtilisateur($nom_utilisateur, $nouveau_mot_de_passe) {
        $query = "UPDATE inscription SET mot_de_passe = :nouveau_mot_de_passe WHERE nom_utilisateur = :nom_utilisateur";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nouveau_mot_de_passe', $nouveau_mot_de_passe);
        $stmt->bindParam(':nom_utilisateur', $nom_utilisateur);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>alert('Utilisateur modifié avec succès');</script>";
        } else {
            echo "<script>alert('Erreur lors de modification de l'utilisateur');</script>";
        }
    }

    public function supprimerUtilisateur($id_utilisateur) {
        $query = "DELETE FROM inscription WHERE id = :id_utilisateur";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>alert('Utilisateur supprimé avec succès');</script>";
        } else {
            echo "<script>alert('Erreur lors du suppression de l'utilisateur');</script>";
        }
    }
    public function getAllUtilisateurs() {
        $query = "SELECT * FROM inscription where def='user'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class Administrateur {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajouterAdministrateur($nom_admin, $mot_de_passe) {
        $query = "INSERT INTO inscription (nom_prenom, nom_utilisateur, mot_de_passe, def) VALUES (:nom_admin, :nom_utilisateur, :mot_de_passe, 'admin')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom_admin', $nom_admin);
        $stmt->bindParam(':nom_utilisateur', $nom_admin);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>alert('Administrateur ajouté avec succès');</script>";
        } else {
            echo "<script>alert('Erreur lors de l'ajout de l'administrateur');</script>";
        }
    }

    public function modifierMotDePasseAdministrateur($nom_admin, $nouveau_mot_de_passe) {
        $query = "UPDATE inscription SET mot_de_passe = :nouveau_mot_de_passe WHERE nom_utilisateur = :nom_admin AND def = 'admin'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nouveau_mot_de_passe', $nouveau_mot_de_passe);
        $stmt->bindParam(':nom_admin', $nom_admin);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>alert('Administrateur modifié avec succès');</script>";
        } else {
            echo "<script>alert('Erreur lors de modification de l'administrateur');</script>";
        }
    }

    public function supprimerAdministrateur($id_admin) {
        $query = "DELETE FROM inscription WHERE id = :id_admin AND def = 'admin'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_admin', $id_admin);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>alert('Administrateur supprimé avec succès');</script>";
        } else {
            echo "<script>alert('Erreur lors du suppression de l'administrateur');</script>";
        }
    }
    public function getAllAdmin() {
        $query = "SELECT * FROM inscription where def='admin'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class Article {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajouterArticle($titre, $descrip, $contenu, $auteur, $date_publication, $img) {
        $query = "INSERT INTO articles (titre, descrip, contenu, auteur, date_publication, img) VALUES (:titre, :descrip, :contenu, :auteur, :date_publication, :img)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':descrip', $descrip);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->bindParam(':date_publication', $date_publication);
        $stmt->bindParam(':img', $img);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>alert('Article ajouté avec succès');</script>";
        } else {
            echo "<script>alert('Erreur lors de l'ajout de l'article');</script>";
        }
    }

    public function modifierArticle($titre, $descrip, $contenu, $auteur, $date_publication, $img) {
        $query = "UPDATE articles SET descrip = :descrip, contenu = :contenu, auteur = :auteur, date_publication = :date_publication, img = :img WHERE titre = :titre";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':descrip', $descrip);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->bindParam(':date_publication', $date_publication);
        $stmt->bindParam(':img', $img);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>alert('Article modifié avec succès');</script>";
        } else {
            echo "<script>alert('Erreur lors de modification de l'article');</script>";
        }
    }

    public function supprimerArticle($id_article) {
        $query = "DELETE FROM articles WHERE id_article = :id_article";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_article', $id_article);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>alert('Article supprimé avec succès');</script>";
        } else {
            echo "<script>alert('Erreur lors du suppression de l'article');</script>";
        }
    }
    public function getAllArticles() {
        $query = "SELECT * FROM articles";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class Debat {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function supprimerMessage($id_message) {
        $query = "DELETE FROM debat WHERE id = :id_message";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_message', $id_message);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>alert('Message supprimé avec succès');</script>";
        } else {
            echo "<script>alert('Erreur lors du suppresion de message');</script>";
        }
    }

    public function supprimerTousLesMessages() {
        $query = "DELETE FROM debat";
        $stmt = $this->conn->prepare($query);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>alert('Tout les message supprimés avec succès');</script>";
        } else {
            echo "<script>alert('Erreur lors du suppression des messages');</script>";
        }
    }
    public function getAllDebats() {
        $query = "SELECT * FROM debat";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>