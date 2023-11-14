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
        <div class="row" style="margin-top: 20px; margin-bottom: 20px; padding-left: 20px; padding-right:20px;">
            <div class="col-3">
                <h1>Création d'un billet</h1>
            </div>
            <div class="col-9">
                <ul class="nav nav-tabs justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="Index.php"><i class="fa-solid fa-house"></i>&nbsp;Accueil</a>
                    </li>
                    <?php if( isset( $_SESSION['connected'] ) ){
                        echo "<li class='nav-item'><a class='nav-link' href='Profile.php'><i class='fa-solid fa-circle-user'></i>&nbsp;Profil</a></li>";
                    } 
                    if( isset( $_SESSION['role']) && ($_SESSION['role'] == 2) ){
                        echo "<li class='nav-item'><a class='nav-link' href='UserManagement.php'><i class='fa-solid fa-users-gear'></i></i>&nbsp;Gestion des utilisateurs</a></li>";
                    }
                    if( isset( $_SESSION['role']) && ($_SESSION['role'] == 2) ){
                        echo "<li class='nav-item'><a class='nav-link' href='Profile.php'><i class='fa-solid fa-comments'></i></i>&nbsp;Modération des commentaires</a></li>";
                    }
                    if( isset( $_SESSION['role']) && $_SESSION['role'] != 1 ){
                        echo "<li class='nav-item'><a class='nav-link active' href='CreatedTicket.php'><i class='fa-solid fa-ticket'></i>&nbsp;Création d'un billet</a></li>";
                    }if( isset( $_SESSION['connected'] ) ){
                        echo "<li class='nav-item'><a class='nav-link' style='color:red' href='Logout.php'><i class='fa-solid fa-door-open'></i>&nbsp;Déconnexion</a></li>";
                    } ?>
                </ul>
            </div>
            <div class="row" style="margin-bottom: 10px">
                <div class="col-12">
                    <h4>Bienvenue <?php echo $login?></h4>
                </div>
            </div>
        </div>
    </header>

    <section class="container mt-5">
        <div class="row">
            <div class="col-12">
                <form name="accesform" method="post" action="ValidecreatedTicket.php">

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