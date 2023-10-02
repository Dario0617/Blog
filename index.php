<?php
session_start();
?>
<html lang="fr">
<head>
    <title>Mon super blog !</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../CSS/bootstrap.css" />
</head>

<?php
    try {
        $bdd = new PDO('mysql:host=51.178.86.117;dbname=blog;charset=utf8', 'dario', 'dab3oeP-');
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
                        <a class="nav-link active" aria-current="page" href="index.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/>
                            </svg>
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item" <?php echo $style;?>>
                        <a class="nav-link" href="connexion.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                            </svg>
                        Connexion
                        </a>
                    </li>
                    <li class="nav-item" <?php echo $style;?>>
                        <a class="nav-link" href="Inscription.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        Inscription</a>
                    </li>
                    <?php if( isset( $_SESSION['connected'] ) ){
                        echo "<li class='nav-item'><a class='nav-link' href='profile.php'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
                            <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z'/>
                            <path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z'/>
                            </svg>
                            Profile</a></li>";
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
                <button type="submit" class="btn btn-outline-danger">Déconnexion</button>
                </form></div>';
            }
        ?>
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
                            <a href="commentaires.php?id=<?=$val['id']?>" class="btn btn-primary">Commentaires</a>
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