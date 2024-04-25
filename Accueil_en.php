<?php
require_once 'connect.php';

try {
    $con = new PDO('mysql:host=localhost;dbname=bd_blog;', 'root', '');
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch(PDOException $exception) {
    echo "Erreur de connexion : " . $exception->getMessage();
}


if(isset($_POST["submit"])) {
    $titre = $_POST['title'];
    $description = $_POST['descrip'];
    $contenu = $_POST['content'];
    $auteur = $_POST['auteur'];
    $date_publication = $_POST['date_publication'];
    $image = $_FILES['img']['name'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["img"]["name"]);
    move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
    

    $query = "INSERT INTO articles (titre, descrip, contenu, auteur, date_publication, img) VALUES (:titre, :description, :contenu, :auteur, :date_publication, :image)";

    $stmt = $con->prepare($query);

    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':contenu', $contenu);
    $stmt->bindParam(':auteur', $auteur);
    $stmt->bindParam(':date_publication', $date_publication);
    $stmt->bindParam(':image', $image);

    if($stmt->execute()) {
        echo "<script> alert ('Article publié avec succès.')</script>";
    } else {
        echo "<script> alert ('Erreur lors de la publication de l'article.')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="ressource\logo.png">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <title>Home</title>
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
        form {
            max-width : 700px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        .language-dropdown {
            position: relative;
            display: inline-block;
        }
        .language-dropdown select {
            padding: 5px 30px 5px 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            appearance: none; 
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #fff;
            cursor: pointer;
        }
        .language-dropdown select::-ms-expand {
            display: none; 
        }
        .language-dropdown::before {
            content: attr(data-icon);
            font-size: 20px;
            position: absolute;
            right : 10px;
            top : 50%;
            transform: translateY(-50%);
            pointer-events: none;
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
                    <a class="nav-link" href="#">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </div>
    <?php if(isset($_GET['token'])) { ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-danger" href="Logout.php">Logout</a>
                    </li>
                </ul>
            <?php } else { ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-success" href="Login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-success" href="Signup.php">Sign Up</a>
                    </li>
                </ul>
            <?php } ?>
</nav>
<div class="language-dropdown">
    <select id="language-select">
        <option value="fr" data-icon="🇫🇷">Français</option>
        <option value="en" data-icon="EN">Anglais</option>
        <option value="ar" data-icon="🇸🇦">العربية</option>
    </select>
</div>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="blog-post">
                <div class="blog-post-content">
                <h2 class="blog-post-title">Heartbreaking Photo from Gaza Wins 2024 World Press Photo of the Year</h2>
                <img src="ressource/1.png" class="img-fluid rounded" alt="Article Image">
                    <p class="blog-post-meta">Published on October 17, 2023 by <a href="https://www.instagram.com/mohammedsalem85/?hl=en">Mohammed Salem</a></p>
                    <p>The poignant winning photo of this year's World Press Photo of the Year depicts a Palestinian woman cradling the body of her young niece...</p>
                    <a href="#" class="btn btn-primary btn-read-more">Read More</a>
                    <br>
                    <br>
                    <p>Reuters photographer Mohammed Salem won the prestigious World Press Photo of the Year award with an image depicting the loss of a loved one in Gaza.
                        The heartbreaking photo shows a Palestinian woman cradling the body of her young niece.
                        The photo, taken on October 17, 2023, at Nasser Hospital in Khan Younis, southern Gaza Strip, depicts Inas Abu Maamar, 36, holding Saly, five, who was killed with her mother and sister when an Israeli missile struck their home.
                    </p>
                    <img src="ressource/2.png" class="img-fluid rounded" alt="Article Image" id="index">
                    <br>
                    <br>
                </div>
            </div>
            <div class="blog-post">
                <div class="blog-post-content">
                    <h2 class="blog-post-title">Intense Bombardments Pound Gaza Strip: 240 Palestinians Killed</h2>
                    <img src="ressource/3.png" class="img-fluid rounded" alt="Article Image">
                    <p class="blog-post-meta">Published on April 20, 2024 by <a href="#">Author's Name</a></p>
                    <p>Intense bombardments pound the Gaza Strip: 240 Palestinians killed since the resumption of fighting as the ceasefire was breached by both sides. Israel recalled its envoys to Qatar, where a possible new ceasefire was being discussed....</p>
                    <a href="#" class="btn btn-primary btn-read-more">Read More</a>
                    <br>
                    <br>
                    <p>Reuters photographer Mohammed Salem won the prestigious World Press Photo of the Year award with an image depicting the loss of a loved one in Gaza.
                        The heartbreaking photo shows a Palestinian woman cradling the body of her young niece.
                        The photo, taken on October 17, 2023, at Nasser Hospital in Khan Younis, southern Gaza Strip, depicts Inas Abu Maamar, 36, holding Saly, five, who was killed with her mother and sister when an Israeli missile struck their home.
                    </p>
                    <br>
                    <br>
                </div>
            </div>
            <div class="blog-post">
                <div class="blog-post-content">
                    <h2 class="blog-post-title">Iran-Israel Tensions: Explosions in Iran, Many Countries Call for De-escalation</h2>
                    <img src="ressource/4.png" class="img-fluid rounded" alt="Article Image">
                    <p class="blog-post-meta">Published on April 20, 2024 by <a href="#">Author's Name</a></p>
                    <p>Several explosions were heard early Friday in Iran. The state claims to have thwarted drone attacks...</p>
                    <a href="#" class="btn btn-primary btn-read-more">Read More</a>
                    <br>
                    <br>
                    <p>Benjamin Netanyahu asserts that Israel "reserves the right to defend itself" against Iran, as his government reportedly considered swift retaliatory strikes against Tehran after last weekend's attack.
                    The European Union this week decided to target Iran with sanctions against drone and missile producers to "send a clear message after the attack on Israel."
                    </p>
                    <br>
                    <br>
                </div>
            </div>
            <?php
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT titre, descrip, contenu, auteur, date_publication, img FROM articles";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="blog-post">';
            echo '<div class="blog-post-content" style="overflow: hidden; max-height : 700px;">';
            echo '<h2 class="blog-post-title">' . $row["titre"] . '</h2>';
            echo '<img src="ressource/'. $row["img"] .'" class="img-fluid rounded" alt="Article Image">';
            echo '<p class="blog-post-meta">Published on ' . $row["date_publication"] . ' by <a href="#">' . $row["auteur"] . '</a></p>';
            echo '<p>' . $row["descrip"] . '</p>';
            echo '<a href="#" class="btn btn-primary btn-read-more">Read More</a>';
            echo '<br>';
            echo '<br>';
            echo '<p>' . $row["contenu"] . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No results found";
    }
} catch(PDOException $e) {
    echo "Database connection error: " . $e->getMessage();
}
$conn = null;
?>
        </div>
            <?php if(isset($_GET['token'])) { ?>
                <div class="col-md-4">
            <div class="blog-post">
                <div class="blog-post-content">
                    <h3 class="blog-post-title">About Us</h3>
                    <p>Welcome to our blog dedicated to Palestine. Our team is passionate about promoting understanding and awareness around issues related to Palestine. We believe in the importance of giving voice to anyone who wishes to share their perspectives and engage in constructive debates on this crucial subject.</p>
                    <a href="debat.php?token=<?php echo $_GET['token']; ?>" class="btn btn-primary">Learn More</a>
                </div>
            </div>
            <?php } else { ?>
                <div class="col-md-4">
            <div class="blog-post">
                <div class="blog-post-content">
                    <h3 class="blog-post-title">About Us</h3>
                    <p>Welcome to our blog dedicated to Palestine. Our team is passionate about promoting understanding and awareness around issues related to Palestine. We believe in the importance of giving voice to anyone who wishes to share their perspectives and engage in constructive debates on this crucial subject.</p>
                    <a href="Login.php" class="btn btn-primary">Learn More</a>
                </div>
            </div>
            <?php } ?>

            <?php
            if(isset($_GET['token'])) {
            echo '<div class="blog-post">';
                echo '<div class="blog-post-content">';
                        echo '<div id="btnContainer" class="btn-container">';
                        echo '<a href="#" id="writeArticleBtn"><img src="ressource/art.png" class="img-fluid rounded" alt="Article Image">';
                        echo '<button class="btn btn-primary" id="writeArticleBtn">Write an Article</button></a>';
                        echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '<div class="blog-post">';
                echo '<div class="blog-post-content">';
                        echo '<div id="btnContainer" class="btn-container">';
                        echo '<a href="#" id="writeArticleBtn"><img src="ressource/msg.png" class="img-fluid rounded" alt="Article Image">';
                        echo "<a href='debat.php?token=" . $_GET["token"] . "' class='btn btn-primary'>Join the Discussion</a>";
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            }else {
                echo '<div class="blog-post">';
                echo '<div class="blog-post-content">';
                        echo '<div id="btnContainer" class="btn-container">';
                        echo '<a href="Login.php" id="writeArticleBtn"><img src="ressource/art.png" class="img-fluid rounded" alt="Article Image">';
                        echo '<button class="btn btn-primary" id="writeArticleBtn">Write an Article</button></a>';
                        echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '<div class="blog-post">';
                echo '<div class="blog-post-content">';
                        echo '<div id="btnContainer" class="btn-container">';
                        echo '<a href="#" id="writeArticleBtn"><img src="ressource/msg.png" class="img-fluid rounded" alt="Article Image">';
                        echo "<a href='Login.php' class='btn btn-primary'>Join the Discussion</a>";
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <form action="#" method="POST" enctype="multipart/form-data">
        <label for="title">Article Title:</label>
        <input type="text" id="title" name="title">

        <label for="descrip">Article Description:</label>
        <textarea id="descrip" name="descrip"></textarea>

        <label for="content">Article Content:</label>
        <textarea id="content" name="content"></textarea>

        <input type="hidden" id="auteur" name="auteur" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">

        <input type="hidden" id="date_publication" name="date_publication" value="<?php echo date('Y-m-d'); ?>">

        <label for="img">Image:</label>
        <input type="file" id="img" name="img">

        <input type="submit" name="submit" value="Publish Article">
    </form>
  </div>
</div>
<script src="vendor/twbs/bootstrap/js/tests/unit/jquery.spec.js"></script>
<script src="vendor/andcarpi/laravel-popper/resources/js/popper.min.js"></script>
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/components/jquery/jquery.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var btnReadMoreList = document.querySelectorAll('.btn-read-more');

    btnReadMoreList.forEach(function(btnReadMore) {
        var blogPostContent = btnReadMore.closest('.blog-post').querySelector('.blog-post-content');
        var btnReadLess = document.createElement('a'); 
        btnReadLess.textContent = 'Réduire';
        btnReadLess.classList.add('btn', 'btn-primary', 'btn-read-less');
        btnReadLess.href = '#'; 

        btnReadMore.addEventListener('click', function(event) {
            event.preventDefault();
            if (blogPostContent.style.maxHeight) {
                blogPostContent.style.maxHeight = null;
                btnReadMore.style.display = 'block'; 
                btnReadLess.remove(); 
            } else {
                blogPostContent.style.maxHeight = blogPostContent.scrollHeight + 'px';
                btnReadMore.style.display = 'none'; 
                blogPostContent.appendChild(btnReadLess); 
            }
        });

        btnReadLess.addEventListener('click', function(event) {
            event.preventDefault();
            blogPostContent.style.maxHeight = null;
            btnReadMore.style.display = 'block';
            btnReadLess.remove();
        });
    });
});
$(document).ready(function() {
    $('#writeArticleBtn').click(function() {
        $('#myModal').css('display', 'block');
    });
    $('.close').click(function() {
        $('#myModal').css('display', 'none');
    });
});
var modal = document.getElementById("myModal");
var closeBtn = document.getElementsByClassName("close")[0];
closeBtn.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
document.addEventListener('DOMContentLoaded', function() {
    var languageSelect = document.getElementById('language-select');
    languageSelect.addEventListener('change', function() {
        var selectedLanguage = languageSelect.value;

        window.location.href = "Accueil_" + selectedLanguage + ".php";
    });
});
</script>
</body>
</html>