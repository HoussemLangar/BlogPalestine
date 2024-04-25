<?php
require_once('connect.php');
function chargerClass($classname)
{
    require 'Traitement.php';
}
spl_autoload_register("chargerClass");
session_start();
$conn = new PDO('mysql:host=' . $servername . ';dbname=' . $dbname, $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$utilisateur = new Utilisateur($conn); 
$administrateur = new Administrateur($conn); 
$article = new Article($conn); 
$debat = new Debat($conn); 
$lang = "fr" ;
if (isset($_POST['ajouter_utilisateur'])) {
    $nom_prenom = $_POST['nom_prenom'];
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];
    
    $utilisateur->ajouterUtilisateur($nom_prenom, $nom_utilisateur, $mot_de_passe);
}

if (isset($_POST['modifier_mot_de_passe_utilisateur'])) {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe'];
    
    $utilisateur->modifierMotDePasseUtilisateur($nom_utilisateur, $nouveau_mot_de_passe);
}

if (isset($_POST['supprimer_utilisateur'])) {
    $id_utilisateur = $_POST['id_utilisateur'];
    $utilisateur->supprimerUtilisateur($id_utilisateur);
}
if (isset($_POST['ajouter_administrateur'])) {
    $nom_admin = $_POST['nom_admin'];
    $mot_de_passe = $_POST['mot_de_passe_admin'];

    $administrateur->ajouterAdministrateur($nom_admin, $mot_de_passe);
}

if (isset($_POST['modifier_mot_de_passe_administrateur'])) {
    $nom_admin = $_POST['nom_admin'];
    $nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe_admin'];

    $administrateur->modifierMotDePasseAdministrateur($nom_admin, $nouveau_mot_de_passe);
}

if (isset($_POST['supprimer_administrateur'])) {
    $id_admin = $_POST['id_admin'];

    $administrateur->supprimerAdministrateur($id_admin);
}
if (isset($_POST['ajouter_article'])) {
    $titre = $_POST['titre'];
    $descrip = $_POST['descrip'];
    $contenu = $_POST['contenu'];
    $auteur = $_POST['auteur'];
    $date_publication = $_POST['date_publication'];
    $img = $_POST['img'];

    $article->ajouterArticle($titre, $descrip, $contenu, $auteur, $date_publication, $img);
}

if (isset($_POST['modifier_article'])) {
    $titre = $_POST['titre'];
    $descrip = $_POST['descrip'];
    $contenu = $_POST['contenu'];
    $auteur = $_POST['auteur'];
    $date_publication = $_POST['date_publication'];
    $img = $_POST['img'];

    $article->modifierArticle($titre, $descrip, $contenu, $auteur, $date_publication, $img);
}

if (isset($_POST['supprimer_article'])) {
    $id_article = $_POST['id_article'];

    $article->supprimerArticle($id_article);
}

if (isset($_POST['supprimer_debat'])) {
    $id_message = $_POST['id_msg'];

    $debat->supprimerMessage($id_message);
}

