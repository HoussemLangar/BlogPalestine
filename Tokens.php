<?php
require_once 'connect.php';
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;

class Token {
    private $key;
    private $bdd;
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
    public function setKey($value) {
        $this->key = $value;
    }

    public function getKey() {
        return $this->key;
    }
}


class Tokens {
    private $conn;
    public $key;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function addUser(Token $user, String $lang)
    {

        try {
            $stmt = $this->conn->prepare("SELECT id , def , nom_utilisateur FROM inscription WHERE nom_utilisateur = :nomUtilisateur AND mot_de_passe = :motDePasse");
            $stmt->bindValue(':nomUtilisateur', $user->getNomUtilisateur());
            $stmt->bindValue(':motDePasse', $user->getMotDePasse());
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $cal = $stmt->rowCount();

        if ($cal > 0) {
            if ($result){
                $userData = array('id' => $result['id'], 'def' => $result['def'], 'nom_utilisateur' => $result['nom_utilisateur']); 
        
                if ($userData['def'] == 'user') {
                   
                    $expirationTime = time() + 3600; 
                    $redirectUrl = "Accueil_" . $lang . ".php";

                } elseif ($userData['def'] == 'admin') {
                    $expirationTime = time() + (3600 * 24);
                    $redirectUrl = "dashboard_admin.php"; 

                } else {
                    return false;
                }
        
                $issuer = "blogPalestine.com";
                $secret_key = "123456789";
                $_SESSION['token'] = $secret_key;
                $token = array(
                    "iat" => time(),
                    "exp" => $expirationTime,
                    "iss" => $issuer,
                    "data" => $userData
                );
                $algorithm = 'HS256';
                $jwt = JWT::encode($token, $_SESSION['token'], $algorithm); 
                session_start();
                $_SESSION['nom_utilisateur'] = $userData['nom_utilisateur'];
                header("Location: $redirectUrl?token=$jwt");
                exit();
            }
        } else {
            header("Location: Login.php?error=2");
        }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
}
}
?>