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
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="ressource\logo.png">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <title>الصفحة الرئيسية</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            direction: rtl;
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
        #navbarNav {
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
        select {
            background-color: #fff;
            color: rgb(0, 0, 0) !important;
            border-color: #c5c5c5;
            color: #c5c5c5;
            float : right;
            cursor: pointer;
            outline: none;
            align-items: right;
            width : max-content;
            margin-top : 4px;
        }
        form {
            max-width : 600px;
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
            padding: 10px;
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
            box-shadow : 0 0 20px rgba(0, 0, 0, 0.2);
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
            background-color: rgba(0, 0, 0, 0.4);
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
        <a class="navbar-brand" href="#">فلسطين</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">الأخبار</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">حول</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">اتصل</a>
                </li>
            </ul>
        </div>
    </div>
    <?php if(isset($_GET['token'])) { ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-danger" href="Logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            <?php } else { ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-success" href="Login.php">تسجيل الدخول</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-success" href="Signup.php">سجل</a>
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
                <h2 class="blog-post-title">الصورة المؤلمة من غزة تفوز بجائزة أفضل صورة صحفية في العالم 2024</h2>
                <img src="ressource/1.png" class="img-fluid rounded" alt="صورة المقال">
                    <p class="blog-post-meta">نشر في 17 أكتوبر 2023 بواسطة <a href="https://www.instagram.com/mohammedsalem85/?hl=en">محمد سالم</a></p>
                    <p>الصورة الفائزة المؤثرة بجائزة أفضل صورة صحفية في العام تصور امرأة فلسطينية تحتضن جثمان ابنة أختها...</p>
                    <a href="#" class="btn btn-primary btn-read-more">اقرأ المزيد</a>
                    <br>
                    <br>
                    <p>فاز مصور رويترز محمد سالم بجائزة أفضل صورة صحفية في العالم لهذا العام بصورة تصور فقدان أحد الأحباء في غزة.
                        تظهر الصورة المؤثرة امرأة فلسطينية تحتضن جثمان ابنة أختها الصغيرة.
                        الصورة، التي التُقطت في 17 أكتوبر 2023، في مستشفى ناصر في خان يونس، جنوب قطاع غزة، تصور إيناس أبو معمر، 36 عامًا، تحمل سالي، خمس سنوات، التي قتلت مع والدتها وشقيقتها عندما ضرب صاروخ إسرائيلي منزلهم.
                    </p>
                    <img src="ressource/2.png" class="img-fluid rounded" alt="صورة المقال" id="index">
                    <br>
                    <br>
                </div>
            </div>
            <div class="blog-post">
                <div class="blog-post-content">
                    <h2 class="blog-post-title">قصف مكثف يضرب قطاع غزة: 240 فلسطينياً قتلوا</h2>
                    <img src="ressource/3.png" class="img-fluid rounded" alt="صورة المقال">
                    <p class="blog-post-meta">نشر في 20 أبريل 2024 بواسطة <a href="#">اسم المؤلف</a></p>
                    <p>قصف مكثف يضرب قطاع غزة: 240 فلسطينياً قتلوا منذ استئناف القتال بعد انتهاء الهدنة بمخالفة من الجانبين. أسرائيل استدعت مبعوثيها إلى قطر، حيث كان يُناقش اتفاق هدنة جديد....</p>
                    <a href="#" class="btn btn-primary btn-read-more">اقرأ المزيد</a>
                    <br>
                    <br>
                    <p>فاز مصور رويترز محمد سالم بجائزة أفضل صورة صحفية في العالم لهذا العام بصورة تصور فقدان أحد الأحباء في غزة.
                        تظهر الصورة المؤثرة امرأة فلسطينية تحتضن جثمان ابنة أختها الصغيرة.
                        الصورة، التي التُقطت في 17 أكتوبر 2023، في مستشفى ناصر في خان يونس، جنوب قطاع غزة، تصور إيناس أبو معمر، 36 عامًا، تحمل سالي، خمس سنوات، التي قتلت مع والدتها وشقيقتها عندما ضرب صاروخ إسرائيلي منزلهم.
                    </p>
                    <br>
                    <br>
                </div>
            </div>
            <div class="blog-post">
                <div class="blog-post-content">
                    <h2 class="blog-post-title">توترات إيران-إسرائيل: انفجارات في إيران، والعديد من الدول تدعو إلى تهدئة الأوضاع</h2>
                    <img src="ressource/4.png" class="img-fluid rounded" alt="صورة المقال">
                    <p class="blog-post-meta">نشر في 20 أبريل 2024 بواسطة <a href="#">اسم المؤلف</a></p>
                    <p>سُمعت عدة انفجارات في إيران في وقت مبكر يوم الجمعة. يزعم النظام أنه حال دون تنفيذ هجمات بالطائرات المسيرة...</p>
                    <a href="#" class="btn btn-primary btn-read-more">اقرأ المزيد</a>
                    <br>
                    <br>
                    <p>يُؤكد بنيامين نتنياهو أن إسرائيل "تحتفظ بحقها في الدفاع عن نفسها" ضد إيران، حيث يفكر حكومته بشكل مزعوم في شن ضربات رد فعلية سريعة ضد طهران بعد الهجوم في نهاية الأسبوع الماضي.
                    قرر الاتحاد الأوروبي هذا الأسبوع استهداف إيران بعقوبات ضد منتجي الطائرات بدون طيار والصواريخ لـ "إرسال رسالة واضحة بعد الهجوم على إسرائيل."
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
            echo '<div class="blog-post-content" style="overflow: hidden; max-height : 600px;">';
            echo '<h2 class="blog-post-title">' . $row["titre"] . '</h2>';
            echo '<img src="ressource/'. $row["img"] .'" class="img-fluid rounded" alt="صورة المقال">';
            echo '<p class="blog-post-meta">نشر في ' . $row["date_publication"] . ' بواسطة <a href="#">' . $row["auteur"] . '</a></p>';
            echo '<p>' . $row["descrip"] . '</p>';
            echo '<a href="#" class="btn btn-primary btn-read-more">اقرأ المزيد</a>';
            echo '<br>';
            echo '<br>';
            echo '<p>' . $row["contenu"] . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "لا توجد نتائج";
    }
} catch(PDOException $e) {
    echo "خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage();
}
$conn = null;
?>
        </div>
            <?php if(isset($_GET['token'])) { ?>
                <div class="col-md-4">
            <div class="blog-post">
                <div class="blog-post-content">
                    <h3 class="blog-post-title">من نحن</h3>
                    <p>مرحبًا بك في مدونتنا المخصصة لفلسطين. فريقنا متحمس لتعزيز الفهم والوعي بالقضايا المتعلقة بفلسطين. نحن نؤمن بأهمية إعطاء الصوت لأي شخص يرغب في مشاركة وجهات نظره والمشاركة في النقاشات البناءة حول هذا الموضوع الحيوي.</p>
                    <a href="debat.php?token=<?php echo $_GET['token']; ?>" class="btn btn-primary">تعرف أكثر</a>
                </div>
            </div>
            <?php } else { ?>
                <div class="col-md-4">
            <div class="blog-post">
                <div class="blog-post-content">
                    <h3 class="blog-post-title">من نحن</h3>
                    <p>مرحبًا بك في مدونتنا المخصصة لفلسطين. فريقنا متحمس لتعزيز الفهم والوعي بالقضايا المتعلقة بفلسطين. نحن نؤمن بأهمية إعطاء الصوت لأي شخص يرغب في مشاركة وجهات نظره والمشاركة في النقاشات البناءة حول هذا الموضوع الحيوي.</p>
                    <a href="Login.php" class="btn btn-primary">تعرف أكثر</a>
                </div>
            </div>
            <?php } ?>

            <?php
            if(isset($_GET['token'])) {
            echo '<div class="blog-post">';
                echo '<div class="blog-post-content">';
                        echo '<div id="btnContainer" class="btn-container">';
                        echo '<a href="#" id="writeArticleBtn"><img src="ressource/art.png" class="img-fluid rounded" alt="صورة المقال">';
                        echo '<button class="btn btn-primary" id="writeArticleBtn">اكتب مقالًا</button></a>';
                        echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '<div class="blog-post">';
                echo '<div class="blog-post-content">';
                        echo '<div id="btnContainer" class="btn-container">';
                        echo '<a href="#" id="writeArticleBtn"><img src="ressource/msg.png" class="img-fluid rounded" alt="صورة المقال">';
                        echo "<a href='debat.php?token=" . $_GET["token"] . "' class='btn btn-primary'>انضم إلى النقاش</a>";
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            }else {
                echo '<div class="blog-post">';
                echo '<div class="blog-post-content">';
                        echo '<div id="btnContainer" class="btn-container">';
                        echo '<a href="Login.php" id="writeArticleBtn"><img src="ressource/art.png" class="img-fluid rounded" alt="صورة المقال">';
                        echo '<button class="btn btn-primary" id="writeArticleBtn">اكتب مقالًا</button></a>';
                        echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '<div class="blog-post">';
                echo '<div class="blog-post-content">';
                        echo '<div id="btnContainer" class="btn-container">';
                        echo '<a href="#" id="writeArticleBtn"><img src="ressource/msg.png" class="img-fluid rounded" alt="صورة المقال">';
                        echo "<a href='Login.php' class='btn btn-primary'>انضم إلى النقاش</a>";
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            }
            ?>
            
        </div>
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
