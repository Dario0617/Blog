<?php
    session_start();
    if(isset ($_SESSION['role']) && $_SESSION['role'] == 2){
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch (Exception $e){
            die('Erreur :' . $e->getMessage());
        }
    
        $id = $_SESSION['id'];
    
        $sql = 'SELECT * FROM User where Id <> :id';
        $reponse = $bdd->prepare($sql);
        $reponse->execute([':id'=>$id]);
    
        $users = $reponse->fetchAll(pdo::FETCH_ASSOC);

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
        $mess = 'Mot de passe changé avec succès';
    }
?>

<html lang="fr">
<head>
    <title>Gestion des utilisateurs</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="https://kit.fontawesome.com/d576863e16.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="row" style="margin-top: 1%; margin-bottom: 1%; margin-left: 0%; margin-right: 0%; padding-left: 1%; padding-right: 1%;">
            <div class="col-3" style="display: contents">
                <h1>Liste des utilisateurs</h1>
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
                        echo "<li class='nav-item'><a class='nav-link active' href='UserManagement.php'><i class='fa-solid fa-users-gear'></i></i>&nbsp;Gestion des utilisateurs</a></li>";
                    }
                    if( isset( $_SESSION['role']) && ($_SESSION['role'] == 2) ){
                        echo "<li class='nav-item'><a class='nav-link' href='CommentManagement.php'><i class='fa-solid fa-comments'></i></i>&nbsp;Modération des commentaires</a></li>";
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
                            <th scope="col">Role</th>
                            <th scope="col">Login</th>
                            <th scope="col">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($users as $key => $user){
                    ?>
                        <tr>
                            <th scope="row"><?=$user['Id']?></td>
                            <td><?php if ($user['RoleId'] == 1) {
                                echo 'Utilisateur';
                            } else if ($user['RoleId'] == 2) {
                                echo 'Admin';
                            } else{
                                echo 'Editeur';
                            }
                            ?>
                            </td>
                            <td><?=$user['Login']?></td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-userId=<?=$user['Id']?> name="changePassword" id="changePassword<?=$user['Id']?>"><i class="fa-solid fa-key"></i></i>&nbsp;Modification du mot de passe</button>
                                <?php 
                                if ($user['RoleId'] != 2) : ?>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-userId=<?=$user['Id']?> name="changeToAdmin" id="changeToAdmin<?=$user['Id']?>"><i class="fa-solid fa-user-shield"></i></i></i>&nbsp;Passer au rôle "Admin"</button>
                                <?php endif;
                                if ($user['RoleId'] != 1) : ?>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-userId=<?=$user['Id']?> name="changeToUser" id="changeToUser<?=$user['Id']?>"><i class="fa-solid fa-user"></i></i>&nbsp;Passer au rôle "Utilisateur"</button>
                                <?php endif;
                                if ($user['RoleId'] != 3) : ?>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-userId=<?=$user['Id']?> name="changeToEditor" id="changetoEditor<?=$user['Id']?>"><i class="fa-solid fa-user-pen"></i></i>&nbsp;Passer au rôle "Editeur"</button>
                                <?php 
                                endif;
                                ?>
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

<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form name="accesform" method="post" action="ChangePassword.php">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-comment-medical"></i>&nbsp;Modification mot de passe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="inputPassword" class="col-form-label">Mot de passe</label>
                <input type="password" class="form-control" id="inputPassword" name="password" required>
                <label for="inputConfirmPassword" class="col-form-label">Confirmer mot de passe</label>
                <input type="password" class="form-control" id="inputConfirmPassword" name="confirmPassword" required>
                <input type="hidden" id="userId" name="userId" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" data-dismiss="modal">Fermer</button>
                <button type="submit" id="saveCommentary" class="btn btn-primary">Sauvegarder</button>
            </div>
        </form>
    </div>
  </div>
</div>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        const elems = document.getElementsByName("changePassword");
        elems.forEach((element) => {
            element.onclick = function() {
                document.getElementById("exampleModal").style.display = 'block';
                document.getElementById("userId").value = element.dataset.userid;
            };
        });

        const elem2 = document.getElementsByClassName("close");
        elem2[0].onclick = function() {
            document.getElementById("exampleModal").style.display = 'none';
        };
        elem2[1].onclick = function() {
            document.getElementById("exampleModal").style.display = 'none';
        };

        const buttonsChangeToAdmin = document.getElementsByName("changeToAdmin");
        buttonsChangeToAdmin.forEach((button) => {
            button.onclick = function() {
                var xhr = new XMLHttpRequest();
                // Spécifiez le type de requête (GET ou POST), l'URL du script PHP, et indiquez s'il s'agit d'une requête asynchrone.
                xhr.open("POST", "ChangeRole.php", true);

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
                var params = "roleId=2&userId="+button.dataset.userid;
               
                // Envoyez la requête avec les données.
                xhr.send(params);   
                
                location.reload();
            };
        });
        const buttonsChangeToUser = document.getElementsByName("changeToUser");
        buttonsChangeToUser.forEach((button) => {
            button.onclick = function() {
                var xhr = new XMLHttpRequest();
                // Spécifiez le type de requête (GET ou POST), l'URL du script PHP, et indiquez s'il s'agit d'une requête asynchrone.
                xhr.open("POST", "ChangeRole.php", true);

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
                var params = "roleId=1&userId="+button.dataset.userid;
                
                // Envoyez la requête avec les données.
                xhr.send(params);

                location.reload();
            };
        });
        const buttonsChangeToEditor = document.getElementsByName("changeToEditor");
        buttonsChangeToEditor.forEach((button) => {
            button.onclick = function() {
                var xhr = new XMLHttpRequest();
                // Spécifiez le type de requête (GET ou POST), l'URL du script PHP, et indiquez s'il s'agit d'une requête asynchrone.
                xhr.open("POST", "ChangeRole.php", true);

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
                var params = "roleId=3&userId="+button.dataset.userid;
                
                // Envoyez la requête avec les données.
                xhr.send(params);

                location.reload();
            };
        });
});
</script>

</body>