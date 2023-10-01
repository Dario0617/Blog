<?php
session_start();
?>
<html lang="fr">
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../CSS/bootstrap.css" />
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
    $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
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
            <h3>Commentaires</h3>
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