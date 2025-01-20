<?php
session_start();
require_once './include/db.php';

if (isset($_SESSION['userid']) && isset($_SESSION['session'])) {
    $statement = $conn->prepare("SELECT session FROM benutzer WHERE id = :user_id");
    $statement->execute(['user_id' => $_SESSION['userid']]);
    $user = $statement->fetch();

    if ($user !== false && $user['session'] !== $_SESSION['session']) {
        // Session-Hash stimmt nicht überein, daher Benutzer abmelden oder auf Login-Seite umleiten
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit;
    }
} else {
    // Keine gültige Session, auf Login-Seite umleiten
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html> 
<html lang="de"> 
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Meine Website als Ek" />
        <meta name="author" content="Jenna Nottelmann" />
        <title>Geheime Seite</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Custom Google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/secretstyle.css">
        
</head> 
<body> 
<?php require_once "./include/navbar.php"; ?>
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-lg-18 col-xl-10 align-self-center container-secret">
                    
                <h1>Willkommen, du bist eingeloggt!</h1>
                <h3>Diese Seite ist nur für registrierte Benutzer zugänglich.</h3> 
                <p>Vollständiger Name:Jenna Nottelmann </p> 
                <p>Adresse: Bonnstraße 34, 45470 Mülheim an der Ruhr</p> 
                <p>Was hier steht soll nur durch Login sichtbar sein</p>
                <img src="assets/pic3.jpg" alt="" style="width: 340px; height: auto;">
                <a href="include/logout.php"><button type="submit" class="btn-logout btn btn-primary">Abmelden</button></a>
                    
            </div> 
        </div> 
    </div> 
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 
    <?php require_once "./include/footer.php"; ?>
</body> 
</html> 