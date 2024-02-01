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
    $sql = 'SELECT * FROM Ticket ORDER BY CreationDate DESC ';
    $reponse = $bdd->prepare( $sql );
    $reponse->execute();
    $tableBlog = $reponse->fetchAll(PDO::FETCH_ASSOC);

    $style = "";
    if( isset( $_SESSION['connected'] ) ){
        if ( isset( $_SESSION['id'] ) ){
            $sql = 'SELECT RoleId FROM User WHERE Id = :id';
            $reponse = $bdd->prepare( $sql );
            $reponse->execute(array(':id'=>$_SESSION['id']));
            $role = $reponse->fetch(PDO::FETCH_ASSOC);
            $_SESSION['role'] = $role["RoleId"];
        }
        $style = "style='display:none'";
    }
    $login= "";
    if (isset( $_SESSION['login'])){
        $login = $_SESSION['login'];
    }
?>

<body>
    <header>
        <div class="row" style="margin-top: 1%; margin-bottom: 1%; margin-left: 0%; margin-right: 0%; padding-left: 1%; padding-right: 1%;">
            <div class="col-3">
                <h1>Mon blog</h1>
            </div>
            <div class="col-9">
                <ul class="nav nav-tabs justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i>&nbsp;Accueil</a>
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

    <section class="container">
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
                            <a href="Commentaires.php?idBillet=<?=$val['Id']?>" class="btn btn-primary">Commentaires</a>
                        </div>
                    </div>
                    <br>
                <?php
                    endforeach;
                ?>
            </div>
        </div>
    </section>
</body>