if (isset($_POST['confirm_suppression'])) {
    $debat->supprimerTousLesMessages();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord administratif</title>
    <link rel="icon" href="ressource\logo.png">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width : 960px;
            margin-top : 50px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            border-radius: 15px 15px 0 0;
            padding: 15px;
        }
        .card-title {
            margin-bottom : 0;
            font-size: 1.5rem;
        }
        .card-body {
            padding: 20px;
        }
        .btn-custom {
            width : 100%;
            margin-bottom : 10px;
            border-radius: 10px;
            font-size: 1.2rem;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width : 80%;
            margin: 10% auto;
        }
        .close {
            color: #aaa;
            font-size: 24px;
            font-weight: bold;
            float : right;
        }
        .close:hover {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        .modal {
            display: none; 
            position: fixed;
            z-index: 1; 
            left : 0;
            top : 0;
            width : 100%; 
            height : 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.4); 
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <?php if(isset($_GET['token'])) { ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-danger" href="Logout.php">Déconnexion</a>
                    </li>
                </ul>
            <?php } else { ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-success" href="Login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-success" href="Signup.php">Signup</a>
                    </li>
                </ul>
        <?php  }?>
    </nav>
    <div class="container">
        <h1 class="text-center mb-5">Bienvenue Administrateur</h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Gestion Utilisateurs</h2>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary btn-custom" id="1">Ajouter Utilisateur</button>
                            <button class="btn btn-primary btn-custom" id="2">Modifier Mot de Passe Utilisateur</button>
                            <button class="btn btn-danger btn-custom" id="3">Supprimer Utilisateur</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Gestion Administrateurs</h2>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary btn-custom" id="4">Ajouter Administrateur</button>
                            <button class="btn btn-primary btn-custom" id="5">Modifier Mot de Passe Administrateur</button>
                            <button class="btn btn-danger btn-custom" id="6">Supprimer Administrateur</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Gestion Articles</h2>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary btn-custom" id="7">Ajouter Article</button>
                            <button class="btn btn-primary btn-custom" id="8">Modifier Article</button>
                            <button class="btn btn-danger btn-custom" id="9">Supprimer Article</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Gestion Débats</h2>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-danger btn-custom" id="10">Supprimer Message</button>
                            <button class="btn btn-danger btn-custom" id="11">Supprimer Tous les Messages</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
<div id="myModal1" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span>
    <h5 class="modal-title">Ajouter Utilisateur</h5>
    <br>
    <form method="POST">
        <div class="form-group">
            <label for="nom_prenom">Nom et Prénom</label>
            <input type="text" class="form-control" id="nom_prenom" name="nom_prenom" required>
        </div>
        <div class="form-group">
            <label for="nom_utilisateur">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="nom_utilisateur" name="nom_utilisateur" required>
        </div>
        <div class="form-group">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary" name="ajouter_utilisateur">Ajouter Utilisateur</button>
    </form>
</div>
</div>
<div id="myModal2" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span>
    <h5 class="modal-title">Modifier le mot de passe d'un utilisateur</h5>
    <br>
        <form method="POST">
        <div class="form-group">
            <label for="nom_utilisateur">Nom d'utilisateur :</label>
            <input type="text" class="form-control" id="nom_utilisateur" name="nom_utilisateur" required>
        </div>
        <div class="form-group">
            <label for="nouveau_mot_de_passe">Nouveau mot de passe :</label>
            <input type="password" class="form-control" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary" name="modifier_mot_de_passe_utilisateur">Modifier</button>
        </form>
    </div>
</div>
<div id="myModal3" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span>
    <h5 class="modal-title">Supprimer un utilisateur</h5>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom et prénom</th>
                <th>Nom d'utilisateur</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $utilisateurs = $utilisateur->getAllUtilisateurs();
            foreach ($utilisateurs as $user) {
                echo "<tr><form method='POST'>";
                echo "<td>" . $user['id'] . "</td> ";
                echo "<input type='hidden' name='id_utilisateur' value='" . $user['id'] . "'>";
                echo "<td>" . $user['nom_prenom'] . "</td>";
                echo "<td>" . $user['nom_utilisateur'] . "</td>";
                echo "<td><button class='btn btn-danger' name='supprimer_utilisateur'>Supprimer</button></form></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>
<div id="myModal4" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span>
    <h5 class="modal-title">Ajouter un administrateur</h5>
    <br>
    <form method="POST">
        <div class="form-group">
            <label for="nom_admin">Nom administrateur :</label>
            <input type="text" class="form-control" id="nom_admin" name="nom_admin" required>
        </div>
        <div class="form-group">
            <label for="mot_de_passe_admin">Mot de passe :</label>
            <input type="password" class="form-control" id="mot_de_passe_admin" name="mot_de_passe_admin" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary" name="ajouter_administrateur">Ajouter</button>
</form>
</div>
</div>
<div id="myModal5" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span>
    <h5 class="modal-title">Modifier le mot de passe d'un administrateur</h5>
    <br>
    <form method="POST">
        <div class="form-group">
            <label for="nom_admin">Nom administrateur :</label>
            <input type="text" class="form-control" id="nom_admin" name="nom_admin" required>
        </div>
        <div class="form-group">
            <label for="nouveau_mot_de_passe_admin">Nouveau mot de passe :</label>
            <input type="password" class="form-control" id="nouveau_mot_de_passe_admin" name="nouveau_mot_de_passe_admin" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary" name="modifier_mot_de_passe_administrateur">Modifier</button>
</form>
    </div>
</div>
<div id="myModal6" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span>
    <h5 class="modal-title">Supprimer un Administrateur</h5>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom et prénom</th>
                <th>Nom d'utilisateur</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $administrateurs = $administrateur->getAllAdmin();
            foreach ($administrateurs as $admin) {
                echo "<tr><form method='POST'>";
                echo "<td>" . $admin['id'] . "</td>";
                echo "<input type='hidden' name='id_admin' value='" . $admin['id'] . "'>";
                echo "<td>" . $admin['nom_prenom'] . "</td>";
                echo "<td>" . $admin['nom_utilisateur'] . "</td>";
                echo "<td><button class='btn btn-danger' name='supprimer_administrateur'>Supprimer</button></form></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>
<div id="myModal7" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span>
    <h5 class="modal-title">Ajouter un article</h5>
    <br>
    <form method="POST">
        <div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" class="form-control" id="titre" name="titre" required>
        </div>
        <div class="form-group">
            <label for="descrip">Description :</label>
            <textarea class="form-control" id="descrip" name="descrip" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="contenu">Contenu :</label>
            <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="auteur">Auteur :</label>
            <input type="text" class="form-control" id="auteur" name="auteur" required>
        </div>
        <div class="form-group">
            <label for="date_publication">Date de publication :</label>
            <input type="date" class="form-control" id="date_publication" name="date_publication" required>
        </div>
        <div class="form-group">
            <label for="img">Image :</label>
            <input type="file" class="form-control" id="img" name="img" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary" name="ajouter_article">Ajouter</button>
</form>
</div>
</div>
<div id="myModal8" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span>
    <h5 class="modal-title">Modifier un article</h5>
    <br>
    <form method="POST">
        <div class="form-group">
            <label for="titre">Titre article à modifier :</label>
            <input type="text" class="form-control" id="titre" name="titre" required>
        </div>
        <div class="form-group">
            <label for="descrip">Description :</label>
            <textarea class="form-control" id="descrip" name="descrip" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="contenu">Contenu :</label>
            <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="auteur">Auteur :</label>
            <input type="text" class="form-control" id="auteur" name="auteur" required>
        </div>
        <div class="form-group">
            <label for="date_publication">Date de publication :</label>
            <input type="date" class="form-control" id="date_publication" name="date_publication" required>
        </div>
        <div class="form-group">
            <label for="img">Image :</label>
            <input type="file" class="form-control" id="img" name="img" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary" name="modifier_article">Modifier</button>
</form>
</div>
</div>
<div id="myModal9" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span>
    <h5 class="modal-title">Supprimer un article</h5>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $articles = $article->getAllArticles();
            foreach ($articles as $art) {
                echo "<tr><form method='POST'>";
                echo "<td>" . $art['id_article'] . "</td>";
                echo "<input type='hidden' name='id_article' value='" . $art['id_article'] . "'>";
                echo "<td>" . $art['titre'] . "</td>";
                echo "<td>" . $art['descrip'] . "</td>";
                echo "<td><button class='btn btn-danger' name='supprimer_article'>Supprimer</button></form></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>
<div id="myModal10" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span>
    <h5 class="modal-title">Supprimer un débat</h5>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Token</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $debats = $debat->getAllDebats();
            foreach ($debats as $deb) {
                echo "<tr><form method='POST'>";
                echo "<td>" . $deb['id'] . "</td>";
                echo "<input type='hidden' name='id_msg' value='" . $deb['id'] . "'>";
                echo "<td>" . $deb['token'] . "</td>";
                echo "<td>" . $deb['msg'] . "</td>";
                echo "<td><button class='btn btn-danger' name='supprimer_debat'>Supprimer</button></form></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>
<div id="myModal11" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span>
    <h5 class="modal-title">Confirmation de suppression</h5>
    <br>
<div class="modal-body">
    <p>Voulez-vous vraiment supprimer tout les éléments ?</p>
</div>
<form method='POST'>
    <button type="submit" class="btn btn-danger" name="confirm_suppression">Confirmer</button>
</form>
</div>
</div>
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="vendor/twbs/bootstrap/js/tests/unit/jquery.spec.js"></script>
<script src="vendor/andcarpi/laravel-popper/resources/js/popper.min.js"></script>
<script src="vendor/components/jquery/jquery.min.js"></script>
<script>
    function afficherConfirmationSuppressionMessages() {
        $('#modalConfirmationSuppressionMessages').modal('show');
    }
    
    function confirmerSuppression(id) {
        $('#id_suppression').val(id); 
        $('#modalConfirmSuppression').modal('show'); 
    }
    function supprimerElement() {
        var id = $('#id_suppression').val();
            $.ajax({
                type: 'POST',
                url: 'supprimer_element.php',
                data: {id: id},
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
$(document).ready(function() {
$('#1').click(function() {
    $('#myModal1').css('display', 'block');
});
$('.close').click(function() {
    $('#myModal1').css('display', 'none');
});
});
$(document).ready(function() {
$('#2').click(function() {
    $('#myModal2').css('display', 'block');
});
$('.close').click(function() {
    $('#myModal2').css('display', 'none');
});
});
$(document).ready(function() {
$('#3').click(function() {
    $('#myModal3').css('display', 'block');
});
$('.close').click(function() {
    $('#myModal3').css('display', 'none');
});
});
$(document).ready(function() {
$('#4').click(function() {
    $('#myModal4').css('display', 'block');
});
$('.close').click(function() {
    $('#myModal4').css('display', 'none');
});
});
$(document).ready(function() {
$('#5').click(function() {
    $('#myModal5').css('display', 'block');
});
$('.close').click(function() {
    $('#myModal5').css('display', 'none');
});
});
$(document).ready(function() {
$('#6').click(function() {
    $('#myModal6').css('display', 'block');
});
$('.close').click(function() {
    $('#myModal6').css('display', 'none');
});
});
$(document).ready(function() {
$('#7').click(function() {
    $('#myModal7').css('display', 'block');
});
$('.close').click(function() {
    $('#myModal7').css('display', 'none');
});
});
$(document).ready(function() {
$('#8').click(function() {
    $('#myModal8').css('display', 'block');
});
$('.close').click(function() {
    $('#myModal8').css('display', 'none');
});
});
$(document).ready(function() {
$('#9').click(function() {
    $('#myModal9').css('display', 'block');
});
$('.close').click(function() {
    $('#myModal9').css('display', 'none');
});
});
$(document).ready(function() {
$('#10').click(function() {
    $('#myModal10').css('display', 'block');
});
$('.close').click(function() {
    $('#myModal10').css('display', 'none');
});
});
$(document).ready(function() {
$('#11').click(function() {
    $('#myModal11').css('display', 'block');
});
$('.close').click(function() {
    $('#myModal11').css('display', 'none');
});
});
</script>
</body>
</html>
