<?php
session_start();
?>
<html lang="fr">
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="https://kit.fontawesome.com/d576863e16.js" crossorigin="anonymous"></script>
    <title> Création d'un billet </title>
</head>

<?php
$login = '';

if (isset( $_SESSION['login'])){
    $login = $_SESSION['login'];
}
?>
<body>
    <header>
        <div class="row" style="margin-top: 20px; padding-left: 20px; padding-right:20px;">
            <div class="col-8">
                <h1>Création d'un billet</h1>
            </div>
            <div class="row" style="margin-bottom: 10px">
                <div class="col-9">
                    <h4>Bienvenue <?php echo $login?></h4>
                </div>
                <div class="col-3" style="display: flex;justify-content: space-evenly;">
                    <a class="btn btn-outline-primary" href="index.php"><i class="fa-solid fa-house"></i>&nbsp;Accueil</a>
                    <a class="btn btn-outline-danger" href="connexion.php">Déconnexion</a>
                </div>
            </div>
        </div>
    </header>

    <section class="container mt-5">
        <div class="row">
            <div class="col-12">
                <form name="accesform" method="post" action="validecreatedTicket.php">

                    <div class="mb-3 row">
                        <label for="titre" class="col-sm-2 col-form-label">Titre</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="titre" name="titre" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="contenu" class="col-sm-2 col-form-label">Contenu</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" id="contenu" name="contenu" required></textarea>
                        </div>
                    </div>
                    
                    <div class="mb-3 row ">
                            <div class="col-sm-4 justify-content-end">
                                <button type="submit" class="btn btn-primary mb-3">Création</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </section>

    <footer class="container"></footer>

</body>