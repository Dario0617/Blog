<?php
    session_start();

    if( isset( $_POST['login'] ) && isset( $_POST['password'] ) && isset( $_POST['confirmPassword'] )) {
        $login = htmlentities($_POST['login'],ENT_COMPAT,"ISO-8859-1",true);
        $password = htmlentities($_POST['password'],ENT_COMPAT,"ISO-8859-1",true);
        $confirmPassword = htmlentities($_POST['confirmPassword'],ENT_COMPAT,"ISO-8859-1",true);
        if (!(strlen($password) >= 8)){
            $_SESSION['login'] = $login;
            header('Location:Inscription.php?error=1&passerror=1&login='.$login);
            die;
        }
        if ($password !== $confirmPassword){
            $_SESSION['login'] = $login;
                header('Location:Inscription.php?error=1&confirmPasserror=1&login='.$login);
                die;
        }
        try {
            $bdd = new PDO('mysql:host=localhost:3306;dbname=dario;charset=utf8', 'dario', 'dab3oeP-');
        } catch( Exception $e) {
            die( 'Erreur : ' . $e->getMessage() );
        }
        $sql = 'SELECT * FROM User WHERE Login=:login';
        $reponse = $bdd->prepare( $sql );
        $reponse->execute( [':login'=>$login] );

        if( $acces = $reponse->fetch(PDO::FETCH_ASSOC) ) {
            header('Location:Inscription.php?error=1&loginerror=1');
            $_SESSION['login'] = $login;
            die;
        } else {
            $password = sodium_crypto_pwhash_str($password, SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, 
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);
            $roleUser = 1;
            $sql = 'INSERT INTO User (Login, Password, RoleId) VALUES (:login,:password, :roleId)';
            $reponse = $bdd->prepare( $sql );
            $reponse->execute(array(':login'=>$login, ':password'=>$password, ':roleId'=>$roleUser));
            if (!$reponse){
                echo "Erreur lors de l'enregistrement";
                die;
            }
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            $_SESSION['id'] = $bdd->lastInsertId();
            header('Location:SendProfilePicture.php');
            die;
        }
    }
?>