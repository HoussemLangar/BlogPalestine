<?php
require_once 'connect.php';
session_start();
$messages = [];
if(isset($_POST['message']) && !empty($_POST['message'])) {
    try {
        $conn = new PDO('mysql:host=' . $servername . ';dbname=' . $dbname, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $token = $_SESSION['nom_utilisateur'];
        $message = $_POST['message'];

            $sql = "INSERT INTO debat (token, msg) VALUES (:token, :message)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':token', $token); 
            $stmt->bindParam(':message', $message);

            if($stmt->execute()) {
                try {
                    $sql = "SELECT token, msg, creer_en FROM debat ORDER BY id DESC";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch(PDOException $e) {
                    echo 'Erreur de récupération des messages : ' . $e->getMessage();
                }
            } else {
                echo "Error sending message";
            }
    } catch(PDOException $e) {
        echo 'Erreur de connexion : ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="ressource\logo.png">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <title>Discussion</title>
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
        .navbar-brand {
            color: #fff;
            font-weight: bold;
        }
        .blog-post {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom : 30px;
        }
        .blog-post-title {
            color: #333;
            font-size: 24px;
            font-weight: bold;
        }
        .blog-post-meta {
            color: #999;
            font-size: 14px;
        }
        .blog-post-content {
            padding: 20px;
            max-height : 700px;
            overflow: hidden;
        }
        #navbarNav{
            margin-left : 900px;
        }
        .nav-link.btn-outline-success {
            color: #fff;
            border: 2px solid #007bff;
            margin-right : 5px;
        }
        .nav-link.btn-outline-success:hover {
            background-color: #007bff;
            border-color: #007bff;
        }
        #index {
            max-width : 80%;
            margin-left : 110px;
        }
        .btn-primary {
            display: block; 
            width : 100%; 
            box-sizing: border-box;
        }
        .nav-link.btn-outline-danger {
            color: #dc3545; 
            border: 2px solid #dc3545; 
            border-radius: 4px; 
            margin-right : 5px;
        }
        .nav-link.btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff; 
            border-color: #dc3545;
        }
        select{
            background-color: #fff;
            color: rgb(0, 0, 0) !important;
            border-color:#c5c5c5;
            color: #c5c5c5;
            float : right;
            cursor: pointer;
            outline: none;
            align-items: right;
            width : max-content;
            margin-top : 4px;
        }
        
        label {
            display: block;
            margin-bottom : 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="file"],
        textarea {
            width : 100%;
            padding : 10px;
            margin-bottom : 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
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
<video id="video-background" autoplay loop muted>
        <source src="ressource\video1.mp4" type="video/mp4">
    </video>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Palestine</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="Accueil_fr.php?token=<?php echo $_GET['token']; ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Accueil_fr.php?token=<?php echo $_GET['token']; ?>">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Accueil_fr.php?token=<?php echo $_GET['token']; ?>">Contact</a>
                </li>
            </ul>
        </div>
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
            <?php } ?>
</nav>
<select id="language-select">
    <option value="fr">French</option>
    <option value="en">English</option>
    <option value="ar">Arabic</option>
</select>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Discussion
                    </div>
                    <form  action="" method="post">
                    <div class="card-body" id="chatbox">
<?php
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT  token, msg, creer_en FROM debat ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="message">';
            echo '<strong> '.$row['token'] .':</strong> .'. $row['msg'] .' <br>à </strong> '. $row['creer_en'] .' ';
            echo '</div>';
        }
    } else {
        echo "Aucun résultat trouvé";
    }
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}
$conn = null;
?>
                    </div>
                    <div class="card-footer">
                        <div class="input-group">
                            <input type="text" class="form-control" id="message" name='message' placeholder="Type your message...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="sendMessageBtn">Send</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/components/jquery/jquery.min.js"></script>
    <script src="vendor/andcarpi/laravel-popper/resources/js/popper.min.js"></script>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#sendMessageBtn').click(function() {
                var message = $('#messageInput').val();
                if(message.trim() != '') {
                    $.ajax({
                        url: 'this_file_name.php',
                        type: 'POST',
                        data: { message: message },
                        success: function(response) {
                            $('#messageInput').val(''); 
                            $('#chatbox').html(response);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
