<?php
    session_start();
    if(isset ($_SESSION['role']) && $_SESSION['role'] == 2){
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch (Exception $e){
            die('Erreur :' . $e->getMessage());
        }
    
        $id = $_SESSION['id'];
    
        $sql = 'SELECT * FROM Comment WHERE Verify = :verify';
        $reponse = $bdd->prepare($sql);
        $reponse->execute([':verify'=>0]);
    
        $comments = $reponse->fetchAll(pdo::FETCH_ASSOC);
    }

    $mess = '';
    if( isset( $_GET['error'] ) ) {
        if( isset( $_GET['passerror'] ) ) {
            $alert = 'alert-danger';
            $mess = 'Erreur : Le mot de passe doit contenir au minimum 8 caractères !';
        }
        if( isset( $_GET['confirmPasserror'] ) ) {
            $alert = 'alert-danger';
            $mess = 'Erreur : Les mots de passe doivent être identiques !';
        }
    }
    if( isset( $_GET['validation'] ) ){
        $alert = 'alert-success';
        $mess = 'Commentaire vérifié avec succès';
        if (isset ($_GET['rejected'])){
            $mess = 'Commentaire rejeté avec succès';
        }
    }
?>

<html lang="fr">
<head>
    <title>Modération des commentaires</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="https://kit.fontawesome.com/d576863e16.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="row" style="margin-top: 1%; margin-bottom: 1%; margin-left: 0%; margin-right: 0%; padding-left: 1%; padding-right: 1%;">
            <div class="col-3">
                <h1>Modération des commentaires</h1>
            </div>
            <div class="col-9" style="padding-left: 5%;">
                <ul class="nav nav-tabs justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i>&nbsp;Accueil</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='Profile.php'><i class="fa-solid fa-circle-user"></i>&nbsp;Profil</a>
                    </li>
                    <?php
                    if( isset( $_SESSION['role']) && ($_SESSION['role'] == 2) ){
                        echo "<li class='nav-item'><a class='nav-link' href='UserManagement.php'><i class='fa-solid fa-users-gear'></i></i>&nbsp;Gestion des utilisateurs</a></li>";
                    }
                    if( isset( $_SESSION['role']) && ($_SESSION['role'] == 2) ){
                        echo "<li class='nav-item'><a class='nav-link active' href='CommentManagement.php'><i class='fa-solid fa-comments'></i></i>&nbsp;Modération des commentaires</a></li>";
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
        <?php
            if( isset( $_GET['error'] ) || isset( $_GET['validation'] )) {
                echo '<div class="row"><p class="col-10 alert '.$alert.'">' . $mess .'</p></div>';
            }
        ?>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">N°Billet</th>
                            <th scope="col">Auteur</th>
                            <th scope="col">Commentaire</th>
                            <th scope="col">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($comments as $key => $comment){
                    ?>
                        <tr>
                            <th scope="row"><?=$comment['Id']?></td>
                            <td><?=$comment['TicketId']?></td>
                            <td><?=$comment['Autor']?></td>
                            <td><?=$comment['Content']?></td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-commentId=<?=$comment['Id']?> name="commentAccepted" id="commentAccepted<?=$comment['Id']?>"><i class="fa-solid fa-circle-check"></i>&nbsp;Commentaire accepté</button>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-commentId=<?=$comment['Id']?> name="commentRejected" id="commentRejected<?=$comment['Id']?>"><i class="fa-solid fa-comment-slash"></i>&nbsp;Commentaire rejeté</button>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        const buttonsCommentAccepted = document.getElementsByName("commentAccepted");
        buttonsCommentAccepted.forEach((button) => {
            button.onclick = function() {
                var xhr = new XMLHttpRequest();
                // Spécifiez le type de requête (GET ou POST), l'URL du script PHP, et indiquez s'il s'agit d'une requête asynchrone.
                xhr.open("POST", "VerifiedComment.php", true);

                // Définissez l'en-tête de la requête pour indiquer que vous envoyez des données au format formulaire.
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                // Définissez la fonction de rappel à appeler lorsque la requête est terminée.
                xhr.onload = function () {
                    // Assuming the PHP script sets a header for redirection
                    var redirectUrl = xhr.responseURL;

                    if (redirectUrl) {
                        // Redirect the user to the new page
                        window.location.href = redirectUrl;
                    }
                };
                // Créez une chaîne de requête en formatant vos données.
                var params = "commentId=" + button.dataset.commentid;
               
                // Envoyez la requête avec les données.
                xhr.send(params);
            };
        });

        const buttonsCommentRejected = document.getElementsByName("commentRejected");
        buttonsCommentRejected.forEach((button) => {
            button.onclick = function() {
                var xhr = new XMLHttpRequest();
                // Spécifiez le type de requête (GET ou POST), l'URL du script PHP, et indiquez s'il s'agit d'une requête asynchrone.
                xhr.open("POST", "VerifiedComment.php", true);

                // Définissez l'en-tête de la requête pour indiquer que vous envoyez des données au format formulaire.
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                // Définissez la fonction de rappel à appeler lorsque la requête est terminée.
                xhr.onload = function () {
                    // Assuming the PHP script sets a header for redirection
                    var redirectUrl = xhr.responseURL;

                    if (redirectUrl) {
                        // Redirect the user to the new page
                        window.location.href = redirectUrl;
                    }
                };
                // Créez une chaîne de requête en formatant vos données.
                var params = "commentId=" + button.dataset.commentid + "&rejected=1";
               
                // Envoyez la requête avec les données.
                xhr.send(params);
            };
        });
});
</script>

</body>