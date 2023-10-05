<?php
session_start();
?>
<html lang="fr">
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css" />
</head>
<header>
    <section class="container mt-5">
        <div class="row">
            <div class="col-4">
                <a href="index.php" class="btn btn-primary">Liste des tickets</a>
            </div>
        </div>
    </section>
</header>
<?php

$id=$_GET['id'];

try {
    $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
} catch( Exception $e) {
    die( 'Erreur : ' . $e->getMessage() );
}
$sql = 'SELECT * FROM billets WHERE id=:id';
$reponse = $bdd->prepare( $sql );
$reponse->execute([':id' => $id]);
$tableBlog = $reponse->fetchAll(PDO::FETCH_ASSOC);

$sql = 'SELECT * FROM commentaires WHERE id_billet=:id';
$reponse = $bdd->prepare( $sql );
$reponse->execute([':id' => $id]);
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
                    <h5 class="card-header">publié le <?=date("d/m/Y à H:i:s", strtotime($val['date_creation']))?></h5>
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
                <?php
                    if( isset($_SESSION['connected']) ){
                        echo '<button type="button" class="btn btn-outline-primary btn-lg" id="createCommentaryModal">Open Small Modal</button>';
                    }
                ?>
            </div>
            <?php
                foreach($tableCommentaires as $key => $val){
            ?>
            <div class="list-group">
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?=$val['auteur']?></h5>
                        <small><?=$val['auteur']?> le <?=date("d/m/Y à H:i:s", strtotime($val['date_commentaire']))?></small>
                    </div>
                    <p class="mb-1"><?=$val['commentaire']?></p>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</section>

<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">×</span>
    <div id="modal-content"></div>
  </div>
</div>
<script>
$(document).ready(function() {
  // Au clic sur le bouton, ouvrir le modal et charger le contenu de la page PHP
  $("#createCommentaryModal").click(function() {
    $("#myModal").show(); // Afficher le modal
    //$("#modal-content").load("page.php"); // Charger le contenu de la page PHP dans la div du modal
  });

  // Au clic sur le bouton de fermeture, cacher le modal
  $(".close").click(function() {
    $("#myModal").hide(); // Cacher le modal
  });
});
</script>
</body>
</html>