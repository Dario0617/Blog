<?php
session_start();
?>
<html lang="fr">
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <title> Inscription </title>
</head>

<?php
$mess = '';
$login = '';
if( isset( $_GET['error'] ) ) {
    if( isset( $_GET['loginerror'] ) ) {
        $alert = 'alert-danger';
        $mess = 'Erreur : Ce login existe déjà ! </br> Veuillez vous connectez <a href="connexion.php" class="link-danger">Connexion</a>';
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
                        <a class="nav-link" href="index.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/>
                            </svg>
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="connexion.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                            </svg>
                        Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Inscription.php">
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
                                <a href="connexion.php" class="link-info">J'ai déjà un compte</a>
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