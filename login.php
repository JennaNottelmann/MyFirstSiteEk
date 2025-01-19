<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Meine Website als Ek" />
        <meta name="author" content="Jenna Nottelmann" />
        <title>Login</title>
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
        <link rel="stylesheet" href="css/logstyle.css">
</head>
<?php
require_once './include/db.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(!empty($username) && !empty($password)) {
        $statement = $conn->prepare("SELECT id, passwort FROM benutzer WHERE benutzername = :benutzer");
        $result = $statement->execute(array('benutzer' => $username));
        $user = $statement->fetch();

        // Überprüfung des Passworts
        if ($user !== false && $password === $user['passwort']) {
            // Generiere einen sicheren Session-Hash
            $sessionHash = hash('sha256', session_id() . time() . rand());

            // Speichern des Session-Hashes in der Datenbank
            $updateStatement = $conn->prepare("UPDATE benutzer SET session = :session_hash WHERE id = :user_id");
            $updateStatement->execute([
                'session_hash' => $sessionHash,
                'user_id' => $user['id']
            ]);

            // Setze den Hash in der Session
            $_SESSION['userid'] = $user['id'];
            $_SESSION['session'] = $sessionHash;

            // Umleitung auf den internen Bereich
            header('Location: secret.php');
        } else {
            $error = "Benutzername oder Passwort war ungültig<br>";
        }
    } else {
        $error = "Bitte füllen Sie alle Felder aus!";
    }
}
?>


<body class="d-flex flex-column h-100">
        <?php require_once "./include/navbar.php"; ?>
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-4 align-self-center container-login">
                    <h1>Login</h1> 
                    <form action="login.php" method="post"> 
                        <div class="form1-group"> 
                            <label for="username">Benutzername:</label> 
                            <input type="text" class="form1-control" name="username" id="username" placeholder="Enter Username"> 
                        </div> 
                        <div class="form1-group"> 
                            <label for="password">Passwort:</label> 
                            <input type="password" class="form1-control" name="password" id="password" placeholder="Enter Password"> 
                        </div>
                        <?php
                            if(!empty($error)) {
                                echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
                            }
                        ?>
                        <button type="submit" class="btn-login btn btn-primary">Einloggen</button> 
                    </form> 
                </div>
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 
    <?php require_once "./include/footer.php"; ?>

</body> 
</html> 
