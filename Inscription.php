<?php
session_start();
?>
<html lang="fr">
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="https://kit.fontawesome.com/d576863e16.js" crossorigin="anonymous"></script>
    <title> Inscription </title>
</head>

<?php
$mess = '';
$login = '';
if( isset( $_GET['error'] ) ) {
    if( isset( $_GET['loginerror'] ) ) {
        $alert = 'alert-danger';
        $mess = 'Erreur : Ce login existe déjà ! </br> Veuillez vous connectez <a href="Connexion.php" class="link-danger">Connexion</a>';
    }
    if( isset( $_GET['passerror'] ) ) {
        $alert = 'alert-danger';
        $mess = 'Erreur : Le mot de passe doit contenir au minimum 8 caractères !';
        if( isset( $_SESSION['login'] ) ) {
            $login = $_SESSION['login'];
            session_destroy();
        }
    }
    if( isset( $_GET['confirmPasserror'] ) ) {
        $alert = 'alert-danger';
        $mess = 'Erreur : Les mots de passe doivent être identiques !';
        if( isset( $_SESSION['login'] ) ) {
            $login = $_SESSION['login'];
            session_destroy();
        }
    }
}

if (isset( $_SESSION['login'])){
    $login = $_SESSION['login'];
    session_destroy();
}

if( isset( $_GET['validation'] ) ){
    $alert = 'alert-success';
    $mess = 'Votre accès a était enregistré';
}
?>
<body>
    <header>
        <div class="row" style="margin-top: 20px; padding-left: 20px; padding-right:20px;">
            <div class="col-8">
                <h1>Formulaire d'inscription</h1>
            </div>
            <div class="col-4">
                <ul class="nav nav-tabs justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fa-solid fa-house"></i>&nbsp;Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Connexion.php"><i class="fa-solid fa-circle-user"></i>&nbsp;Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Inscription.php"><i class="fa-solid fa-user-plus"></i>&nbsp;Inscription</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <section class="container mt-5">
        <?php
        if( isset( $_GET['error'] ) || isset( $_GET['validation'] )  ) {
            echo '<div class="row"><p class="col-10 alert '.$alert.'">' . $mess .'</p></div>';
        }
        ?>
        <div class="row">
            <div class="col-12">
                <form name="accesform" method="post" action="ValideInscription.php">

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
                    <div class="mb-3 row">
                        <label for="inputConfirmPassword" class="col-sm-2 col-form-label">Confirmer mot de passe</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="inputConfirmPassword" name="confirmPassword" required>
                        </div>
                    </div>

                    <div class="mb-3 row ">
                            <div class="col-sm-8">
                                <a href="Connexion.php" class="link-info">J'ai déjà un compte</a>
                            </div>
                            <div class="col-sm-4 justify-content-end">
                                <button type="submit" class="btn btn-primary mb-3">Inscription</button>
                            </div>
                        </div>

                </form>
            </div>
        </div>
    </section>

    <footer class="container"></footer>

</body>