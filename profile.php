<?php
    session_start();
    if(isset ($_SESSION['id'])){
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch (Exception $e){
            die('Erreur :' . $e->getMessage());
        }
    
        $id = $_SESSION['id'];
    
        $sql = 'SELECT * FROM users WHERE id=:id';
        $reponse = $bdd->prepare($sql);
        $reponse->execute([':id'=>$id]);
    
        $valeurs = $reponse->fetch(pdo::FETCH_ASSOC);

        $profilePicture = $valeurs['image'];
        $login = $valeurs['login'];

        $profilePictureExist = false;
        if($profilePicture != null){
            $profilePictureExist = true;
        }
    }
    $_SESSION['connected'] = true;
?>

<html lang="fr">
<head>
    <title>Profile</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="https://kit.fontawesome.com/d576863e16.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="row" style="margin-top: 20px; margin-bottom: 20px; padding-left: 20px; padding-right:20px;">
            <div class="col-3">
                <h1>Mon profile</h1>
            </div>
            <div class="col-9">
                <ul class="nav nav-tabs justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i>&nbsp;Accueil</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link active' href='Profile.php'><i class="fa-solid fa-circle-user"></i>&nbsp;Profil</a>
                    </li>
                    <?php
                    if( isset( $_SESSION['role']) && ($_SESSION['role'] == 2) ){
                        echo "<li class='nav-item'><a class='nav-link' href='UserManagement.php'><i class='fa-solid fa-users-gear'></i></i>&nbsp;Gestion des utilisateurs</a></li>";
                    }
                    if( isset( $_SESSION['role']) && ($_SESSION['role'] == 2) ){
                        echo "<li class='nav-item'><a class='nav-link' href='Profile.php'><i class='fa-solid fa-comments'></i></i>&nbsp;Modération des commentaires</a></li>";
                    }
                    if( isset( $_SESSION['role']) && $_SESSION['role'] != 1 ){
                        echo "<li class='nav-item'><a class='nav-link' href='CreatedTicket.php'><i class='fa-solid fa-ticket'></i>&nbsp;Création d'un billet</a></li>";
                    }?>
                    <li class='nav-item'>
                        <a class='nav-link' style='color:red' href='Logout.php'><i class='fa-solid fa-door-open'></i>&nbsp;Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <section class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Login: <?=$login?></h5>
                    <div class="card-body">
                        <?php
                        if ($profilePictureExist){
                            echo '<img src="images/' . $profilePicture . '" style="height: 100px;"/>';
                        }
                        else{
                            echo '<p>Pas de photo de profil, <a aria-current="page" href="SendProfilePicture.php">Mettre une photo de profile</a></p>';
                        }
                        ?>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </section>


</body>