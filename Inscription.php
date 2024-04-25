<?php
require('connect.php');
class Inscriptions {
    private $bdd;
    private $nomPrenom;
    private $nomUtilisateur;
    private $motDePasse;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
    public function setNomPrenom($value) {
        $this->nomPrenom = $value;
    }

    public function getNomPrenom() {
        return $this->nomPrenom;
    }

    public function setNomUtilisateur($value) {
        $this->nomUtilisateur = $value;
    }

    public function getNomUtilisateur() {
        return $this->nomUtilisateur;
    }

    public function setMotDePasse($value) {
        $this->motDePasse = $value;
    }

    public function getMotDePasse() {
        return $this->motDePasse;
    }
}
class Inscription
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function addUser(Inscriptions $user, $lang)
{
    try {

        $stmt = $this->conn->prepare("SELECT id FROM inscription WHERE nom_utilisateur = :nomUtilisateur OR nom_prenom = :nomPrenom");
        $stmt->bindValue(':nomUtilisateur', $user->getNomPrenom());
        $stmt->bindValue(':nomPrenom', $user->getNomUtilisateur());
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $stmt = $this->conn->prepare("INSERT INTO inscription (nom_prenom, nom_utilisateur, mot_de_passe, def) VALUES (:nomPrenom, :nomUtilisateur, :motDePasse, 'user')");

            $stmt->bindValue(':nomPrenom', $user->getNomPrenom());
            $stmt->bindValue(':nomUtilisateur', $user->getNomUtilisateur());
            $stmt->bindValue(':motDePasse', $user->getMotDePasse());
            $stmt->execute();
            header("Location: Login.php?success=1");
            exit();

        } else {
            header("Location: Signup.php?error=1");
            exit();
        }
        } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
}
?>