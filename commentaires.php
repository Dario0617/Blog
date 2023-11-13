<?php
session_start();
?>
<html lang="fr">
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="https://kit.fontawesome.com/d576863e16.js" crossorigin="anonymous"></script>
</head>
<header>
    <div class="row" style="margin-top: 20px; margin-bottom: 20px; padding-left: 20px; padding-right:20px;">
        <div class="col-12" style="padding-left: 5%;">
            <ul class="nav nav-tabs justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i>&nbsp;Accueil</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='profile.php'><i class="fa-solid fa-circle-user"></i>&nbsp;Profil</a>
                </li>
                <?php
                if( isset( $_SESSION['role']) && ($_SESSION['role'] == 2) ){
                    echo "<li class='nav-item'><a class='nav-link' href='UserManagement.php'><i class='fa-solid fa-users-gear'></i></i>&nbsp;Gestion des utilisateurs</a></li>";
                }
                if( isset( $_SESSION['role']) && ($_SESSION['role'] == 2) ){
                    echo "<li class='nav-item'><a class='nav-link' href='profile.php'><i class='fa-solid fa-comments'></i></i>&nbsp;Modération des commentaires</a></li>";
                }
                if( isset( $_SESSION['role']) && $_SESSION['role'] != 1 ){
                    echo "<li class='nav-item'><a class='nav-link' href='createdTicket.php'><i class='fa-solid fa-ticket'></i>&nbsp;Création d'un billet</a></li>";
                }?>
                <li class='nav-item'>
                    <a class='nav-link' style='color:red' href='logout.php'><i class='fa-solid fa-door-open'></i>&nbsp;Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</header>
<?php

$idBillet = $_GET['idBillet'];

try {
    $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
} catch( Exception $e) {
    die( 'Erreur : ' . $e->getMessage() );
}
$sql = 'SELECT * FROM billets WHERE id=:id';
$reponse = $bdd->prepare( $sql );
$reponse->execute([':id' => $idBillet]);
$tableBlog = $reponse->fetchAll(PDO::FETCH_ASSOC);

$sql = 'SELECT * FROM commentaires WHERE id_billet=:id';
$reponse = $bdd->prepare( $sql );
$reponse->execute([':id' => $idBillet]);
$tableCommentaires = $reponse->fetchAll(PDO::FETCH_ASSOC);

?>
<body>
<section class="container mt-5">
    <div class="row">
        <div class="col-12">
            <?php 
            foreach($tableBlog as $key => $val){
            ?>
                <div class="card">
                    <h5 class="card-header">Publié le <?=date("d/m/Y à H:i:s", strtotime($val['date_creation']))?></h5>
                    <div class="card-body">
                        <h5 class="card-title"><?=$val['titre']?></h5>
                        <p class="card-text"><?=$val['contenu']?></p>
                    </div>
                </div>
            <?php
                }
            ?>
        </div>
    </div>
</section>

<section class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <h3>Commentaires</h3>
               <button type="button" class="btn btn-outline-primary btn-lg" style="margin-bottom: 15px" data-toggle="modal" data-target="#exampleModal" id="createCommentaryModal"><i class="fa-solid fa-comment-medical"></i>&nbsp;Création d'un commentaire</button>
            </div>
            <?php
                foreach($tableCommentaires as $key => $val){
            ?>
            <div class="list-group col-12">
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?=$val['auteur']?></h5>
                        <small><?=$val['auteur']?> le <?=date("d/m/Y à H:i:s", strtotime($val['date_commentaire']))?></small>
                    </div>
                    <div class="d-flex align-items-center row">
                        <p class="mb-1 col-11"><?=$val['commentaire']?></p>
                        <button type="submit" class="btn btn-danger col-1"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</section>

<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form name="accesform" method="post" action="saveCommentaire.php">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-comment-medical"></i>&nbsp;Création d'un commentaire</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="commentaryText" name="commentaryText" required></textarea>
                <input type="hidden" id="idBillet" name="idBillet" value="<?=$idBillet?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" data-dismiss="modal">Fermer</button>
                <button type="submit" id="saveCommentary" class="btn btn-primary">Sauvegarder le commentaire</button>
            </div>
        </form>
    </div>
  </div>
</div>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        const elem = document.getElementById("createCommentaryModal");
        elem.onclick = function() {
            document.getElementById("exampleModal").style.display = 'block';
        };

        const elem2 = document.getElementsByClassName("close");
        elem2[0].onclick = function() {
            document.getElementById("exampleModal").style.display = 'none';
        };
        elem2[1].onclick = function() {
            document.getElementById("exampleModal").style.display = 'none';
        };
});
</script>
</body>
</html>