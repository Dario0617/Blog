<?php
session_start();
?>
<html lang="fr">
<head>
    <title>Mon super blog !</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="https://kit.fontawesome.com/d576863e16.js" crossorigin="anonymous"></script>
</head>

<?php
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
    } catch( Exception $e) {
        die( 'Erreur : ' . $e->getMessage() );
    }
    $sql = 'SELECT * FROM billets ORDER BY date_creation DESC ';
    $reponse = $bdd->prepare( $sql );
    $reponse->execute();
    $tableBlog = $reponse->fetchAll(PDO::FETCH_ASSOC);

    $style = "";
    if( isset( $_SESSION['connected'] ) ){
        $style = "style='display:none'";
    }
    $login= "";
    if (isset( $_SESSION['login'])){
        $login = $_SESSION['login'];
    }
?>

<body>
    <header>
        <div class="row" style="margin-top: 20px; padding-left: 20px; padding-right:20px;">
            <div class="col-8">
                <h1>Mon blog</h1>
            </div>
            <div class="col-4">
                <ul class="nav nav-tabs justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i>&nbsp;Accueil</a>
                    </li>
                    <li class="nav-item" <?php echo $style;?>>
                        <a class="nav-link" href="connexion.php"><i class="fa-solid fa-circle-user"></i>&nbsp;Connexion</a>
                    </li>
                    <li class="nav-item" <?php echo $style;?>>
                        <a class="nav-link" href="Inscription.php"><i class="fa-solid fa-user-plus"></i>&nbsp;Inscription</a>
                    </li>
                    <?php if( isset( $_SESSION['connected'] ) ){
                        echo "<li class='nav-item'><a class='nav-link' href='profile.php'><i class='fa-solid fa-circle-user'></i>Profile</a></li>";
                    } ?>
                </ul>
            </div>
        </div>
    </header>

    <section class="container">
        <?php
            if( isset( $_SESSION['connected'] ) ){
                echo '<div class="row" style="margin-bottom: 10px"><div class="col-9"><h4>Bienvenue ' . 
                $login . '</h4></div><div class="col-3" style="display: flex;justify-content: space-evenly;">
                <a class="btn btn-outline-primary" href="createdTicket.php" style="margin-bottom: 20px;">Créer un billet</a>
                <form name="accesform" method="post" action="logout.php">
                <button type="submit" class="btn btn-danger">Déconnexion</button>
                </form></div>';
            }
        ?>
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
                            <a href="commentaires.php?idBillet=<?=$val['id']?>" class="btn btn-primary">Commentaires</a>
                        </div>
                    </div>
                    <br>
                <?php
                    }
                ?>
            </div>
        </div>
    </section>


</body>