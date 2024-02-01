<?php
session_start();

$style = "";
    if( isset( $_SESSION['connected'] ) ){
        $style = "style='display:none'";
    }

$idBillet = $_GET['idBillet'];

try {
    $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
} catch( Exception $e) {
    die( 'Erreur : ' . $e->getMessage() );
}
$sql = 'SELECT * FROM Ticket WHERE Id=:id';
$reponse = $bdd->prepare( $sql );
$reponse->execute([':id' => $idBillet]);
$tableBlog = $reponse->fetchAll(PDO::FETCH_ASSOC);

$sql = 'SELECT * FROM Comment WHERE TicketId=:id AND Verify=:verify';
$reponse = $bdd->prepare( $sql );
$reponse->execute([':id' => $idBillet, ':verify'=>1]);
$tableCommentaires = $reponse->fetchAll(PDO::FETCH_ASSOC);

$mess = '';
    if( isset( $_GET['validation'] ) ){
        $alert = 'alert-success';
        $mess = 'Commentaire créé avec succès, il va être vérifié par un administrateur';
    }
?>
<html lang="fr">
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="https://kit.fontawesome.com/d576863e16.js" crossorigin="anonymous"></script>
</head>
<header>
    <div class="row" style="margin-top: 1%; margin-bottom: 1%; margin-left: 0%; margin-right: 0%; padding-left: 1%; padding-right: 1%;">
        <div class="col-3">
            <h1>Billet N°<?=$idBillet?></h1>
        </div>
        <div class="col-9">
            <ul class="nav nav-tabs justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i>&nbsp;Accueil</a>
                </li>
                <li class="nav-item" <?=$style?>>
                    <a class="nav-link" href="Connexion.php"><i class="fa-solid fa-circle-user"></i>&nbsp;Connexion</a>
                </li>
                <li class="nav-item" <?=$style?>>
                    <a class="nav-link" href="Inscription.php"><i class="fa-solid fa-user-plus"></i>&nbsp;Inscription</a>
                </li>
                <?php if( isset( $_SESSION['connected'] ) ){
                    echo "<li class='nav-item'><a class='nav-link' href='Profile.php'><i class='fa-solid fa-circle-user'></i>&nbsp;Profil</a></li>";
                } 
                if( isset( $_SESSION['role']) && ($_SESSION['role'] == 2) ){
                    echo "<li class='nav-item'><a class='nav-link' href='UserManagement.php'><i class='fa-solid fa-users-gear'></i></i>&nbsp;Gestion des utilisateurs</a></li>";
                }
                if( isset( $_SESSION['role']) && ($_SESSION['role'] == 2) ){
                    echo "<li class='nav-item'><a class='nav-link' href='CommentManagement.php'><i class='fa-solid fa-comments'></i></i>&nbsp;Modération des commentaires</a></li>";
                }
                if( isset( $_SESSION['role']) && $_SESSION['role'] != 1 ){
                    echo "<li class='nav-item'><a class='nav-link' href='CreatedTicket.php'><i class='fa-solid fa-ticket'></i>&nbsp;Création d'un billet</a></li>";
                }if( isset( $_SESSION['connected'] ) ){
                    echo "<li class='nav-item'><a class='nav-link' style='color:red' href='Logout.php'><i class='fa-solid fa-door-open'></i>&nbsp;Déconnexion</a></li>";
                } ?>
            </ul>
        </div>
    </div>
</header>
<body>
<section class="container mt-5">
    <div class="row">
        <div class="col-12">
            <?php 
                foreach($tableBlog as $key => $val) :
            ?>
                <div class="card">
                    <h5 class="card-header">Publié le <?=date("d/m/Y à H:i:s", strtotime($val['CreationDate']))?></h5>
                    <div class="card-body">
                        <h5 class="card-title"><?=$val['Title']?></h5>
                        <p class="card-text"><?=$val['Content']?></p>
                    </div>
                </div>
            <?php
                endforeach;
            ?>
        </div>
    </div>
</section>

<section class="container mt-5">
    <?php
        if( isset( $_GET['error'] ) || isset( $_GET['validation'] )) {
            echo '<div class="row"><p class="col-10 alert '.$alert.'">' . $mess .'</p></div>';
        }
    ?>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <h3>Commentaires</h3>
                <?php if( isset( $_SESSION['connected'] ) ) : ?>
                    <button type="button" class="btn btn-outline-primary btn-lg" style="margin-bottom: 15px" data-toggle="modal" data-target="#exampleModal" id="createCommentaryModal"><i class="fa-solid fa-comment-medical"></i>&nbsp;Création d'un commentaire</button>
                <?php
                    endif;
                ?>
            </div>
            <?php
                foreach($tableCommentaires as $key => $val) :
            ?>
                <div class="list-group col-12">
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?=$val['Autor']?></h5>
                            <small><?=$val['Autor']?> le <?=date("d/m/Y à H:i:s", strtotime($val['CreationDate']))?></small>
                        </div>
                        <div class="d-flex align-items-center row">
                            <p class="mb-1 col-11"><?=$val['Content']?></p>
                            <?php if( isset( $_SESSION['connected'] ) && $val['Autor'] == $_SESSION['login'] ) : ?>
                                <button type="submit" class="btn btn-danger col-1" name="deleteComment" data-ticketId="<?=$idBillet?>" data-commentaryId="<?=$val['Id']?>"><i class="fa-solid fa-trash-can"></i></button>
                            <?php 
                                endif; 
                            ?>
                        </div>
                </div>
            <?php
                endforeach;
            ?>
        </div>
    </div>
</section>

<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form name="accesform" method="post" action="SaveCommentaire.php">
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

        const buttonsDeleteComment = document.getElementsByName("deleteComment");
        buttonsDeleteComment.forEach((button) => {
            button.onclick = function() {
                var xhr = new XMLHttpRequest();
                // Spécifiez le type de requête (GET ou POST), l'URL du script PHP, et indiquez s'il s'agit d'une requête asynchrone.
                xhr.open("POST", "DeleteComment.php", true);

                // Définissez l'en-tête de la requête pour indiquer que vous envoyez des données au format formulaire.
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {

                };

                // Créez une chaîne de requête en formatant vos données.
                var params = "ticketId="+ button.dataset.ticketid + "&commentaryId=" + button.dataset.commentaryid;
                
                // Envoyez la requête avec les données.
                xhr.send(params);

                location.reload();
            };
        });
    });
</script>
</body>
</html>