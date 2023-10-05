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
</head>

<body>
    <header>
        <div class="row" style="margin-top: 20px; padding-left: 20px; padding-right:20px;">
            <div class="col-8">
                <h1>Mon profile</h1>
            </div>
            <div class="col-4">
                <ul class="nav nav-tabs justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                                <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/>
                            </svg>
                            Accueil
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link active' href='profile.php'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
                                <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z'/>
                                <path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z'/>
                            </svg>
                            Profile
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <section class="container">
        <?php
            echo '<div class="col-12" style="float:right;display: flex;flex-direction: row-reverse;">
            <form name="accesform" method="post" action="logout.php">
            <button type="submit" class="btn btn-danger">Déconnexion</button>
            </form></div>';
        ?>
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
                            echo '<p>Pas de photo de profil, <a aria-current="page" href="sendProfilePicture.php">Mettre une photo de profile</a></p>';
                        }
                        ?>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </section>


</body>