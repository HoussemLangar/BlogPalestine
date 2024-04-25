<?php
function chargerClass($classname)
{
    require $classname.'.php';
}
spl_autoload_register("chargerClass");
session_start();
$con = new PDO('mysql:host=localhost;dbname=bd_blog;', 'root', '');
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$manager = new Tokens($con); 
$lang = "fr" ;
if (isset($_POST['submit'])) {
    $donnees = array(
        'nomUtilisateur'=>$_POST["username"],
        'motDePasse'=>$_POST["password"]);
        
        $user = new Token($donnees);
        $jwt = $manager->addUser($user , $lang);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connecter</title>
    <link rel="icon" href="ressource\logo.png">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        #video-background {
            position: fixed;
            right : 0;
            bottom : 0;
            min-width : 100%;
            min-height : 100%;
            width : auto;
            height : auto;
            z-index: -1000;
        }

        .login-container {
            position: absolute;
            top : 50%;
            left : 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .login-container h1, .signup-container h1 {
            text-align: center;
            margin-bottom : 30px;
        }

        .form-group label {
            font-weight: 600;
            margin-top : 15px;
            margin-bottom : 7px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-block {
            display: block;
            width : 100%;
            margin-top : 20px;
        }

        .mt-3 {
            margin-top : 20px;
        }
        .reussi {
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            margin-bottom : 15px;
            margin-top : 10px;
        }
        .alert {
            padding: 15px;
            background-color: #f44336;
            color: white;
            margin-bottom : 15px;
            margin-top : 10px;
        }
        .navbar-brand {
            margin-left : 580px;
        }
    </style>
</head>
<body>
    <video id="video-background" autoplay loop muted>
        <source src="ressource\video1.mp4" type="video/mp4">
    </video>

    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand">Connexion</a>
        </div>
    </header>

    <div class="login-container">
        <h1>Connectez-vous</h1>
        <form action="" method="post" class="needs-validation">
            <div class="form-group">
            <?php
                if (isset($_GET['success']) && $_GET['success'] == 1) {
                echo '<div class="reussi">Compte crée avec succès !</div>';
                }
            ?>
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Exemple@gmail.com" required>
                <div class="invalid-feedback">Veuillez entrer votre nom d'utilisateur.</div>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="**********" required>
                <div class="invalid-feedback">Veuillez entrer votre mot de passe.</div>
            </div>
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 2) {
            echo '<div class="alert">Adresse e-mail ou mot de passe incorrect !</div>';
            }
            ?>
            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">Submit</button>
            <div class="mt-3 text-center">
                <p>Vous n'avez pas un compte ? <a href="Signup.php" id="signup-link">Inscrivez-vous maintenant!</a></p>
            </div>
        </form>
    </div>
</body>
</html>
