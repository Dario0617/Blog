<!DOCTYPE html>
<head>
    <meta charset="ISO-8859"/>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <title> Connexion </title>
</head>

<?php
session_start();
$mess = "";
$login= "";
if (isset($_GET["passerror"])){
    $mess = "Erreur : Votre mot de passe est non valide";
}
if (isset($_GET["loginerror"])){
    $mess = 'Erreur : Votre login est non valide ! </br> Avez-vous un compte ? </br> Créer vous un compte ici <a href="Inscription.php" class="link-danger">Inscription</a>';
}

if (isset( $_SESSION['login'])){
    $login = $_SESSION['login'];
    session_destroy();
}
?>

<body>
    <header>
        <div class="row" style="margin-top: 20px; padding-left: 20px; padding-right:20px;">
            <div class="col-8">
                <h1>Formulaire de connexion</h1>
            </div>
            <div class="col-4">
                <ul class="nav nav-tabs justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/>
                            </svg>
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="connexion.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                            </svg>
                        Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Inscription.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        Inscription</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <section class="container mt-5">
        <div class="row">
            <div class="col-12">
                <form name="accesform" method="post" action="ValideConnexion.php">
                    <?php
                        if (isset($_GET["error"])){
                            echo '<div class="alert alert-danger" role="alert">' . $mess .'</div>';
                        }
                        if (isset( $_SESSION['isRegister'])){
                            echo '<div class="alert alert-success" role="alert">Votre compte est créer <br> Veuillez vous connecter</div>';
                        }
                    ?>  
                    <div class="mb-3 row">
                        <label for="login" class="col-sm-2 col-form-label">Login</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="login" value="<?=$login?>" placeholder="Votre login" name="login" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Mot de passe</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="inputPassword" name="password" required>
                        </div>
                    </div>
                    <div class="mb-3 row ">
                        <div class="col-sm-8">
                            <a href="Inscription.php" class="link-info">Je n'ai pas de compte</a>
                        </div>
                        <div class="col-sm-4 justify-content-end">
                            <button type="submit" class="btn btn-primary mb-3">Connexion</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

</body>
</html>